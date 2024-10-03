<?php

include_once('connection.php');
include_once('user.php');

class Files extends DB
{
    private $file;
    private $type;
    private $userId;
    private $activityId;
    private $user;
    private $conn;

    public function __construct()
    {
        $this->file = $_FILES['file'];
        $this->type = $_POST['type'];
        $this->userId = $_POST['userId'];
        $this->activityId = $_POST['activityId'];
        $this->conn = (new DB())->connect();
    }

    public function uploadAndRegisterFile()
    {
        if ($this->file) {
            $results = $this->registerFileInDBAndSave();
            http_response_code(201);
            return [
                'message' => 'Archivo recibido con éxito',
                'fileName' => $this->file['name'],
                'type' => $this->type,
                'username' => $this->user[1] . ' ' . $this->user[2],
                'results' => $results
            ];
        } else {
            http_response_code(400);
            return ['error' => 'No se recibió ningún archivo'];
        }
    }

    function registerFileInDBAndSave()
    {
        try {
            $previousFile = '';
            $this->user = mysqli_fetch_row($this->conn->query('SELECT * FROM usuarios WHERE id=' . $this->userId)) or die($this->conn->error);
            $userWeb = mysqli_fetch_row($this->conn->query('SELECT * FROM usuario_web WHERE id_usuario=' . $this->userId)) or die($this->conn->error);
            $username = $this->user[1] . ' ' . $this->user[2];
            $userWebFolder = $userWeb[5];
            $results = [];
            switch ($this->type) {
                case 'work':
                    $previousFile = $this->registerFileActivityDB();
                    break;
                case 'homework':
                    $previousFile = $this->registerFileHomeworkDB();
                    break;
                default:
                    break;
            }
            $deletedPreviousFile = $this->deletePreviousFile($userWebFolder, $previousFile);
            $savedFile = $this->saveFile($userWebFolder);
            $results = [
                'deletedPreviousFile' => $deletedPreviousFile == 0 ? 'success' : 'error #' . $deletedPreviousFile,
                'savedFile' => $savedFile == 0 ? 'success' : 'error #' . $savedFile
            ];
        } catch (Exception $e) {
            http_response_code(400);
            $results = [
                'error' => 'Error al registrar archivo: ' . $e->getMessage()
            ];
        }
        return $results;
    }

    function registerFileActivityDB()
    {
        $duplicatedAct = $this->conn->query("SELECT * FROM trabajos_usuarios WHERE id_trabajo={$this->activityId} AND id_usuario={$this->userId}") or die($this->conn->error);
        if ($duplicatedAct) {
            $row = mysqli_fetch_row($duplicatedAct);
            $id = $row[0];
            $previousFile = $row[3];
            $query = $this->conn->query("UPDATE trabajos_usuarios SET revisado=1, adjunto='{$this->file['name']}' WHERE id={$id}");
            return $previousFile;
        } else {
            $query = mysqli_fetch_row($this->conn->query("INSERT INTO trabajos_usuarios (id_trabajo, id_usuario, revisado, adjunto) VALUES ('{$this->activityId}', '{$this->userId}', '1', '{$this->file['name']}')")) or die($this->conn->error);
            return '';
        }
    }

    function registerFileHomeworkDB()
    {
        $duplicatedAct = $this->conn->query("SELECT * FROM tareas_usuarios WHERE id_tarea={$this->activityId} AND id_usuario={$this->userId}") or die($this->conn->error);
        if ($duplicatedAct) {
            $row = mysqli_fetch_row($duplicatedAct);
            $id = $row[0];
            $previousFile = $row[3];
            $query = $this->conn->query("UPDATE tareas_usuarios SET revisado=1, adjunto='{$this->file['name']}' WHERE id={$id}");
            return $previousFile;
        } else {
            $query = mysqli_fetch_row($this->conn->query("INSERT INTO tareas_usuarios (id_tarea, id_usuario, revisado, adjunto) VALUES ('{$this->activityId}', '{$this->userId}', '1', '{$this->file['name']}')")) or die($this->conn->error);
            return '';
        }
    }

