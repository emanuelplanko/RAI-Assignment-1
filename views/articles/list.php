<div class="container">
    <h3>Moje novice</h3>
    <br>
    <?php
    if (empty($articles)) {
        echo "<p>Trenutno nimate objavljenih novic.</p>";
    } else {
        foreach ($articles as $article) {
    ?>
            <div class="article">
                <h4><?php echo $article->title; ?></h4>
                <p><?php echo $article->abstract; ?></p>
                <p>
                    Objavil: <?php echo $article->user->username; ?>,
                    <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?>
                </p>
                <a href="/articles/show?id=<?php echo $article->id; ?>"><button>Preberi več</button></a>
                <!-- Added Edit button -->
                <a href="/articles/edit?id=<?php echo $article->id; ?>"><button>Uredi novico</button></a>
            </div>
    <?php
        }
    }
    ?>
</div>