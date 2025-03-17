<div class="container">
    <h3>Sprememba gesla</h3>

    <?php
    if (isset($_GET["error"])) {
        switch ($_GET["error"]) {
            case 1:
                echo '<p class="text-danger">Manjkajo polja za geslo.</p>';
                break;
            case 2:
                echo '<p class="text-danger">Staro geslo ni pravilno.</p>';
                break;
            case 3:
                echo '<p class="text-danger">Novi gesli se ne ujemata.</p>';
                break;
            case 4:
                echo '<p class="text-danger">Prišlo je do napake pri shranjevanju.</p>';
                break;
        }
    }
    ?>

    <form action="/users/update_password" method="POST">
        <div class="mb-3">
            <label for="old_password" class="form-label">Staro geslo</label>
            <input type="password" class="form-control" id="old_password" name="old_password">
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Novo geslo</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
        </div>
        <div class="mb-3">
            <label for="repeat_password" class="form-label">Ponovi novo geslo</label>
            <input type="password" class="form-control" id="repeat_password" name="repeat_password">
        </div>
        <button type="submit" class="btn btn-primary">Spremeni geslo</button>
    </form>
</div>