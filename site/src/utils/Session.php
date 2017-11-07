<?php

namespace mecado\utils;

/**
 * Class Sessions
 * @package mecado\utils
 */
class Session
{
    /**
     * Initilisation de la Session
     */
    public static function initSession()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
    }

    /**
     * Recuperation d'une session
     * @param null $key
     * @return bool
     */
    public static function get($key = null)
    {
        if (empty($key))
        {
            return $_SESSION;
        }
        else {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            } else {
                return false;
            }
        }
    }

    /**
     * Mise a jour d'une session
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function set($key, $value)
    {
        if (empty($key))
        {
            return $_SESSION;
        }
        else {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * destroy all session
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * destroy one session
     */
    public static function unset($session)
    {
        unset($_SESSION[$session]);
    }

    /**
     * Permet de savoir si un utilisateur est connecte
     * @param $key
     * @return bool
     */
    public static function isLogged($key)
    {
        return self::exist($key);
    }

    /**
     * Permet de savoir si une session existe
     * @param $key
     * @return bool
     */
    public static function exist($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }

}
