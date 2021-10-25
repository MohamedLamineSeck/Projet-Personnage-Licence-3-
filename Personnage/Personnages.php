<?php
    /*
     * On indique que les chemins des fichiers qu'on inclut
     * seront relatifs au répertoire src.
     */
    set_include_path("./src");

    /* Inclusion des classes utilisées dans ce fichier */
    require_once("Router.php");
    //require_once("db/animal_db.txt");

    /*
     * Cette page est simplement le point d'arrivée de l'internaute
     * sur notre site. On se contente de créer un routeur
     * et de lancer son main.
     */
    require_once('model/AccountStorageMySQL.php');
    require_once('model/PersonnageStorageMySQL.php');


    // Instance Base de Donnée
    //$model = new AnimalStorageStub();

    /*$file = $_SERVER["TMPDIR"] . "/personnages.txt";
    $model = new PersonnageStorageFile($file); */

    /*$file2 = $_SERVER["TMPDIR"] . "/user.txt";
    $model2 = new AccountStorageFile($file2); */


    $model = new PersonnageStorageMySQL();

    $model2 = new AccountStorageMySQL();

    $router = new Router();

    $router->main($model, $model2);
