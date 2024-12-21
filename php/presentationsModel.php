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

        $presentationInfo = mysqli_fetch_assoc($this->conn->query("SELECT * FROM presentaciones WHERE id_usuario=" . $this->userId));
        $rows = $this->conn->query("SELECT * FROM presentaciones_feedback WHERE id_usuario=" . $this->userId);
        $feedback = [];
        if ($presentationInfo) {
            foreach ($rows as $row) {
                array_push($feedback, [
                    'author' => $row['autor'],
                    'title' => $row['nombre_feedback'],
                    'feedback' => $row['feedback'],
                    'date' => $row['fecha_subido'],
                ]);
            }
            $data = [
                'userId' => $presentationInfo['id_usuario'],
                'topic' => $presentationInfo['tema'],
                'feedback' => $feedback
            ];
            return $data;
        } else {
            return null;
        }
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
        $notificationPresentationTopic = $this->conn->query("INSERT INTO notificaciones(id_usuario, titulo, texto) VALUES ({$_POST['userId']}, 'Tema de presentación asignado','Se te ha asignado el siguiente tema: \'{$_POST['topic']}\'')");
        if ($query) {
            http_response_code(201);
        } else {
            http_response_code(400);
        }
    }

    public function savePresentationFeedbackByUserId()
    {
        $query = $this->conn->query("INSERT INTO presentaciones_feedback (id_usuario, nombre_feedback, feedback, autor) 
                    VALUES ('{$_POST['userId']}', '{$_POST['title']}', '{$_POST['feedback']}', '{$_POST['author']}')");
        $notificationPresentationTopic = $this->conn->query("INSERT INTO notificaciones(id_usuario, titulo, texto) VALUES ({$_POST['userId']}, 'Nuevo feedback en presentación','{$_POST['author']} te ha dado feedback sobre tu presentación: \'{$_POST['title']}\'')");
        if ($query) {
            http_response_code(201);
        } else {
            http_response_code(400);
        }
    }
}