    function saveFile($userWebFolder)
    {
        $folder = $this->type == 'work' ? 'trabajos' : 'tareas';
        $destPath = "../{$userWebFolder}/{$folder}/{$this->file['name']}";
        if (move_uploaded_file($this->file['tmp_name'], $destPath)) {
            // echo 'Archivo creado exitosamente.';
            return 0;
        } else {
            // echo 'Error al mover el archivo.';
            return 1;
        }
    }

    function deletePreviousFile($userWebFolder, $previousFile)
    {
        $folder = $this->type == 'work' ? 'trabajos' : 'tareas';
        $srcPath = "../{$userWebFolder}/{$folder}/{$previousFile}";
        if (file_exists($srcPath)) {
            if (unlink($srcPath)) {
                // echo 'Archivo borrado exitosamente.';
                return 0;
            } else {
                // echo 'Error al borrar el archivo.';
                return 2;
            }
        } else {
            // echo 'El archivo no existe.';
            return 1;
        }
    }
}

class Documents extends DB
{
    private $file;
    private $userId;
    private $userWeb;
    private $user;
    private $conn;

    public function __construct()
    {
        $this->file = $_FILES['file'];
        $this->userId = $_POST['userId'];
        $this->conn = (new DB())->connect();
        $this->userWeb = new UserWeb($this->userId);
        $this->userWeb->setUserWeb();
    }

    public function uploadAndRegisterDocument()
    {
        if ($this->file) {
            $results = $this->registerDocumentInDBAndSave();
            http_response_code(201);
            return [
                'message' => 'Archivo recibido con éxito',
                'documentName' => $this->file['name'],
                'username' => $this->user[1] . ' ' . $this->user[2],
                'results' => $results
            ];
        } else {
            http_response_code(400);
            return ['error' => 'No se recibió ningún archivo'];
        }
    }

    function registerDocumentInDBAndSave()
    {
        try {
            $this->user = mysqli_fetch_row($this->conn->query('SELECT * FROM usuarios WHERE id=' . $this->userId)) or die($this->conn->error);
            $documentDbName = '';
            $previousFile = '';
            switch ($_POST['documentName']) {
                case 'resume':
                    $documentDbName = 'nombre_cv';
                    $previousFile = $this->userWeb->getCv();
                    break;
                case 'registration':
                    $documentDbName = 'formato_inscripcion';
                    $previousFile = $this->userWeb->getInscription();
                    break;
                case 'id-front':
                    $documentDbName = 'id_frontal';
                    $previousFile = $this->userWeb->getIdFront();
                    break;
                case 'id-back':
                    $documentDbName = 'id_trasera';
                    $previousFile = $this->userWeb->getIdBack();
                    break;
                default:
                    break;
            }
            $results = [];
            $isRegistered = $this->registerDocumentDB($documentDbName);
            $deletedPreviousFile = $this->deletePreviousDocument($previousFile);
            $savedFile = $this->saveDocument();
            $results = [
                'deletedPreviousFile' => $isRegistered ? 'success' : 'error #' . $deletedPreviousFile,
                'savedFile' => $savedFile == 0 ? 'success' : 'error #' . $savedFile
            ];
        } catch (Exception $e) {
            http_response_code(400);
            $results = [
                'error' => 'Error al registrar archivo: ' . $e->getMessage()
            ];
        }
        return $results;
    }

    function registerDocumentDB($documentDbName)
    {
        $query = $this->conn->query("UPDATE modulo_personal SET {$documentDbName}='{$this->file['name']}' WHERE id_usuario={$this->userId}");
        return $query;
    }

    function saveDocument()
    {
        $destPath = "../{$this->userWeb->getUserPath()}documentos/{$this->file['name']}";
        if (move_uploaded_file($this->file['tmp_name'], $destPath)) {
            // echo 'Archivo creado exitosamente.';
            return 0;
        } else {
            // echo 'Error al mover el archivo.';
            return 1;
        }
    }

    function deletePreviousDocument($previousFile)
    {
        $srcPath = "../{$this->userWeb->getUserPath()}documentos/{$previousFile}";
        if ($previousFile!= '' && file_exists($srcPath)) {
            if (unlink($srcPath)) {
                // echo 'Archivo borrado exitosamente.';
                return 0;
            } else {
                // echo 'Error al borrar el archivo.';
                return 2;
            }
        } else {
            // echo 'El archivo no existe.';
            return 1;
        }
    }
}