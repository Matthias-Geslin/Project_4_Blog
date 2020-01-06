<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
      if ($this->getUserVar('status') === 'admin')
      {
        $posts = ModelFactory::getModel('Posts')->listData();
        $comments = ModelFactory::getModel('Comments')->listData();
        $admin = ModelFactory::getModel('Admin')->listData();

        return $this->render("backend/admin.twig", [
            'posts' => $posts,
            'comments' => $comments,
            'admin' => $admin
        ]);
      }
      elseif ($this->getUserVar('status') === 'member')
      {
        return $this->render("backend/admin.twig");
      }
        $this->redirect('home');
    }

    /**
     * @var array
     */
    private $post_content = [];

    private function postData()
    {
      $this->post_content['first_name']  = $this->post['first_name'];
      $this->post_content['last_name']   = $this->post['last_name'];
      $this->post_content['nickname']    = $this->post['nickname'];
      $this->post_content['email']       = $this->post['email'];
      $this->post_content['status']      = $this->post['status'];
    }

    private function postDataUser()
    {
      $this->post_content['first_name']  = $this->post['first_name'];
      $this->post_content['last_name']   = $this->post['last_name'];
      $this->post_content['nickname']    = $this->post['nickname'];
      $this->post_content['email']       = $this->post['email'];

      $this->post_content['status']      = $this->getUserVar('status');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
      $first_name   = $this->post['first_name'];
      $last_name    = $this->post['last_name'];
      $nickname     = $this->post['nickname'];
      $email        = $this->post['email'];
      $pass         = $this->post['pass'];

      if (empty($first_name && $last_name && $nickname && $email && $pass)) {
        if ($this->getUserVar('status') == 'admin'){
          return $this->render('backend/adminCreate.twig');
        } $this->redirect('home');
      }

      $pass_encrypted = password_hash($pass, PASSWORD_DEFAULT);
      ModelFactory::getModel('Admin')->createData([
          'first_name'  => $first_name,
          'last_name'   => $last_name,
          'nickname'    => $nickname,
          'email'       => $email,
          'pass'        => $pass_encrypted
      ]);

      // Redirection if signup form complete
      if (isset($this->post['signup']))
      {
        $user = ModelFactory::getModel('Admin')->readData($this->post['email'], 'email');
        $this->sessionCreate(
                     $user['id'],
                     $user['first_name'],
                     $user['last_name'],
                     $user['nickname'],
                     $user['email'],
                     $user['pass'],
                     $user['status']
                 );
                 $this->redirect('home');
      }
      $this->redirect('admin');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteMethod()
    {
      $id_User = $this->get['id'];

      $id_confirmed = ModelFactory::getModel('Comments')->listData($id_User, 'user_id');

      if (!empty($id_confirmed))
      {
        ModelFactory::getModel('Comments')->deleteData($this->get['id'], 'user_id');
      }

      ModelFactory::getModel('Admin')->deleteData($this->get['id']);

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

        ModelFactory::getModel('Admin')->updateData($this->get['id'], $this->post_content);

        $this->redirect('admin');
      }
      if ($this->getUserVar('status') == 'admin') {
        $admin = ModelFactory::getModel('Admin')->readData($this->get['id']);

        return $this->render('backend/adminModify.twig', [
          'admin' => $admin
        ]);

      } $this->redirect('home');
    }

    /**
     * @return string|mixed
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function usereditMethod()
    {
      if (!empty($this->post)) {
        $this->postDataUser();

        ModelFactory::getModel('Admin')->updateData($this->get['id'], $this->post_content);
        $user = ModelFactory::getModel('Admin')->readData($this->post['email'], 'email');
        $this->sessionDestroy();
        $this->sessionCreate(
          $user['id'],
          $user['first_name'],
          $user['last_name'],
          $user['nickname'],
          $user['email'],
          $user['pass'],
          $user['status']
        );

        $this->redirect('admin');
      }
        $admin = ModelFactory::getModel('Admin')->readData($this->get['id']);

        return $this->render('backend/admin.twig',[
          'admin' => $admin
        ]);
    }
}
