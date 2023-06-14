<?php

include_once('connection.php');

class Feedback
{
    private $userId;
    private $conn;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB)->connect();
    }

    public function retrieveFeedbackDashboard()
    {
        $data= [];
        $rows = $this->conn->query("SELECT feedback_usuarios.id, modulos.id_modulo, modulos.nombre_modulo, feedback_usuarios.feedback, feedback_usuarios.autor, feedback_usuarios.fecha 
        FROM feedback_usuarios, modulos 
        WHERE modulos.id_modulo = feedback_usuarios.id_modulo 
        AND feedback_usuarios.id_usuario=" . $this->userId) or die($this->conn->error);

        foreach ($rows as $row) {
            array_push($data, [
                "id" => $row['id'],
                "module_id" => $row['id_modulo'],
                "module_name" => $row['nombre_modulo'],
                "feedback" => $row['feedback'],
                "author" => $row['autor'],
                "date" => $row['fecha'],
            ]);
        }

        return $data;
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