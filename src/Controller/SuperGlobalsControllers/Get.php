<?php

namespace App\Controller\SuperGlobalsControllers;

/**
 * Class Get
 * @package App\Controller\SuperGlobalsControllers
 */
class Get
{
    /**
     * @var mixed
     */
    private $get;

    /**
     * Get constructor.
     */
    public function __construct()
    {
        $this->get = filter_input_array(INPUT_GET);
    }

    /**
     * @return mixed
     */
    public function getGetArray()
    {
        return $this->get;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getGetVar(string $var)
    {
        return $this->get[$var];
    }
}