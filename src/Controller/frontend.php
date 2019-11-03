<?php

require_once('../Model/PostManager.php');
require_once('../Model/CommentManager.php');

function listPosts()
{
    $postManager = new App\Model\PostManager();
    $posts = $postManager->getPosts();

    require('../view/home.twig');
}

function post()
{
    $postManager = new App\Model\PostManager();
    $commentManager = new App\Model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('../view/listPost.twig');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new App\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}
