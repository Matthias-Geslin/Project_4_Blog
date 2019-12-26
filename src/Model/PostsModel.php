<?php

namespace App\Model;

use App\Model\Factory\PDOFactory;

class PostsModel extends MainModel
{
  public function createIt($title,$content)
  {
    $req = PDOFactory::getPDO()->prepare('INSERT INTO Posts(title,content) VALUES(?,?)');
    return $req->execute(array($title,$content));
  }

      /**
     * @param $id
     * @param $new_title
     * @param $new_content
     */
    public function modifyIt(string $id, string $title ,string $content)
    {
        $content = html_entity_decode($content);
        $req = PDOFactory::getPDO()->prepare('UPDATE Posts SET title = ? , content = ? WHERE id = ?');
        $req->execute(array($title,$content,$id));
    }
}
