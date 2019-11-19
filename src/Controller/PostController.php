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
        $postsList = ModelFactory::getModel('posts')->listData();

        return $this->render("post.twig", ['posts' => $postsList]);
    }

    /**
     * @return string
     */
    public function listPosts()
    {
        $postManager = new PostModel;
        $posts = $postManager->getPosts();

        require('../view/home.twig');
    }

    /**
     * @return string
     */
    public function post()
    {
        $postManager = new PostModel();
        $commentManager = new CommentModel();

        $post = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        require('../view/layout/listPost.twig');
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