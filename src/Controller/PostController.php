<?php
namespace App\Controller;

use App\Model\PostModel;
use App\Model\CommentModel;
use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PostController
 * @package App\Controller
 */
class PostController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        $postManager = new PostModel;
        $posts = $postManager->getPosts();

        return $this->render("post.twig", ['posts' => $posts]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function post()
    {
        $postManager = new PostModel();
        $commentManager = new CommentModel();

        $post = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        return $this->render('');
    }

    /**
     * @return string
     * @throws
     * @throws
     * @throws
     */
    public function postAdd()
    {

    }

    /**
     * @return string
     * @throws
     * @throws
     * @throws
     */
    public function postDelete()
    {

    }

    /**
     * @return string
     * @throws
     * @throws
     * @throws
     */
    public function postModify()
    {

    }


}