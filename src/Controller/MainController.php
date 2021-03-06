<?php
namespace App\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MainController
 * @package App\Controller
 */
abstract class MainController extends SuperGlobalsController
{
    /**
     * @var Environment
     */
    protected $twig = null;

    /**
     * MainController constructor
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        parent::__construct();

        $this->twig = $twig;
        $twig->addGlobal('session', $_SESSION);
        $this->twig->addFilter( new \Twig\TwigFilter('nl2br', 'nl2br', ['is_safe' => ['html']]));
    }

    /**
     * @param string $page
     * @param array $params
     * @return string
     */
    public function url(string $page, array $params = [])
    {
        $params['access'] = $page;
        return 'index.php?' . http_build_query($params);
    }

    /**
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        header('Location: ' . $this->url($page, $params));
        exit;
    }

      /**
       * Redirection when comment is created
       * @param string $value
       * @param string $params
       */
      public function commentRedirect(string $value, string $params)
      {
          header('Location: index.php?id=' . $value . '&access=fullPost' . $params);
          exit;
      }

    /**
     * @param string $view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }
}
