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
      if ($this->session->getUserVar('status') === 'admin')
      {
        $posts = ModelFactory::getModel('posts')->listData();
        $admin = ModelFactory::getModel('admin')->listData();

        return $this->render("backend/admin.twig", [
            'posts' => $posts,
            'admin' => $admin
        ]);
      }
      else {
          $this->redirect('home');
      }
    }

    /**
     *  @return array
     */
    private $post_content = [];

    /**
     * @return string
     */
    private function postData()
    {
      $this->post_content['first_name']  = $this->post['first_name'];
      $this->post_content['last_name']   = $this->post['last_name'];
      $this->post_content['email']       = $this->post['email'];
      $this->post_content['pass']        = $this->post['pass'];
      $this->post_content['status']      = $this->post['status'];
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
      $email        = $this->post['email'];
      $pass         = $this->post['pass'];
      $status       = $this->post['status'];

        if (empty($first_name && $last_name && $email && $pass && $status)) {
            return $this->render('backend/adminCreate.twig');
        } else {
            $createdUser = ModelFactory::getModel('admin')->createData([
                'first_name'  => $first_name,
                'last_name'   => $last_name,
                'email'       => $email,
                'pass'        => $pass,
                'status'      => $status
            ]);
           $this->redirect('admin', ['createdUser' => $createdUser]);
        }
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteMethod()
    {
       ModelFactory::getModel('admin')->deleteData($this->get['id']);

       $this->redirect('admin');
    }

    public function modifyMethod()
    {
      if (!empty($this->post)) {
        $this->postData();

        ModelFactory::getModel('admin')->updateData($this->get['id'], $this->post_content);

        $this->redirect('admin');
      }
      $admin = ModelFactory::getModel('admin')->readData($this->get['id']);

      return $this->render('backend/adminModify.twig', [
        'admin' => $admin
      ]);
    }
}
