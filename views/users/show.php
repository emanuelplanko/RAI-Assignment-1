<div class="container">
    <h3>Uporabniški profil</h3>

    <p><strong>Vzdevek:</strong> <?php echo $user->username; ?></p>
    <p><strong>E-pošta:</strong> <?php echo $user->email; ?></p>
    <p><strong>Število objavljenih novic:</strong> <?php echo $articlesCount; ?></p>
    <p><strong>Število komentarjev:</strong> <?php echo $commentsCount; ?></p>

    <?php
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] == $user->id) {
        echo '<p>To je vaš profil. <a href="/users/edit">Uredi profil</a></p>';
    }
    ?>
</div>