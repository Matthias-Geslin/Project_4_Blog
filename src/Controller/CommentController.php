<?php
namespace App\Controller;

use App\Model\CommentsModel;
use App\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        $postsList = ModelFactory::getModel('posts')->listData();

        return $this->render("post.twig", ['posts' => $postsList]);
    }

    /**
     * @return string
     * @throws
     * @throws
     * @throws
     */
    public function deleteComment() {

    }

    /**
     * @param $postId
     * @param $author
     * @param $comment
     */
    function addComment($postId, $author, $comment)
    {
        $commentManager = new CommentsModel;

        $affectedLines = $commentManager->postComment($postId, $author, $comment);

        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            header('Location: index.php?action=post&id=' . $postId);
        }
    }

}