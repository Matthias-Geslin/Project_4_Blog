<?php

namespace App\Model;

use App\Model\Factory\PDOFactory;

class PostModel
{
    /**
     * @return false|\PDOStatement
     */
    public function getAllPosts()
    {
        $req = PDOFactory::getPDO()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0,5');
//        $req = $this->getPDO()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0,5');

        return $req;
    }

    /**
     * @param $postId
     * @return mixed
     */
    public function getPost($postId)
    {
        $req = PDOFactory::getPDO()->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
//        $req = $this->getPDO()->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));

        return $req;
    }

    /**
     * @return false|\PDOStatement
     */
    public function getLastPost()
    {
        $req = PDOFactory::getPDO()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 1');
//        $req = $this->getPDO()->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 1');

        return $req;
    }
}