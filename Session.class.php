<?php

class Session
{

    static public function start()
    {
        session_start();
    }

    static public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    static public function get($key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        else return NULL;
    }

    static public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    static public function logout() {
        // Remove userEntry from Session
        Session::remove('username');
        Session::remove('usertries');
        session_destroy();

        // Change location (goto home)
        header('Location: index.php');
    }
}
