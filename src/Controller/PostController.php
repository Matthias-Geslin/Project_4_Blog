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
     * @return array
     */
    private $post_content = [];

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
            'posts' => $posts
        ]);
    }

    /**
     * @return string
     */
    private function postData()
    {
      $this->post_content['title'] = $this->post['title'];
      $this->post_content['content'] = $this->post['content'];
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        $title = $this->post['title'];
        $content = $this->post['content'];

        if (empty($title && $content)) {
            return $this->render('backend/admin.twig');
        } else {
            $createdPost = ModelFactory::getModel('posts')->createData([
                'title' => $title,
                'content' => $content
            ]);
           $this->redirect('admin', ['createdPost' => $createdPost]);
        }
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteMethod()
    {
       ModelFactory::getModel('posts')->deleteData($this->get['id']);

       $this->redirect('admin');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function modifyMethod()
    {
      if (!empty($this->post)) {
        $this->postData();

        ModelFactory::getModel('posts')->updateData($this->get['id'], $this->post_content);

        $this->redirect('admin');
    }
    $posts = ModelFactory::getModel('posts')->readData($this->get['id']);
    $comments = ModelFactory::getModel('comments')->listData($this->get['id'], 'post_id');

    return $this->render('backend/modifyPosts.twig', [
      'posts' => $posts,
      'comments' => $comments
  ]);
    }
}
