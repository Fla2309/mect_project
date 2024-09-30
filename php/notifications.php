<?php

include_once('connection.php');

class Notifications
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new DB)->connect();
    }

    public function getGlobalNotifications(){
        $data = [];
        $query = $this->conn->query('SELECT * FROM notificaciones WHERE id_usuario = 0 AND leido = 0');
        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}