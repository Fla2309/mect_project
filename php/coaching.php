<?php

include_once('connection.php');

class Coaching extends DB
{
    private $conn;
    public function __construct()
    {
        $this->conn = (new DB())->connect();
    }
    public function retrieveCoachings($user, $coachingId = -1)
    {
        $queryString = '';
        if ($coachingId === -1) {
            $queryString = 'SELECT * FROM coaching_usuarios WHERE id_usuario IN (SELECT id_usuario FROM usuarios WHERE login_user = \'' . $user . '\') ORDER BY id DESC';
        } else {
            $queryString = "SELECT * FROM coaching_usuarios WHERE id = {$coachingId} AND id_usuario IN (SELECT id_usuario FROM usuarios WHERE login_user = '{$user}')";
        }
        $query = $this->conn->query($queryString) or die($this->conn->error);
        if ($query) {
            $result = [];
            if ($coachingId > -1) {
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
            while ($row = $query->fetch_assoc()) {
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

    function createCoaching($userId, $body)
    {
        $data = json_decode($body, true);
        if ($data !== null) {
            return $this->processData($userId, $data);
        } else {
            return "Error al decodificar el JSON.";
        }
    }

    function updateCoaching($userId, $body)
    {
        $data = json_decode($body, true);
        if ($data !== null) {
            return $this->processData($userId, $data, $data['idCoaching']);
        } else {
            return "Error al decodificar el JSON.";
        }
    }

    function deleteCoaching($userId, $coachingId){
        $deleteSuccess = $this->conn->query("DELETE FROM coaching_usuarios WHERE id={$coachingId} AND id_usuario={$userId}");
        return $deleteSuccess;
    }

    function processData($userId, $data, $coachingId = null)
    {
        if ($coachingId != null) {
            $stringData = $this->getStringDataForUpdate($userId, $data);
            $queryString = "UPDATE coaching_usuarios SET {$stringData} WHERE id = {$coachingId} AND id_usuario = {$userId}";
        } else {
            $stringData = $this->getStringDataForInsert($userId, $data);
            $queryString = "INSERT INTO coaching_usuarios (nombre_coaching, id_usuario, nombre_coachee, 
                    lugar, fecha, tiempo_interaccion, descripcion_lugar, quiebre_declarado, 
                    quiebre_trabajado, proceso_indagacion, interpretacion_quiebre, emocion_interaccion, 
                    corporalidad, nuevas_acciones, emociones_vividas, areas_aprendizaje, nuevas_preguntas) 
            VALUES ({$stringData})";
        }
        return $this->conn->query($queryString) or die($this->conn->error);
    }

    function getStringDataForUpdate($userId, $data)
    {
        $stringData = '';
        $stringData .= "fecha = '{$data['date']}', ";
        $stringData .= "nombre_coaching = '{$data['nameCoaching']}', ";
        $stringData .= "nombre_coachee = '{$data['coacheeName']}', ";
        $stringData .= "lugar = '{$data['place']}', ";
        $stringData .= "tiempo_interaccion = '{$data['timeOfInteraction']}', ";
        $stringData .= "descripcion_lugar = '{$data['placeDesc']}', ";
        $stringData .= "quiebre_declarado = '{$data['topicDeclared']}', ";
        $stringData .= "quiebre_trabajado = '{$data['topicHandled']}', ";
        $stringData .= "proceso_indagacion = '{$data['process']}', ";
        $stringData .= "interpretacion_quiebre = '{$data['interpretation']}', ";
        $stringData .= "emocion_interaccion = '{$data['interactionEmotions']}', ";
        $stringData .= "corporalidad = '{$data['bodyLang']}', ";
        $stringData .= "nuevas_acciones = '{$data['newActions']}', ";
        $stringData .= "emociones_vividas = '{$data['myEmotions']}', ";
        $stringData .= "areas_aprendizaje = '{$data['areasOfOportunity']}', ";
        $stringData .= "nuevas_preguntas = '{$data['newQuestions']}'";
        return $stringData;
    }

    function getStringDataForInsert($userId, $data){
        $stringData = "'{$data['nameCoaching']}', '{$userId}', '{$data['coacheeName']}', 
        '{$data['place']}', '{$data['date']}', '{$data['timeOfInteraction']}', 
        '{$data['placeDesc']}', '{$data['topicDeclared']}', '{$data['topicHandled']}', 
        '{$data['process']}', '{$data['interpretation']}', '{$data['interactionEmotions']}', 
        '{$data['bodyLang']}', '{$data['newActions']}', '{$data['myEmotions']}', 
        '{$data['areasOfOportunity']}', '{$data['newQuestions']}'";
        return $stringData;
    }

    function isAdmin($userId)
    {
        $query = mysqli_fetch_row($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->admin = $query[0] > 1 ? true : false;
    }
}