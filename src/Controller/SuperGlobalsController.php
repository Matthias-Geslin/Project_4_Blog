<?php

namespace App\Controller;

use App\Controller\SuperGlobalsControllers\Get;
use App\Controller\SuperGlobalsControllers\Post;
use App\Controller\SuperGlobalsControllers\Session;

/**
 * Class SuperGlobalsController
 * @package App\Controller
 */
abstract class SuperGlobalsController
{
    /**
     * @var Get
     */
    protected $get;

    /**
     * @var Post
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
        $this->get      = new Get();
        $this->post     = new Post();
        $this->session  = new Session();
    }
}