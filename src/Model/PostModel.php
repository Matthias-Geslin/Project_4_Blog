<?php

namespace App\Model;

use App\Model\Factory\PDOFactory;

class PostModel extends PDOFactory
{
    /**
     * @return false|\PDOStatement
     */
    public function getPosts()
    {
        $req = $this->getPDO()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0,5');

        return $req;
    }

    /**
     * @param $postId
     * @return mixed
     */
    public function getPost($postId)
    {
        $req = $this->getPDO()->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));

        return $req;
    }

    /**
     * @return false|\PDOStatement
     */
    public function getLastPost()
    {
        $req = $this->getPDO()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 1');

        return $req;
    }
}