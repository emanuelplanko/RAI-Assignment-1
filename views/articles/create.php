<div class="container">
    <h3>Objavi novico</h3>

    <form action="/articles/store" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="mb-3">
            <label for="abstract" class="form-label">Povzetek</label>
            <textarea class="form-control" id="abstract" name="abstract" rows="2"></textarea>
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Vsebina</label>
            <textarea class="form-control" id="text" name="text" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Objavi</button>

        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == 1) {
                echo '<p class="text-danger">Prosim, izpolnite vsa polja!</p>';
            } elseif ($_GET["error"] == 2) {
                echo '<p class="text-danger">Prišlo je do napake pri vstavljanju novice.</p>';
            }
        }
        ?>
    </form>
</div>