<?php
/*
    Controller za uporabnike. Vključuje naslednje standardne akcije:
        create: izpiše obrazec za registracijo
        store: obdela podatke iz obrazca za registracijo in ustvari uporabnika v bazi
        edit: izpiše obrazec za urejanje profila
        update: obdela podatke iz obrazca za urejanje profila in jih shrani v bazo
*/

class users_controller
{
    function create()
    {
        $error = "";
        if (isset($_GET["error"])) {
            switch ($_GET["error"]) {
                case 1:
                    $error = "Izpolnite vse podatke";
                    break;
                case 2:
                    $error = "Gesli se ne ujemata.";
                    break;
                case 3:
                    $error = "Uporabniško ime je že zasedeno.";
                    break;
                default:
                    $error = "Prišlo je do napake med registracijo uporabnika.";
            }
        }
        require_once('views/users/create.php');
    }

    function store()
    {
        //Preveri če so vsi podatki izpolnjeni
        if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])) {
            header("Location: /users/create?error=1");
        }
        //Preveri če se gesli ujemata
        else if ($_POST["password"] != $_POST["repeat_password"]) {
            header("Location: /users/create?error=2");
        }
        //Preveri ali uporabniško ime obstaja
        else if (User::is_available($_POST["username"])) {
            header("Location: /users/create?error=3");
        }
        //Podatki so pravilno izpolnjeni, registriraj uporabnika
        else if (User::create($_POST["username"], $_POST["email"], $_POST["password"])) {
            header("Location: /auth/login");
        }
        //Prišlo je do napake pri registraciji
        else {
            header("Location: /users/create?error=4");
        }
        die();
    }

    function edit()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        $error = "";
        if (isset($_GET["error"])) {
            switch ($_GET["error"]) {
                case 1:
                    $error = "Izpolnite vse podatke";
                    break;
                case 2:
                    $error = "Uporabniško ime je že zasedeno.";
                    break;
                default:
                    $error = "Prišlo je do napake med urejanjem uporabnika.";
            }
        }
        require_once('views/users/edit.php');
    }

    function update()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        //Preveri če so vsi podatki izpolnjeni
        if (empty($_POST["username"]) || empty($_POST["email"])) {
            header("Location: /users/edit?error=1");
        }
        //Preveri ali uporabniško ime obstaja
        else if ($user->username != $_POST["username"] && User::is_available($_POST["username"])) {
            header("Location: /users/edit?error=2");
        }
        //Podatki so pravilno izpolnjeni, registriraj uporabnika
        else if ($user->update($_POST["username"], $_POST["email"])) {
            header("Location: /");
        }
        //Prišlo je do napake pri registraciji
        else {
            header("Location: /users/edit?error=3");
        }
        die();
    }

    public function show()
    {
        if (!isset($_GET['id'])) {
            header("Location: /pages/error");
            die();
        }

        $user_id = $_GET['id'];
        $user = User::find($user_id);
        if (!$user) {
            header("Location: /pages/error");
            die();
        }

        require_once 'models/articles.php';
        require_once 'models/comments.php';
        $articlesCount = Article::countByUser($user->id);
        $commentsCount = Comment::countByUser($user->id);

        require_once('views/users/show.php');
    }

    public function edit_password()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }

        $user = User::find($_SESSION["USER_ID"]);

        require_once('views/users/edit_password.php');
    }


    public function update_password()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }

        if (!isset($_POST['old_password']) || !isset($_POST['new_password']) || !isset($_POST['repeat_password'])) {
            header("Location: /users/edit_password?error=1");
            die();
        }

        $user = User::find($_SESSION["USER_ID"]);
        if (!$user) {
            header("Location: /pages/error");
            die();
        }

        if (!password_verify($_POST['old_password'], $user->password)) {
            header("Location: /users/edit_password?error=2");
            die();
        }

        if ($_POST['new_password'] !== $_POST['repeat_password']) {
            header("Location: /users/edit_password?error=3");
            die();
        }

        $newPass = $_POST['new_password'];
        if ($user->updatePassword($newPass)) {
            header("Location: /users/show?id=" . $user->id . "&msg=pass_changed");
        } else {
            header("Location: /users/edit_password?error=4");
        }
        die();
    }
}
