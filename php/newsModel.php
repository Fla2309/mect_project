<?php

include_once('connection.php');

class News
{
    private $conn;
    private $news;

    public function __construct()
    {
        $this->conn = (new DB())->connect();
        $this->news = $this->conn->query("SELECT * FROM noticias ORDER BY fecha DESC LIMIT 10") or die($this->conn->error);
    }

    function getNews()
    {
        return $this->news;
    }

    public function createNews()
    {
        try {
            if (
                $this->conn->query("INSERT INTO noticias (autor, titular, contenido, fecha, adjunto, desc_adjunto) 
                    VALUES ('{$_POST['author']}', '{$_POST['title']}', '{$_POST['content']}', '{$_POST['date']}', '{$_POST['attachment']}', '{$_POST['descAttachment']}')")
                or die($this->conn->error)
            ) {
                http_response_code(201);
                return 'Noticia creada exitosamente';
            } else {
                throw new Exception('Hubo un error al crear la noticia: ' . $this->conn->error);
            }
        } catch (Exception $e) {
            http_response_code(400);
            return 'Error al guardar noticia: ' . $e;
        }
    }

    public function returnNews()
    {
        $bulletin = [];
        if ($this->news != null) {
            foreach ($this->news as $news) {
                array_push($bulletin, [
                    'id' => $news['id'],
                    'author' => $news['autor'],
                    'title' => $news['titular'],
                    'content' => $news['contenido'],
                    'date' => $news['fecha'],
                    'attachment' => $news['adjunto'],
                    'descAttachment' => $news['desc_adjunto']
                ]);
            }
        }
        return $bulletin;
    }
}