<?php

require_once('../Model/PostModel.php');
require_once('../Model/CommentModel.php');

function listPosts()
{
    $postManager = new App\Model\PostModel();
    $posts = $postManager->getPosts();

    require('../view/home.twig');
}

function post()
{
    $postManager = new App\Model\PostModel();
    $commentManager = new App\Model\CommentModel();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('../view/listPost.twig');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new App\Model\CommentModel();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}
