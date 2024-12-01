<?php

include_once('connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Tests
{
    private $userId;
    private $conn;
    private $admin;
    private $adminLevel;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB)->connect();
        $this->setAdminPermissions($userId);
    }

    function setAdminPermissions($userId)
    {
        $query = mysqli_fetch_row($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->admin = $query[0] > 1 ? true : false;
        $this->adminLevel = $query[0];
    }

    public function retrieveTestsPerUser()
    {
        $rows = $this->conn->query("SELECT examenes_usuarios.id, examenes.nombre, examenes.comentarios, examenes_usuarios.resultado, examenes_usuarios.fecha_aplicacion 
                FROM examenes, examenes_usuarios WHERE examenes_usuarios.id_examen = examenes.id_examen AND examenes_usuarios.id_usuario=" . $this->userId);
        $data = [];
        foreach ($rows as $row) {
            array_push($data, [
                'id' => $row['id'],
                'testName' => $row['nombre'],
                'comments' => $row['comentarios'],
                'result' => $row['resultado'],
                'dateApplied' => $row['fecha_aplicacion'],
            ]);
        }
        return $data;
    }

    public function retrieveActiveTestPerGroup()
    {
        $data = [];
        $rows = $this->conn->query("SELECT examenes.id_examen, examenes.nombre, examenes.comentarios, examenes.liga FROM examenes, examenes_grupos, usuarios 
        WHERE examenes_grupos.activo = 1 
        AND examenes_grupos.id_examen = examenes.id_examen 
        AND examenes_grupos.id_grupo=usuarios.id_grupo 
        AND usuarios.id={$this->userId}
        AND examenes.id_examen NOT IN (SELECT id_examen FROM examenes_usuarios WHERE id_usuario={$this->userId})");
        foreach ($rows as $row) {
            array_push($data, [
                'examId' => $row['id_examen'],
                'examName' => $row['nombre'],
                'comments' => $row['comentarios'],
                'link' => $row['liga'],
            ]);
        }
        return $data;
    }

    public function retrieveTestsAdmin()
    {
        if ($this->admin) {
            $rows = $this->conn->query("SELECT * FROM examenes");
            $data = [];
            foreach ($rows as $row) {
                array_push($data, [
                    'testId' => $row['id_examen'],
                    'testName' => $row['nombre'],
                    'comments' => $row['comentarios'],
                    'questions' => $this->retrieveTestQuestions($row['id_examen'])
                ]);
            }
            http_response_code(200);
            return $data;
        } else {
            http_response_code(403);
            return "Usuario no autorizado";
        }
    }

    function retrieveTestQuestions($testId)
    {
        if ($this->admin) {
            $data = [];
            $rows = $this->conn->query("SELECT * FROM examenes_reactivos WHERE id_examen = {$testId}");
            $data = [];
            foreach ($rows as $row) {
                array_push($data, [
                    'questionId' => $row['id_reactivo'],
                    'question' => $row['reactivo'],
                ]);
            }
            http_response_code(200);
            return $data;
        } else {
            http_response_code(403);
            return "Usuario no autorizado";
        }
    }

    public function retrieveExamsAdmin()
    {
        if ($this->admin) {
            http_response_code(200);
            return [
                'open' => $this->retrieveExamsByStatus(0),
                'active' => $this->retrieveExamsByStatus(1),
                'finished' => $this->retrieveFinishedExamsAdmin()
            ];
        } else {
            http_response_code(403);
            return "Usuario no autorizado";
        }
    }
    public function retrieveExamsByStatus($status)
    {
        $rows = $this->conn->query("SELECT eg.id AS exam_grupo_id, e.nombre AS examen_nombre, e.comentarios, e.liga, g.id_grupo AS id_grupo, g.sede, g.nombre_grupo, eg.fecha_aplicacion 
                FROM examenes_grupos eg, examenes e, grupos g
                WHERE eg.id_examen = e.id_examen
                AND eg.id_grupo=g.id
                AND eg.activo = {$status}");
        $data = [];
        foreach ($rows as $row) {
            array_push($data, [
                'egId' => $row['exam_grupo_id'],
                'testName' => $row['examen_nombre'],
                'groupNumber' => $row['id_grupo'],
                'groupLocation' => $row['sede'],
                'groupName' => $row['nombre_grupo'],
                'comments' => $row['comentarios'],
                'link' => $row['liga'],
                'dateApplied' => $row['fecha_aplicacion']
            ]);
        }
        return $data;
    }

    public function retrieveFinishedExamsAdmin()
    {
        $rows = $this->conn->query("SELECT examenes_usuarios.id, examenes.id_examen AS id_examen, examenes.nombre AS examen_nombre, usuarios.nombre AS usuario_nombre, usuarios.id AS id_usuario, usuarios.apellidos, examenes_usuarios.resultado, examenes_usuarios.fecha_aplicacion 
                FROM examenes_usuarios, examenes, usuarios 
                WHERE examenes_usuarios.id_usuario = usuarios.id
                AND examenes.id_examen=examenes_usuarios.id_examen");
        $data = [];
        foreach ($rows as $row) {
            array_push($data, [
                'id' => $row['id'],
                'testId' => $row['id_examen'],
                'testName' => $row['examen_nombre'],
                'userId' => $row['id_usuario'],
                'userName' => $row['usuario_nombre'] . ' ' . $row['apellidos'],
                'result' => $row['resultado'],
                'dateApplied' => $row['fecha_aplicacion']
            ]);
        }
        return $data;
    }

    public function retrieveAvailableGroups()
    {
        if ($this->admin) {
            $rows = $this->conn->query("SELECT * FROM grupos ORDER BY id_grupo DESC") or die($this->conn->error);
            $data = [];
            foreach ($rows as $row) {
                array_push($data, [
                    'groupId' => $row['id'],
                    'groupNumber' => $row['id_grupo'],
                    'groupName' => $row['nombre_grupo'],
                    'groupLocation' => $row['sede'],
                ]);
            }
            http_response_code(200);
            return $data;
        } else {
            http_response_code(403);
            return "Usuario no autorizado";
        }
    }

    public function getAvailableTestsByGroup()
    {
        if ($this->admin) {
            $rows = $this->conn->query("SELECT * FROM examenes WHERE id_examen NOT IN 
                    (SELECT id_examen FROM examenes_grupos WHERE id_grupo = {$_POST['groupId']})") or die($this->conn->error);
            $data = [];
            foreach ($rows as $row) {
                array_push($data, [
                    'testId' => $row['id_examen'],
                    'testName' => $row['nombre'],
                    'comments' => $row['comentarios'],
                    'link' => $row['liga'],
                ]);
            }
            return $data;
        } else {
            http_response_code(403);
            return "Usuario no autorizado";
        }
    }

    public function setExamByGroup()
    {
        if ($this->admin) {
            $query = $this->conn->query("INSERT INTO examenes_grupos (id_examen, id_grupo) VALUES ({$_POST['testId']}, {$_POST['groupId']})") or die($this->conn->error);
            if ($query) {
                http_response_code(201);
                return [
                    'testId' => $_POST['testId'],
                    'groupId' => $_POST['groupId'],
                    'status' => 0
                ];
            } else {
                http_response_code(400);
                return [
                    'error' => $this->conn->error
                ];
            }
        } else {
            http_response_code(403);
            return "Usuario no autorizado";
        }
    }

    public function setExamStatus($status)
    {
        if ($this->adminLevel > 2) {
            $query = $this->conn->query("UPDATE examenes_grupos SET activo={$status} WHERE id={$_POST['examId']}") or die($this->conn->error);
            if ($query) {
                http_response_code(200);
            } else {
                http_response_code(400);
                return [
                    'error' => $this->conn->error
                ];
            }
        } else {
            http_response_code(403);
            return ['error' => "Usuario no autorizado. Nivel actual: " . $this->adminLevel];
        }
    }

    public function startExamStudent()
    {
        $response = [];
        if ($_SESSION['userId'] == $_GET['userId']) {
            $response['redirect'] = "../view/exam.php?examId={$_GET['examId']}&userId={$_GET['userId']}";
        } else {
            $response['redirect'] = '../view/unavailable.php';
        }
        return $response;
    }

    public function getExamQuestions()
    {
        $rows = $this->conn->query("SELECT e.id_examen, e.nombre, e.comentarios, e.liga, er.id_reactivo, er.reactivo 
                FROM examenes e, examenes_reactivos er
                WHERE e.id_examen = er.id_examen AND e.id_examen = {$_GET['examId']}") or die($this->conn->error);
        $questions = [];
        $data = [];
        foreach ($rows as $row) {
            if (empty($data)) {
                $data['examId'] = $row['id_examen'];
                $data['name'] = $row['nombre'];
                $data['comments'] = $row['comentarios'];
                $data['link'] = $row['liga'];
            }
            array_push($questions, [
                'id' => $row['id_reactivo'],
                'question' => $row['reactivo']
            ]);
        }
        $data['questions'] = $questions;
        return $data;
    }

    public function finishExam()
    {
        try {
            $this->conn->begin_transaction();
            foreach ($_POST['answers'] as $answer) {
                $query = $this->conn->query("INSERT INTO examenes_reactivos_usuarios (`id_usuario`, `id_reactivo`, `respuesta`, `correcto`) VALUES ({$_GET['userId']}, {$answer['id']}, '{$answer['answer']}', '0')") or die($this->conn->error);
            }
            $query = $this->conn->query("INSERT INTO examenes_usuarios (`id_examen`, `id_usuario`, `terminado`) VALUES ({$_GET['examId']}, {$_GET['userId']}, 1)") or die($this->conn->error);
            $this->conn->commit();
            http_response_code(201);
            return ['message' => 'Examen registrado exitosamente'];
        } catch (Exception $exception) {
            http_response_code(400);
            return ['errorMessage' => $exception];
        }
    }

    public function getExamAnswersById()
    {
        try {
            if ($this->adminLevel <= 2) {
                http_response_code(403);
                return 'Usuario no autorizado';
            }
            $data = [];
            $examContents = [];
            $rows = $this->conn->query("SELECT e.id_examen, e.nombre, u.id as id_usuario, concat(u.nombre, ' ', u.apellidos) as nombre_usuario, er.id_reactivo, er.reactivo, eru.respuesta 
                    FROM examenes_reactivos_usuarios eru
                    INNER JOIN examenes_reactivos er ON eru.id_reactivo = er.id_reactivo
                    INNER JOIN examenes e ON er.id_examen = e.id_examen
                    INNER JOIN usuarios u ON u.id = eru.id_usuario
                    WHERE u.id = {$_GET['targetUserId']} AND e.id_examen={$_GET['examId']}") or die($this->conn->error);

            foreach ($rows as $row) {
                if (empty($data)) {
                    $data['examId'] = $row['id_examen'];
                    $data['name'] = $row['nombre'];
                    $data['userId'] = $row['id_usuario'];
                    $data['userName'] = $row['nombre_usuario'];
                }
                array_push($examContents, [
                    'questionId' => $row['id_reactivo'],
                    'question' => $row['reactivo'],
                    'answer' => $row['respuesta']
                ]);
            }

            $data['examContents'] = $examContents;
            return $data;
        } catch (Exception $exception) {
            http_response_code(400);
            return 'Hubo un error al procesar el examen';
        }
    }

    public function reviewStudentExam()
    {
        try {
            $this->conn->begin_transaction();
            foreach ($_POST['review'] as $questionReview) {
                if ($questionReview['answerStatus'] == 1) {
                    $this->conn->query("UPDATE examenes_reactivos_usuarios SET correcto = 1 WHERE id_usuario = {$_POST['targetUserId']} AND id_reactivo = {$questionReview['questionId']}") or die($this->conn->error);
                }
            }
            $this->conn->query("UPDATE examenes_usuarios SET resultado = {$_POST['grade']} WHERE id_usuario = {$_POST['targetUserId']} AND id_examen = {$_POST['examId']}") or die($this->conn->error);
            $this->conn->commit();
            http_response_code(201);
            return 'Examen revisado exitosamente';
        } catch (Exception $exception) {
            http_response_code(400);
            return 'Hubo un problema al revisar examen. Intente de nuevo';
        }
    }

    public function getExamAnswersStudent($userId = 0, $examId = 0)
    {
        if(isset($_GET['userId']) && isset($_GET['userExamId'])){
            $userId = $_GET['userId']; 
            $examId = $_GET['userExamId'];
        }
        $data = [];
        $examContents = [];
        $rows = $this->conn->query("SELECT e.id_examen, e.nombre, u.id AS id_usuario, eu.resultado AS calificacion, er.reactivo, eru.respuesta, eru.correcto 
                    FROM examenes_reactivos_usuarios eru 
                    INNER JOIN examenes_reactivos er ON eru.id_reactivo = er.id_reactivo 
                    INNER JOIN examenes e ON er.id_examen = e.id_examen 
                    INNER JOIN examenes_usuarios eu ON eu.id_examen = e.id_examen 
                    INNER JOIN usuarios u ON u.id = eru.id_usuario 
                    WHERE u.id = {$userId} AND eu.id={$examId}") or die($this->conn->error);

        foreach ($rows as $row) {
            if (empty($data)) {
                $data['examId'] = $row['id_examen'];
                $data['name'] = $row['nombre'];
                $data['userId'] = $row['id_usuario'];
                $data['grade'] = $row['calificacion'];
            }
            array_push($examContents, [
                'correct' => $row['correcto'],
                'question' => $row['reactivo'],
                'answer' => $row['respuesta']
            ]);
        }
        $data['examContents'] = $examContents;
        return $data;
    }
}