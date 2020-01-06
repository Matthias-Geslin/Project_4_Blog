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
      $admin = ModelFactory::getModel('Admin')->listData();
      $comments = ModelFactory::getModel('Comments')->listData();

      return $this->render("post.twig", [
        'comments' => $comments,
        'admin'   => $admin
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
      ModelFactory::getModel('Comments')->deleteData($comment_id);

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
      ModelFactory::getModel('Comments')->deleteData($this->get['id']);

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
      ModelFactory::getModel('Comments')->createData([
          'author'  => $author,
          'content' => $content,
          'post_id' => $post_id,
          'user_id' => $user_id
      ]);
      $this->commentRedirect($post_id,'!read');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function reportMethod()
    {
        $comment_id = $this->get['id'];

        ModelFactory::getModel('Comments')->updateData($comment_id, ['reported' => 1]);

        $commentpostid = ModelFactory::getModel('Comments')->readData($comment_id);

      return $this->commentRedirect($commentpostid['post_id'],'!read');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function notreportedMethod()
    {
        ModelFactory::getModel('Comments')->updateData($this->get['id'], ['reported' => 0]);

        $this->redirect('admin');
    }
}
