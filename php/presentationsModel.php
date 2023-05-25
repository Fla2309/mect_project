<?php

include_once('connection.php');
session_start();

class Presentations{
    private $userId;
    private $conn;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB)->connect();
    }

    public function retrievePresentationsFeedbackPerUser(){
        $rows = $this->conn->query("SELECT * FROM presentaciones_feedback WHERE id_usuario=" . $this->userId);
        $data = [];
        foreach ($rows as $row) {
            array_push($data, [
                'feedbackName' => $row[2],
                'file' => $row[3],
                'author' => $row[4]
            ]);
        }
        return $data;
    }
}

?>