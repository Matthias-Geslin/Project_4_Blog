<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UsersController
 * @package App\Controller
 */
class UsersController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        if ($this->session->islogged())
        {
          $posts = ModelFactory::getModel('posts')->listData();

          return $this->render("backend/users.twig", [
              'posts' => $posts
          ]);
        }
        $this->redirect('connexion');
    }
}
