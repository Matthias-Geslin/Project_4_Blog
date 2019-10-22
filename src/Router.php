<?php
namespace App;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
/**
 * Class Router
 * @package App
 */
class Router
{
    /* Set Constants to get default values */
    const DEFAULT_PATH          = 'App\Controller\\';
    const DEFAULT_CONTROLLER    = 'DefaultController';
    const DEFAULT_METHOD        = 'DefaultMethod';
    /**
     * @var null
     */
    private $twig = null;
    /**
     * @var string
     */
    private $controller = self::DEFAULT_CONTROLLER;
    /**
     * @var string
     */
    private $method = self::DEFAULT_METHOD;
    /**
     * Router constructor
     */
    public function __construct()
    {
        /* Set the Template Engine Twig */
        $this->setTemplate();
        /* Parse the URL to Get the Controller & his Method */
        $this->parseUrl();
        /* Set the Controller */
        $this->setController();
        /* Set the Method */
        $this->setMethod();
    }
    /**
     * @return mixed|void
     */
    public function setTemplate()
    {
        /* Create the Template Engine & Set the Path of the Template Directory with Options */
        $this->twig = new Environment(new FilesystemLoader('../src/View'), array(
            'cache' => false,
            'debug' => true
        ));
        /* Add the Twig Debug Extension to be Able to Use the Dump Function in All Views */
        $this->twig->addExtension(new DebugExtension());
    }
    /**
     * @return mixed|void
     */
    public function parseUrl()
    {
        /* Filter the URL Value of the Access Key */
        $access = filter_input(INPUT_GET, 'access');
        /* if the Access Value is not Define, set it to "home" */
        if (!isset($access)) {
            $access = 'home';
        }
        /* Explode the String @ the Exclamation Point, then put the array inside Access */
        $access = explode('!', $access);
        /* Set the Controller with the First Value of the Array */
        $this->controller = $access[0];
        /* Set the Action with the Second Value of the Array, but if there is Only One Value, Set it to "index" */
        $this->method = count($access) == 1 ? 'index' : $access[1];
    }
    /**
     * @return mixed|void
     */
    public function setController()
    {
        /* Set the Controller with the Name of the Required Controller */
        $this->controller = ucfirst(strtolower($this->controller)) . 'Controller';
        /* Set the Controller with the Default Path Added to the Controller Name */
        $this->controller = self::DEFAULT_PATH . $this->controller;
        /* Check if the Required Controller is a Class of the Project */
        if (!class_exists($this->controller)) {
            /* Set the Controller with the Default Path & Name */
            $this->controller = self::DEFAULT_PATH . self::DEFAULT_CONTROLLER;
        }
    }
    /**
     * @return mixed|void
     */
    public function setMethod()
    {
        /* Set the Method with the Name of the Required Method */
        $this->method = strtolower($this->method) . 'Method';
        /* Check if the Required Method Exists inside this Controller */
        if (!method_exists($this->controller, $this->method)) {
            /* Set the Method with the Default Method */
            $this->method = self::DEFAULT_METHOD;
        }
    }
    /**
     * @return mixed|void
     */
    public function run()
    {
        /* Create the Required Controller Instance */
        $this->controller = new $this->controller($this->twig);
        /* Call the Controller Method */
        $response = call_user_func([$this->controller, $this->method]);
        /* Show the Filtred Response of the Required Controller */
        echo filter_var($response);
    }
}