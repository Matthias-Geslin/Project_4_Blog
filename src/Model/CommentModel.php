<?php

namespace App\Model;

use App\Model\Factory\PDOFactory;

class CommentModel extends PDOFactory
{
    /**
     * @param $postId
     * @return bool|\PDOStatement
     */
    public function getComments($postId)
    {
        $comments = $this->getPDO()->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }

    /**
     * @param $postId
     * @param $author
     * @param $comment
     * @return bool
     */
    public function postComment($postId, $author, $comment)
    {
        $comments = $this->getPDO()->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }
}
