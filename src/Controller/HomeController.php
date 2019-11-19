<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use App\Model\PostModel;
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
        $postModel = new PostModel;
        $lastPost = $postModel->getLastPost();

        return $this->render('home.twig', ['posts' => $lastPost]);
    }
}