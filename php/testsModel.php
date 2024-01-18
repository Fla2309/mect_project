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
        $this->setAdminPermissions($_GET['userId']);
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

    public function retrieveFinishedExamsAdmin()
    {
        if ($this->admin) {
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
            http_response_code(200);
            return $data;
        } else {
            http_response_code(403);
            return "Usuario no autorizado";
        }
    }
}