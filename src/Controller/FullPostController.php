<?php
namespace App\Controller;

use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class FullPostController
 * @package App\Controller
 */
 class FullPostController extends MainController
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
    $comments = ModelFactory::getModel('comments')->listData();

    return $this->render("fullPost.twig", [
        'posts' => $posts,
        'comments' => $comments
    ]);
  }

  /**
   * @return string
   * @throws LoaderError
   * @throws RuntimeError
   * @throws SyntaxError
   */
  public function readMethod()
  {
    $posts = ModelFactory::getModel('posts')->readData($this->get['id']);
    $comments = ModelFactory::getModel('comments')->listData($this->get['id'], 'post_id');

      return $this->render('fullpost.twig', [
        'post' => $posts,
        'comments' => $comments
      ]);
  }
}
