<?php
namespace App\Controller;
use App\Controller\Extension\PhpAdditionalExtension;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
/**
 * Class MainController
 * @package App\Controller
 */
abstract class MainController
{
    /**
     * @var Environment
     */
    protected $twig = null;
    /**
     * MainController constructor
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        /* Get the Template engine */
        $this->twig = $twig;
        $this->twig->addExtension(new PhpAdditionalExtension());
    }
    /**
     * @param string $page
     * @param array $params
     * @return string
     */
    public function url(string $page, array $params = [])
    {
        /* Insert the $page in the array $params with the key 'access' */
        $params['access'] = $page;
        /* Return the generated URL */
        return 'index.php?' . http_build_query($params);
    }
    /**
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        /* Redirect with the url Method */
        header('Location: ' . $this->url($page, $params));
        exit;
    }
    /**
     * @param string $view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = [])
    {
        /* Return the Rendering of the View */
        return $this->twig->render($view, $params);
    }
}