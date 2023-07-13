<?php

include_once('connection.php');

class Users
{
    private $userId;
    private $conn;
    private $admin;
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->conn = (new DB())->connect();
        $this->setAdminPermissions($userId);
    }

    function setAdminPermissions($userId)
    {
        $query = mysqli_fetch_row($this->conn->query("SELECT nivel_usuario FROM usuarios WHERE id = {$userId}")) or die($this->conn->error);
        $this->admin = $query[0] > 1 ? true : false;
    }

    //duplicated code (groupModel.php)
    public function prepareHtmlUsuarios($users)
    {
        $html = '';
        $html = $html . '<ul class="list-group" id="usersList">';
        if ($users !== 0) {
            while ($user = mysqli_fetch_array($users)) {
                $html = $html . '<li class="list-group-item" id="user_' . $user['id'] . '"><a>';
                $html = $html . $user['nombre'] . ' ' . $user['apellidos'] . '&nbsp;&nbsp;';
                $html = $html . '<em class="text-muted">MECT ' . $user['id_grupo'] . ' ' . $user['nombre_grupo'] . '</em></a>';
                $html = $html . '<a href="#" onclick="deleteStudent(this)"><img src="img/del_user.png" title="Eliminar usuario" class="dashboard_icon ms-4 me-1"></a>';
                $html = $html . '<a href="#" onclick="showUserSettings(this, setParametersInSettingsModal)"><img src="img/settings.png" title="Configuración" class="dashboard_icon m-1"></a>';
                $html = $html . '<a href="#" onclick="showPaymentFrame(this, setPaymentsFrameInUser)"><img src="img/payment.png" title="Pagos" class="dashboard_icon  m-1"></a>';
                $html = $html . '<a href="#" onclick="showStudentSchoolProfile(this)"><img src="img/books.png" title="Perfil académico" class="dashboard_icon  m-1"></a>';
                $html = $html . '</li>';
            }
        } else {
            $html = $html . '<h3>No hay usuarios para mostrar</h3>';
        }

        $html = $html . '</ul>';

        http_response_code(200);
        return $html;
    }

    public function getUsuarios()
    {
        $query = $this->conn->query('SELECT usuarios.id, usuarios.nombre, usuarios.apellidos, 
            usuarios.id_grupo, grupos.nombre_grupo, usuarios.correo, usuarios.telefono 
            FROM usuarios, grupos WHERE usuarios.status=0 AND usuarios.id_grupo = grupos.id_grupo') or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }

    public function deleteUser($targetUser)
    {
        if ($this->admin) {
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
    
    //duplicado con groupModel.php
    public function prepareHtmlPagos($userId)
    {
        $rows = $this->conn->query('SELECT pagos.id_pago, pagos.importe, pagos.fecha_pago, pagos.id_usuario, usuarios.nombre, usuarios.apellidos, usuarios.id_grupo, usuarios.telefono, usuarios.correo 
        FROM pagos, usuarios WHERE 
        pagos.id_usuario=usuarios.id AND usuarios.id=' . $userId) or die($this->conn->error);
        $html = '';
        $html = $html . '<ul class="list-group mt-2" id="groupPaymentsList">';

        if ($rows !== 0) {
            foreach ($rows as $row) {
                $html = $html . '<li class="list-group-item" id="payment_' . $row['id_pago'] . '"><a>';
                $html = $html . $row['nombre'] . ' ' . $row['apellidos'] . '</a>';
                $html = $html . '<a><img src="img/eye.png" title="Ver detalles" class="dashboard_icon ms-4 me-1"></a>';
                $html = $html . '<p><strong>Importe: </strong>' . $row['importe'];
                $html = $html . '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha: </strong>' . $row['fecha_pago'];
                $html = $html . '<br><strong>Teléfono: </strong>' . $row['telefono'];
                $html = $html . '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Correo: </strong>' . $row['correo'] . '</p>';
                $html = $html . '</li>';
            }
        } else {
            $html = $html . '<h3>No hay pagos para mostrar</h3>';
        }

        $html = $html . '</ul>';

        return $html;
    }
}

?>