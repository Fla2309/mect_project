<?php

include_once('connection.php');
session_start();

class Tests
{
    private $userId;
    private $conn;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB)->connect();
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
}

?>