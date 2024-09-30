<?php

include_once('connection.php');

class Users
{
    private $userId;
    private $conn;
    private $userLevel;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB())->connect();
        $this->setUserLevel($userId);
    }

    function setUserLevel($userId)
    {
        $query = mysqli_fetch_assoc($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->userLevel = $query['nivel_usuario'];
    }

    public function prepareUsuariosJson()
    {
        $users = $this->getUsuarios();
        $usersList = [];
        if ($users !== 0) {
            while ($user = mysqli_fetch_array($users)) {
                //options -> 1=eliminar, 2=configuración, 3=pagos, 4=perfil
                if ($user['id'] == $this->userId)
                    continue;
                $options = $this->userLevel > 1 && $this->userLevel < 3 ?
                    [3, 4] :
                    [1, 2, 3, 4];

                $user = [
                    'userId' => $user['id'],
                    'userName' => $user['nombre'],
                    'userLastName' => $user['apellidos'],
                    'groupId' => $user['id_grupo'],
                    'groupName' => $user['nombre_grupo'],
                    'groupLocation' => $user['sede'],
                    'options' => $options
                ];
                array_push($usersList, $user);
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($usersList, JSON_UNESCAPED_UNICODE);
    }

    public function getUsuarios()
    {
        $query = $this->conn->query('SELECT usuarios.id, usuarios.nombre, usuarios.apellidos, 
            grupos.id_grupo, grupos.nombre_grupo, grupos.sede, usuarios.correo, usuarios.telefono 
            FROM usuarios, grupos WHERE usuarios.status=0 AND usuarios.id_grupo = grupos.id') or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }

    public function deleteUser($targetUser)
    {
        if ($this->userLevel > 2) {
            $query = $this->conn->query("UPDATE usuarios SET status = 1 WHERE id={$targetUser}") or die($this->conn->error);
            if ($query)
                http_response_code(200);
            else
                http_response_code(400);
        } else {
            http_response_code(403);
            return "Usuario No Autorizado";
        }
    }

    public function preparePagosArray($targetUserId)
    {
        $pagosList = [];
        foreach ($this->getPagosPerUser($targetUserId) as $row) {

            $pago = array(
                'paymentId' => $row['id_pago'],
                'reason' => $row['concepto'],
                'amount' => $row['importe'],
                'paymentDate' => $row['fecha_pago'],
                'userFullName' => $row['usuario_nombre'] . ' ' . $row['usuario_apellidos'],
                'phone' => $row['telefono'],
                'email' => $row['usuario_correo']
            );

            array_push($pagosList, $pago);
        }
        return $pagosList;
    }

    function getPagosPerUser($targetUserId)
    {
        $payments = $this->conn->query('SELECT pagos.id_pago as id_pago, 
            pagos.concepto as concepto, 
            pagos.importe as importe, 
            pagos.fecha_pago as fecha_pago, 
            pagos.id_usuario as id_usuario, 
            usuarios.nombre as usuario_nombre, 
            usuarios.apellidos as usuario_apellidos, 
            usuarios.id_grupo as id_grupo, 
            usuarios.telefono as telefono, 
            usuarios.correo as usuario_correo 
            FROM pagos, usuarios WHERE 
            pagos.id_usuario=usuarios.id AND usuarios.id=' . $targetUserId) or die($this->conn->error);
        return $payments;
    }

    public function registerPaymentForUser()
    {
        if ($this->userLevel > 1) {
            $query = $this->conn->query("INSERT INTO pagos (id_usuario, concepto, importe, fecha_pago) 
                VALUES ('{$_GET['targetUserId']}', '{$_GET['targetUserReason']}', '{$_GET['targetUserAmount']}', '{$_GET['paymentDate']}')") or die($this->conn->error);
            if ($query)
                http_response_code(201);
            else
                http_response_code(400);
        } else
            http_response_code(403);
    }

    public function getUserPaymentInfo()
    {
        $paymentInfo = mysqli_fetch_assoc($this->conn->query('SELECT id, nombre, apellidos, telefono, correo 
            FROM usuarios WHERE id=' . $_GET['targetUserId']))
            or die($this->conn->error);
        $userPaymentInfo = array(
            'userId' => $paymentInfo['id'],
            'userName' => $paymentInfo['nombre'],
            'userLastname' => $paymentInfo['apellidos'],
            'userPhone' => $paymentInfo['telefono'],
            'userMail' => $paymentInfo['correo'],
        );

        header('Content-Type: application/json; charset=utf-8');
        return json_encode($userPaymentInfo);
    }
}