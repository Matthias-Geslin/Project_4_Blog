<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ConnexionController
 * @package App\Controller
 */
class ConnexionController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
    if (!empty($this->post['email']) && !empty($this->post['pass'])) {
         $user = ModelFactory::getModel('admin')->readData($this->post['email'], 'email');

          if ($this->post['pass'] ===  $user['pass']) {
            $this->session->sessionCreate(
                         $user['id'],
                         $user['first_name'],
                         $user['last_name'],
                         $user['email'],
                         $user['pass'],
                         $user['status']
                     );
              $this->redirect('admin');
              exit();
          }
      }
      if($this->session->getUserVar('status') === 'admin')
        {
          $this->redirect('admin');
        }
        return $this->render('connexion.twig');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function logoutMethod()
    {
      $this->session->sessionDestroy();
      $this->redirect('home');
    }
}
