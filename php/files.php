<?php

include_once('connection.php');

class Files extends DB
{
    private $file;
    private $type;
    private $userId;
    private $activityId;
    private $user;
    private $conn;

    public function __construct($file, $type, $userId, $activityId)
    {
        $this->file = $file;
        $this->type = $type;
        $this->userId = $userId;
        $this->activityId = $activityId;
        $this->conn = (new DB())->connect();
    }

    public function uploadAndRegisterFile()
    {
        if ($this->file) {
            $username = $this->registerFileInDBAndSave();
            http_response_code(200);
            echo json_encode([
                'message' => 'Archivo recibido con éxito',
                'name' => $this->file['name'],
                'type' => $this->type,
                'username' => $username
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'No se recibió ningún archivo']);
        }
    }

    function registerFileInDBAndSave()
    {
        try {
            $previousFile = '';
            $this->user = mysqli_fetch_row($this->conn->query('SELECT * FROM usuarios WHERE id=' . $this->userId)) or die($this->conn->error);
            $username = $this->user[1] . ' ' . $this->user[2];
            switch ($this->type) {
                case 1:
                    $previousFile = $this->registerFileActivityDB();
                    break;
                case 2:
                    $previousFile = $this->registerFileHomeworkDB();
                    break;
                default:
                    break;
            }
            if ($previousFile !== '')
                $this->deletePreviousFile($this->type, $username, $previousFile);
            $this->saveFile($this->type, $username);
            return $username;
        } catch (Exception $e) {
            $error = ['error' => 'Error al registrar archivo: ' . $e->getMessage()];
            http_response_code(400);
            echo json_encode($error);
        }
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

    function saveFile($type, $username)
    {
        $folder = $type === 1 ? 'trabajos' : 'tareas';
        $destPath = "../resources/users/{$username}/{$folder}/{$this->file['name']}";
        if (move_uploaded_file($this->file['tmp_name'], $destPath)) {
            echo 'Archivo creado exitosamente.';
        } else {
            echo 'Error al mover el archivo.';
        }
    }

    function deletePreviousFile($type, $username, $previousFile)
    {
        // $folder = $type == 1 ? 'trabajos' : 'tareas';
        // $srcPath = "../resources/users/{$username}/{$folder}/{$previousFile}";
        // if (file_exists($srcPath)) {
        //     if (unlink($srcPath)) {
        //         echo 'Archivo borrado exitosamente.';
        //     } else {
        //         echo 'Error al borrar el archivo.';
        //     }
        // } else {
        //     echo 'El archivo no existe.';
        // }
    }
}