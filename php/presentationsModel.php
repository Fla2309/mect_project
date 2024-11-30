<?php

include_once('connection.php');

class Presentations
{

    private $id = null;
    private $userId;
    private $topic = null;
    private $conn;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB)->connect();
    }

    public function getPresentationsFeedbackPerUser()
    {
        $rows = $this->conn->query("SELECT * FROM presentaciones_feedback WHERE id_usuario=" . $this->userId);
        return $rows;
    }

    public function getUserPresentation()
    {
        $query = $this->conn->query("SELECT * FROM presentaciones WHERE id_usuario={$this->userId}") or die($this->conn->error);
        if ($query->num_rows > 0) {
            $result = mysqli_fetch_assoc($query);
            $this->id = $result['id'];
            $this->topic = $result['tema'];

            return [
                'id' => $this->id,
                'userId' => $this->userId,
                'topic' => $this->topic
            ];
        } else {
            return null;
        }
    }

    public function savePresentationTopicByUserId()
    {
        $query = $this->conn->query("INSERT INTO presentaciones (id_usuario, tema) VALUES ('{$_POST['userId']}', '{$_POST['topic']}')");
        if ($query) {
            http_response_code(201);
        } else {
            http_response_code(400);
        }
    }

    public function savePresentationFeedbackByUserId(){
        $query = $this->conn->query("INSERT INTO presentaciones_feedback (id_usuario, nombre_feedback, feedback, autor) 
                    VALUES ('{$_POST['userId']}', '{$_POST['title']}', '{$_POST['feedback']}', '{$_POST['author']}')");
        if ($query) {
            http_response_code(201);
        } else {
            http_response_code(400);
        }
    }
}