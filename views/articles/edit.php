<div class="container">
    <h3>Uredi novico</h3>

    <?php
    // Optionally display error messages based on query string error codes
    if (isset($_GET["error"])) {
        if ($_GET["error"] == 1) {
            echo '<p class="text-danger">Prosim, izpolnite vsa polja!</p>';
        } elseif ($_GET["error"] == 2) {
            echo '<p class="text-danger">Prišlo je do napake pri posodabljanju novice.</p>';
        }
    }
    ?>

    <form action="/articles/update" method="POST">
        <!-- Include a hidden field for the article ID -->
        <input type="hidden" name="id" value="<?php echo $article->id; ?>">

        <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $article->title; ?>">
        </div>
        <div class="mb-3">
            <label for="abstract" class="form-label">Povzetek</label>
            <textarea class="form-control" id="abstract" name="abstract" rows="2"><?php echo $article->abstract; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Vsebina</label>
            <textarea class="form-control" id="text" name="text" rows="5"><?php echo $article->text; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Shrani spremembe</button>
    </form>
</div>