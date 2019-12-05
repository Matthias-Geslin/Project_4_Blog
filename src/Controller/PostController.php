<?php
namespace App\Controller;

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
        $post = ModelFactory::getModel('posts')->readData($_GET['id']);
        $comments = ModelFactory::getModel('comments')->readData($_GET['id']);

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
            return $this->redirect('post', ['createdPost' => $createdPost]);
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
        $postDelete = ModelFactory::getModel('posts')->deleteData($_GET['id']);

        return $this->render('post.twig', ['postDelete' => $postDelete]);
    }

    /**
     * @return string
     * @throws
     * @throws
     * @throws
     */
    public function postModify()
    {
        $title = filter_input(INPUT_POST, 'title');
        $content = filter_input(INPUT_POST, 'content');

        $postUpdate = ModelFactory::getModel('posts')->updateData($_GET['id'],[
            'title' => $title,
            'content' => $content
        ]);

        return $this->render('post.twig', ['postUpdate' => $postUpdate]);
    }


}