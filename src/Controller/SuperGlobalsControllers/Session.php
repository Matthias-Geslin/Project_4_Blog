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
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     */
    public function sessionCreate(int $id, string $first_name, string $last_name, string $email, string $password)
    {
        $_SESSION['users'] = [
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'pass' => $password
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
}
