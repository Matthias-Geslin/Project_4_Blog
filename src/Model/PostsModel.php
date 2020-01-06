<?php

namespace App\Model;

use App\Model\Factory\PDOFactory;

class PostsModel extends MainModel
{
    /**
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function createIt(string $title, string $content)
    {
        $req = PDOFactory::getPDO()->prepare('INSERT INTO Posts(title,content) VALUES(?,?)');
        return $req->execute(array($title,$content));
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $content
     */
    public function modifyIt(int $id, string $title ,string $content)
    {
        $content = html_entity_decode($content);
        $req = PDOFactory::getPDO()->prepare('UPDATE Posts SET title = ? , content = ? WHERE id = ?');
        $req->execute(array($title,$content,$id));
    }
}
