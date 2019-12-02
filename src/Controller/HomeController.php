<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use App\Model\PostsModel;
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
    public function launchMethod()
    {
        $lastPost = ModelFactory::getModel('posts')->listData();

        return $this->render('home.twig', ['posts' => $lastPost]);
    }
}