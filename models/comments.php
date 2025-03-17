<?php
require_once 'users.php';
require_once 'connection.php';

class Comment
{
    public $id;
    public $article_id;
    public $user;
    public $text;
    public $date;

    public function __construct($id, $article_id, $user_id, $text, $date)
    {
        $this->id         = $id;
        $this->article_id = $article_id;
        $this->user       = User::find($user_id);
        $this->text       = $text;
        $this->date       = $date;
    }

    public static function allForArticle($article_id)
    {
        $db = Db::getInstance();
        $article_id = mysqli_real_escape_string($db, $article_id);
        $query = "SELECT * FROM comments WHERE article_id = '$article_id' ORDER BY date ASC;";
        $res = $db->query($query);

        $comments = array();
        while ($comment = $res->fetch_object()) {
            array_push($comments, new Comment(
                $comment->id,
                $comment->article_id,
                $comment->user_id,
                $comment->text,
                $comment->date
            ));
        }
        return $comments;
    }

    public static function create($article_id, $user_id, $text)
    {
        $db = Db::getInstance();
        $article_id = mysqli_real_escape_string($db, $article_id);
        $user_id    = mysqli_real_escape_string($db, $user_id);
        $text       = mysqli_real_escape_string($db, $text);

        $query = "INSERT INTO comments (article_id, user_id, text)
                  VALUES ('$article_id', '$user_id', '$text')";
        return $db->query($query);
    }

    public static function countByUser($user_id)
    {
        $db = Db::getInstance();
        $user_id = mysqli_real_escape_string($db, $user_id);

        $query = "SELECT COUNT(*) as total FROM comments WHERE user_id = '$user_id'";
        $res = $db->query($query);
        if ($row = $res->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }
}
