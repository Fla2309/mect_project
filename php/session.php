<?php

class Session
{

    public function __construct()
    {
        session_start();
    }

    public function getCurrentUser()
    {
        return $_SESSION['user'];
    }

    public function setCurrentUser($user)
    {
        $_SESSION['user'] = $user;
    }

    public function setCurrentUserId($user)
    {
        $_SESSION['userId'] = $user->getUserId();
    }

    public function setCurrentUserFullname($user)
    {
        $_SESSION['fullname'] = $user->getFullName();
    }

    public function setCurrentUserPreferredName($user)
    {
        $_SESSION['pref_name'] = $user->getPreferredName();
    }

    public function getCurrentSession()
    {
        return $_SESSION['session_id'];
    }

    public function closeSession()
    {
        try {
            unset($_SESSION);
        } catch (Exception $e) {
            return $e;
        }
        session_unset();
        session_destroy();
    }

    public function generateSessionId()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $randstring . strtoupper($characters[rand(0, strlen($characters) - 1)]);
        }
        $_SESSION['session_id'] = $randstring;
    }
}

?>