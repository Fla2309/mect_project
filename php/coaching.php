<?php

include_once('connection.php');

class Coaching extends DB
{
    private $conn;
    public function __construct(){
        $this->conn=(new DB())->connect();
    }
    public function retrieveCoachings($user, $coachingId = -1)
    {
        $queryString = '';
        if($coachingId === -1){
            $queryString = 'SELECT * FROM coaching_usuarios WHERE id_usuario IN (SELECT id_usuario FROM usuarios WHERE login_user = \''.$user.'\')  ORDER BY fecha ASC';
        } else {
            $queryString = "SELECT * FROM coaching_usuarios WHERE id = {$coachingId} AND id_usuario IN (SELECT id_usuario FROM usuarios WHERE login_user = '{$user}')";
        }
        $query = $this->conn->query($queryString) or die($this->conn->error);
        if ($query) {
            $result = [];
            if($coachingId > -1){
                $row = $query->fetch_assoc();
                $result = [
                    'idCoaching' => $row['id'],
                    'nameCoaching' => $row['nombre_coaching'],
                    'userId' => $row['id_usuario'],
                    'coacheeName' => $row['nombre_coachee'],
                    'place' => $row['lugar'],
                    'date' => $row['fecha'],
                    'timeOfInteraction' => $row['tiempo_interaccion'],
                    'placeDesc' => $row['descripcion_lugar'],
                    'topicDeclared' => $row['quiebre_declarado'],
                    'topicHandled' => $row['quiebre_trabajado'],
                    'process' => $row['proceso_indagacion'],
                    'interpretation' => $row['interpretacion_quiebre'],
                    'interactionEmotions' => $row['emocion_interaccion'],
                    'bodyLang' => $row['corporalidad'],
                    'newActions' => $row['nuevas_acciones'],
                    'myEmotions' => $row['emociones_vividas'],
                    'areasOfOportunity' => $row['areas_aprendizaje'],
                    'newQuestions' => $row['nuevas_preguntas']
                ]; 
            }
            while ($row = $query->fetch_assoc()){
                $modifiedRow = [
                    'idCoaching' => $row['id'],
                    'nameCoaching' => $row['nombre_coaching'],
                    'userId' => $row['id_usuario'],
                    'coacheeName' => $row['nombre_coachee'],
                    'place' => $row['lugar'],
                    'date' => $row['fecha'],
                    'timeOfInteraction' => $row['tiempo_interaccion'],
                    'placeDesc' => $row['descripcion_lugar'],
                    'topicDeclared' => $row['quiebre_declarado'],
                    'topicHandled' => $row['quiebre_trabajado'],
                    'process' => $row['proceso_indagacion'],
                    'interpretation' => $row['interpretacion_quiebre'],
                    'interactionEmotions' => $row['emocion_interaccion'],
                    'bodyLang' => $row['corporalidad'],
                    'newActions' => $row['nuevas_acciones'],
                    'myEmotions' => $row['emociones_vividas'],
                    'areasOfOportunity' => $row['areas_aprendizaje'],
                    'newQuestions' => $row['nuevas_preguntas']
                ];
                $result[] = $modifiedRow;
            }
            $query->free();
            http_response_code(200);
            header('Content-Type: application/json; charset=utf-8');
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(400);
            return json_encode(['error' => 'Error en la consulta: ' . $this->conn->error]);
        }
    }

    function isAdmin($userId)
    {
        $query = mysqli_fetch_row($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->admin = $query[0] > 1 ? true : false;
    }
}