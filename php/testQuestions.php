<?php

include_once('connection.php');

class TestQuestions
{
    private $id;
    private $testId;
    private $questions;
    private $conn;

    public function __construct($testId)
    {
        $this->testId = $testId;
        $this->conn = (new DB)->connect();
        $this->questions = $this->getQuestionsByTestId();
    }

    function getQuestionsByTestId(){
        $query = $this->conn->query("SELECT * FROM examenes_reactivos WHERE id_examen={$this->testId}") or die($this->conn->error);
        return $query;
    }
}