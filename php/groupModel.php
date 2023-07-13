<?php

include_once('../php/connection.php');

class UserGroup
{
    private $user;
    private $groupId;
    private $conn;
    public function __construct($user, $groupId = -1)
    {
        $this->user = $user;
        $this->groupId = $groupId;
        $this->conn = (new DB())->connect();
    }

    //duplicated code (users.php)
    public function prepareHtmlUsuarios($users = 0)
    {
        $html = '';
        $html = $html . '<ul class="list-group" id="groupUsersList">';
        if ($users !== 0) {
            while ($user = mysqli_fetch_array($users)) {
                $html = $html . '<li class="list-group-item" id="user_' . $user['id'] . '"><a>';
                $html = $html . $user['nombre'] . ' ' . $user['apellidos'] . '</a>';
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

        return $html;
    }

    public function prepareHtmlModulos($modules = 0)
    {
        $html = '';
        $html = $html . '<ul class="list-group" id="groupModulesList">';

        if ($modules !== 0) {
            while ($module = mysqli_fetch_array($modules)) {
                $html = $html . '<li class="list-group-item" id="module_' . $module['id_modulo'] . '"><a>';
                $html = $html . $module['nombre_modulo'] . '</a>';
                $html = $html . '<a><img src="img/eye.png" title="Ver detalles" class="dashboard_icon ms-4 me-1"></a>';
                $html = $html . '<a><img src="img/payment.png" title="Pagos grupales" class="dashboard_icon  m-1"></a>';
                $html = $html . '<p><em>' . ($module['descripcion'] !== null ? $module['descripcion'] : 'No hay descripción disponible') . '</em></p>';
                $html = $html . '<div class="form-check">';
                $html = $module['disponible'] > 0 ?
                    $html . '<input class="form-check-input" type="checkbox" value="" id="' . $module['id_modulo'] . '_enabled" checked><label class="form-check-label" for="flexCheckChecked">Disponible</label></div>' :
                    $html . '<input class="form-check-input" type="checkbox" value="" id="' . $module['id_modulo'] . '_enabled"><label class="form-check-label" for="flexCheckDefault">Disponible</label></div>';
                $html = $html . '</li>';
            }
        } else {
            $html = $html . '<h3>No hay módulos para mostrar</h3>';
        }

        $html = $html . '</ul>';

        return $html;
    }

    //duplicado con users.php
    public function prepareHtmlPagos($payments = 0, $userId = null)
    {
        $html = '<ul class="list-group" ';
        $html = $userId == null ? $html . 'id="groupPaymentsList">' : $html . 'id="groupPaymentsModalList">';

        if ($payments !== 0) {
            while ($payment = mysqli_fetch_array($payments)) {
                $html = $html . '<li class="list-group-item" id="payment_' . $payment['id_pago'] . '"><a>';
                $html = $html . $payment['nombre'] . ' ' . $payment['apellidos'] . '</a>';
                $html = $html . '<a><img src="img/eye.png" title="Ver detalles" class="dashboard_icon ms-4 me-1"></a>';
                $html = $html . '<p><strong>Importe: </strong>' . $payment['importe'];
                $html = $html . '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha: </strong>' . $payment['fecha_pago'];
                $html = $html . '<br><strong>Teléfono: </strong>' . $payment['telefono'];
                $html = $html . '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Correo: </strong>' . $payment['correo'] . '</p>';
                $html = $html . '</li>';
            }
        } else {
            $html = $html . '<h3>No hay pagos para mostrar</h3>';
        }

        $html = $html . '</ul>';

        return $html;
    }

    public function getUsuarios()
    {
        $query = $this->conn->query('SELECT * FROM usuarios 
        WHERE id_grupo = ' . $this->groupId) or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }

    public function getModulos()
    {
        $query = $this->conn->query('SELECT modulos_grupos.id, modulos_grupos.id_modulo, modulos.nombre_modulo, 
        modulos.descripcion, modulos_grupos.id_grupo, modulos_grupos.fecha_impartido, modulos_grupos.disponible 
        FROM modulos_grupos, modulos 
        WHERE modulos_grupos.id_modulo = modulos.id_modulo AND modulos_grupos.id_grupo = ' . $this->groupId) or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }

    public function getPagos($userId = null)
    {
        if ($userId == null)
            $query = $this->conn->query('SELECT pagos.id_pago, pagos.importe, pagos.fecha_pago, pagos.id_usuario, usuarios.nombre, usuarios.apellidos, usuarios.id_grupo, usuarios.telefono, usuarios.correo 
            FROM pagos, usuarios WHERE 
            pagos.id_usuario=usuarios.id AND usuarios.id_grupo=' . $this->groupId) or die($this->conn->error);
        else
            $query = $this->conn->query('SELECT pagos.id_pago, pagos.importe, pagos.fecha_pago, pagos.id_usuario, usuarios.nombre, usuarios.apellidos, usuarios.id_grupo, usuarios.telefono, usuarios.correo 
            FROM pagos, usuarios WHERE 
            pagos.id_usuario=usuarios.id AND usuarios.id=' . $userId) or die($this->conn->error);
        return $query->num_rows > 0 ? $query : 0;
    }

    public function getGroupName()
    {
        $row = mysqli_fetch_assoc($this->conn->query('SELECT * FROM grupos WHERE id_grupo = ' . $this->groupId));
        return 'MECT ' . $row['id_grupo'] . ' ' . $row['nombre_grupo'];
    }
}

?>