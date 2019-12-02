<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use App\Model\Factory\PDOFactory;
use App\Model\PostsModel;
use App\Model\CommentsModel;
use Twig\Environment;
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
        $posts = ModelFactory::getModel('posts')->listData();

        return $this->render("post.twig", [
            'posts' => $posts,
            'createdPost' => $this->createPost()
        ]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function gainPost()
    {
        $post = ModelFactory::getModel('posts')->getPost($_GET['id']);
        $comments = ModelFactory::getModel('comments')->getComments($_GET['id']);

        return $this->render('post.twig',
            [
                'post' => $post,
                'comments' => $comments
            ]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createPost()
    {
        $title = filter_input(INPUT_POST, 'title');
        $content = filter_input(INPUT_POST, 'content');

        if (empty($title && $content)) {
            return $this->render('post.twig');
        } else {
            $createdPost = ModelFactory::getModel('posts')->createData([
                'title' => $title,
                'content' => $content
            ]);
            return $this->render('post.twig', ['createdPost' => $createdPost]);
        }
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