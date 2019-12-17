<?php

namespace App\Controller;

use App\Controller\SuperGlobalsControllers\Session;

/**
 * Class SuperGlobalsController
 * @package App\Controller
 */
abstract class SuperGlobalsController
{
    /**
     * @var mixed
     */
    protected $get;

    /**
     * @var mixed
     */
    protected $post;

    /**
     * @var Session
     */
    protected $session;

    /**
     * SuperGlobalsController constructor
     */
    public function __construct()
    {
        $this->get      = filter_input_array(INPUT_GET);
        $this->post     = filter_input_array(INPUT_POST);
        $this->session  = new Session();
    }
}
