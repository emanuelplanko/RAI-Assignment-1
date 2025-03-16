<?php
/*
    Controller za novice. Vključuje naslednje standardne akcije:
        index: izpiše vse novice
        show: izpiše posamezno novico
        
    TODO:
        list: izpiše novice prijavljenega uporabnika
        create: izpiše obrazec za vstavljanje novice
        store: vstavi novico v bazo
        edit: izpiše vmesnik za urejanje novice
        update: posodobi novico v bazi
        delete: izbriše novico iz baze
*/

class articles_controller
{
    public function index()
    {
        //s pomočjo statične metode modela, dobimo seznam vseh novic
        //$ads bo na voljo v pogledu za vse oglase index.php
        $articles = Article::all();

        //pogled bo oblikoval seznam vseh oglasov v html kodo
        require_once('views/articles/index.php');
    }

    public function show()
    {
        //preverimo, če je uporabnik podal informacijo, o oglasu, ki ga želi pogledati
        if (!isset($_GET['id'])) {
            return call('pages', 'error'); //če ne, kličemo akcijo napaka na kontrolerju stran
            //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
        }
        //drugače najdemo oglas in ga prikažemo
        $article = Article::find($_GET['id']);
        require_once('views/articles/show.php');
    }

    public function store()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }

        $title = $_POST['title'] ?? '';
        $abstract = $_POST['abstract'] ?? '';
        $text = $_POST['text'] ?? '';

        if (empty($title) || empty($abstract) || empty($text)) {

            header("Location: /articles/create?error=1");
            die();
        }

        $user_id = $_SESSION["USER_ID"];
        if (Article::create($title, $abstract, $text, $user_id)) {
            header("Location: /articles/index");
            die();
        } else {
            header("Location: /articles/create?error=2");
            die();
        }
    }

    public function list()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }

        $user_id = $_SESSION["USER_ID"];
        $articles = Article::allByUser($user_id);

        require_once('views/articles/list.php');
    }


    public function create()
    {
        require_once('views/articles/create.php');
    }
}
