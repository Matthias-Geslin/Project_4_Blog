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
      $author = $this->getUserVar('nickname');
      $comment = $this->post['comment'];
      $post_id = $this->get['id'];

      if (empty($comment)) {
          $this->redirect('post');
      }
      ModelFactory::getModel('comments')->createData([
          'author' => $author,
          'comment' => $comment,
          'post_id' => $post_id
      ]);
      $this->commentRedirect($post_id,'!read');
    }
}
