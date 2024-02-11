<?php

include_once 'connection.php';
include_once 'session.php';

class User extends DB
{
    private $id;
    private $name;
    private $lastname;
    private $prefName;
    private $group;
    private $mail;
    private $regDate;
    private $idUser;
    private $userLevel;
    private $phone;
    private $status;


    public function userExists($user, $pass)
    {
        $md5pass = md5($pass);
        $query = $this->connect()->query("SELECT * FROM usuarios WHERE login_user = '{$user}' AND login_pass = '{$md5pass}'");

        if ($query->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function setUser($user)
    {
        $query = $this->connect()->query("SELECT * FROM usuarios WHERE login_user = '" . $user . "'");

        foreach ($query as $currentUser) {
            $this->id = $currentUser['id'];
            $this->name = $currentUser['nombre'];
            $this->lastname = $currentUser['apellidos'];
            $this->prefName = $currentUser['nombre_preferido'] != ''
                ? $currentUser['nombre_preferido'] : $currentUser['nombre'];
            $this->group = $currentUser['id_grupo'];
            $this->mail = $currentUser['correo'];
            $this->phone = $currentUser['telefono'];
            $this->regDate = $currentUser['fecha_ingreso'];
            $this->idUser = $currentUser['id'];
            $this->status = $currentUser['status'];
            $this->userLevel = $currentUser['nivel_usuario'];
        }
    }

    public function getUserId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->name . " " . $this->lastname;
    }

    public function getPreferredName()
    {
        return $this->prefName;
    }

    public function getUserGroup()
    {
        return $this->group;
    }

    public function getUserLevel()
    {
        return $this->userLevel;
    }

    public function getUserType()
    {
        return $this->userLevel;
    }

    public function getUserMail()
    {
        return $this->mail;
    }

    public function getUserPhone()
    {
        return $this->mail;
    }

    public function getUserRegistrationDate()
    {
        return $this->phone;
    }

    public function getUserStatus()
    {
        return $this->status;
    }

    public function getUserProfilePic()
    {
        $row = $this->connect()->query("SELECT foto_perfil FROM usuario_web WHERE id_usuario = " . $this->id)->fetch_row();
        return $row !== null ? $row[0] : "none";
    }
}

class UserProcess extends DB
{
    private $idUser;
    private $b1;
    private $b2;
    private $am;
    private $contract;
    private $sourceOf;
    private $trainingb2;
    private $trainingAm;
    private $songB2;
    private $songAm;
    private $conn;

    public function __construct($idUser){
        $this->idUser = $idUser;
        $this->conn = (new DB())->connect();
    }

    public function setUserProcess()
    {
        $query = $this->conn->query("SELECT * FROM jornada_usuarios WHERE id_usuario = '{$this->idUser}'");

        foreach ($query as $currentUser) {
            $this->b1 = $currentUser['basico_bloque1'];
            $this->b2 = $currentUser['avanzado_bloque2'];
            $this->am = $currentUser['pl_am'];
            $this->contract = $currentUser['contrato'];
            $this->sourceOf = $currentUser['fuente'];
            $this->trainingb2 = $currentUser['estiramiento_av_b2'];
            $this->trainingAm = $currentUser['estiramiento_pl_am'];
            $this->songB2 = $currentUser['cancion_cuna'];
            $this->songAm = $currentUser['cancion_tercer_fin'];
        }
    }

    public function getB1() {
        return $this->b1;
    }
    
    public function getB2() {
        return $this->b2;
    }
    
    public function getAm() {
        return $this->am;
    }
    
    public function getContract() {
        return $this->contract;
    }
    
    public function getSourceOf() {
        return $this->sourceOf;
    }
    
    public function getTrainingb2() {
        return $this->trainingb2;
    }
    
    public function getTrainingAm() {
        return $this->trainingAm;
    }
    
    public function getSongB2() {
        return $this->songB2;
    }
    
    public function getSongAm() {
        return $this->songAm;
    }
}

class UserWeb extends DB{
    private $userId;
    private $userLogin;
    private $userPath;
    private $profilePic;
    private $cv;
    private $inscription;
    private $idFront;
    private $idBack;
    private $conn;

    public function __construct($userId){
        $this->userId = $userId;
        $this->conn = (new DB())->connect();
    }

    public function setUserWeb()
    {
        $query = $this->conn->query("SELECT * FROM usuario_web WHERE id_usuario = '{$this->userId}'");
        $documents = $this->conn->query("SELECT * FROM modulo_personal WHERE id_usuario = '{$this->userId}'");

        foreach ($query as $currentUser) {
            $this->userLogin = $currentUser['usuario'];
            $this->userPath = $currentUser['directorio_local'];
            $this->profilePic = $currentUser['foto_perfil'];
        }
        foreach ($documents as $currentUserDocuments) {
            $this->cv = $currentUserDocuments['nombre_cv'];
            $this->inscription = $currentUserDocuments['formato_inscripcion'];
            $this->idFront = $currentUserDocuments['id_frontal'];
            $this->idBack = $currentUserDocuments['id_trasera'];
        }
    }

    public function getUserLogin() {
        return $this->userLogin;
    }
    
    public function getUserPath() {
        return $this->userPath;
    }
    
    public function getProfilePic() {
        return $this->profilePic;
    }

    public function getCv() {
        return $this->cv;
    }

    public function getInscription() {
        return $this->inscription;
    }

    public function getIdFront() {
        return $this->idFront;
    }

    public function getIdBack() {
        return $this->idBack;
    }
}