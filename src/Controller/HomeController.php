<?php
namespace App\Controller;
use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $postsList = ModelFactory::getModel('posts')->listData();
        /* Return the Rendering of the View home.twig */
        return $this->render('home.twig', ['post' => $postsList]);
    }
}