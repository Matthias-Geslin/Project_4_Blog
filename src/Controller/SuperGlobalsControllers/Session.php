<?php

namespace App\Controller\SuperGlobalsControllers;

/**
 * Class Session
 * @package App\Controller\SuperGlobalsControllers
 */
class Session
{
    /**
     * @var mixed|null
     */
    private $session = null;

    /**
     * @var mixed
     */
    private $user = null;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);
        if (isset($this->session['users']))
        {
            $this->user = $this->session['users'];
        }
    }

    /**
     * @param int $id
     * @param string $email
     * @param string $pass
     */
    public function sessionCreate(int $id, string $email, string $pass)
    {
        $_SESSION['users'] = [
            'id' => $id,
            'email' => $email,
            'pass' => $pass
        ];
    }

    /**
     * @return void
     */
    public function sessionDestroy()
    {
        $_SESSION['users'] = [];

        $this->sessionDestroy();
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('users', $this->session)) {
            if (!empty($this->user)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array|mixed
     */
    public function getSessionArray()
    {
        return $this->session;
    }

    /**
     * @return mixed
     */
    public function getUserArray()
    {
        if ($this->isLogged() === false) {
            $this->user = [];
        }
        return $this->user;
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getUserVar($var)
    {
        if ($this->isLogged() === false) {
            $this->user[$var] = null;
        }
        return $this->user[$var];
    }
}