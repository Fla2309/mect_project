<?php

include_once('connection.php');
session_start();

class Tests
{
    private $userId;
    private $conn;
    private $admin;
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
    }

    public function retrieveTestsPerUser()
    {
        $rows = $this->conn->query("SELECT examenes_usuarios.id, examenes.nombre, examenes.comentarios, examenes_usuarios.resultado, examenes_usuarios.fecha_aplicacion 
                FROM examenes, examenes_usuarios WHERE examenes_usuarios.id_examen = examenes.id_examen AND examenes_usuarios.id_usuario=" . $this->userId);
        // $data = [];
        // foreach ($rows as $row) {
        //     array_push($data, [
        //         'testName' => $row[0],
        //         'comments' => $row[1],
        //         'result' => $row[2],
        //         'dateApplied' => $row[3],
        //     ]);
        // }
        return $rows;
    }

    public function retrieveActiveTestPerGroup()
    {
        return $this->conn->query("SELECT examenes.id_examen, examenes.nombre, examenes.comentarios, examenes.liga FROM examenes, examenes_grupos, usuarios 
        WHERE examenes_grupos.activo = 1 
        AND examenes_grupos.id_examen = examenes.id_examen 
        AND examenes_grupos.id_grupo=usuarios.id_grupo 
        AND usuarios.id=" . $this->userId);
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
        $rows = $this->conn->query("SELECT examenes_usuarios.id, examenes.nombre AS examen_nombre, usuarios.nombre AS usuario_nombre, usuarios.apellidos, examenes_usuarios.resultado, examenes_usuarios.fecha_aplicacion 
                FROM examenes_usuarios, examenes, usuarios 
                WHERE examenes_usuarios.id_usuario = usuarios.id
                AND examenes.id_examen=examenes_usuarios.id_examen");
        $data = [];
        foreach ($rows as $row) {
            array_push($data, [
                'id' => $row['id'],
                'testName' => $row['examen_nombre'],
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

    public function setExamStatus($status){
        if ($this->admin) {
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
            return "Usuario no autorizado";
        }
    }
}