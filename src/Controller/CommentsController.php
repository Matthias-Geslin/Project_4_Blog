<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CommentsController
 * @package App\Controller
 */
class CommentsController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
      $users = ModelFactory::getModel('users')->listData();
      $comments = ModelFactory::getModel('comments')->listData();

      return $this->render("post.twig", [
        'comments' => $comments,
        'users'   => $users
      ]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deletecommentMethod()
    {
      $comment_id = $this->get['com_id'];
      $post_id = $this->get['id'];
      ModelFactory::getModel('comments')->deleteData($comment_id);

      $this->commentRedirect($post_id,'!read');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteMethod()
    {
      ModelFactory::getModel('comments')->deleteData($this->get['id']);

      $this->redirect('admin');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
      $author  = $this->getUserVar('nickname');
      $content = $this->post['content'];
      $post_id = $this->get['id'];
      $user_id = $this->getUserVar('id');

      if (empty($content)) {
          $this->redirect('post');
      }
      ModelFactory::getModel('comments')->createData([
          'author'  => $author,
          'content' => $content,
          'post_id' => $post_id,
          'user_id' => $user_id
      ]);
      $this->commentRedirect($post_id,'!read');
    }
}
