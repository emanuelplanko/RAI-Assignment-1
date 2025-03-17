<?php
require_once 'models/comments.php';

class comments_controller
{
    public function store()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }

        if (!isset($_POST['article_id']) || !isset($_POST['text'])) {
            header("Location: /pages/error");
            die();
        }

        $article_id = $_POST['article_id'];
        $user_id    = $_SESSION["USER_ID"];
        $text       = $_POST['text'];

        if (empty($text)) {
            header("Location: /articles/show?id=" . $article_id . "&error=comment");
            die();
        }

        if (Comment::create($article_id, $user_id, $text)) {
            header("Location: /articles/show?id=" . $article_id);
            die();
        } else {
            header("Location: /articles/show?id=" . $article_id . "&error=comment");
            die();
        }
    }
}
