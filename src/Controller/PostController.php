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
        $posts = ModelFactory::getModel('Posts')->listData();

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
        $title   = $this->post['title'];
        $content = $this->post['content'];
        if (empty($title && $content)) {
            $this->redirect('admin');
        }
        $createdPost = ModelFactory::getModel('Posts')->createIt($title,$content);
        $this->redirect('admin', ['createdPost' => $createdPost]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteMethod()
    {
      $id_post = $this->get['id'];

      $post_confirmed = ModelFactory::getModel('Comments')->listData($id_post, 'post_id');

      if (!empty($post_confirmed))
      {
        ModelFactory::getModel('Comments')->deleteData($id_post, 'post_id');
      }

      ModelFactory::getModel('Posts')->deleteData($id_post);

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

        ModelFactory::getModel('Posts')->modifyIt($this->get['id'], $this->post_content['title'],$this->post_content['content']);

        $this->redirect('admin');
    }
    $posts = ModelFactory::getModel('Posts')->readData($this->get['id']);
    $comments = ModelFactory::getModel('Comments')->listData($this->get['id'], 'post_id');

      return $this->render('backend/modifyPosts.twig', [
        'posts' => $posts,
        'comments' => $comments
      ]);
    }
}
