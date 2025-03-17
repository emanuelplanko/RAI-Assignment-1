<div class="container">
    <h3>Seznam novic</h3>
    <br>

    <?php
    $backLink = "/";
    if (isset($_GET["source"]) && $_GET["source"] === "list") {
        $backLink = "/articles/list";
    }
    ?>

    <div class="article">
        <h4><?php echo $article->title; ?></h4>
        <p><b>Povzetek:</b> <?php echo $article->abstract; ?></p>
        <p><?php echo $article->text; ?></p>
        <p>Objavil: <?php echo $article->user->username; ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
        <a href="<?php echo $backLink; ?>"><button>Nazaj</button></a>

        <hr>


        <h4>Komentarji</h4>
        <?php
        require_once('models/comments.php');
        $comments = Comment::allForArticle($article->id);
        if (empty($comments)) {
            echo "<p>Ni komentarjev.</p>";
        } else {
            foreach ($comments as $comment) {
        ?>
                <div class="comment">
                    <p><strong><?php echo $comment->user->username; ?></strong> - <?php echo date_format(date_create($comment->date), 'd. m. Y H:i:s'); ?></p>
                    <p><?php echo $comment->text; ?></p>
                </div>
        <?php
            }
        }
        ?>

        <?php if (isset($_SESSION["USER_ID"])) { ?>
            <h4>Dodaj komentar</h4>
            <form action="/comments/store" method="POST">
                <input type="hidden" name="article_id" value="<?php echo $article->id; ?>">
                <div class="mb-3">
                    <textarea class="form-control" name="text" rows="3" placeholder="Vaš komentar"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Objavi komentar</button>
            </form>
        <?php } else { ?>
            <p>Prijavite se, da lahko komentirate.</p>
        <?php } ?>
    </div>
</div>