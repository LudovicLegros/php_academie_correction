<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=perigueux_academie;charset=utf8', 'root', '');
//$_SERVER['SCRIPT_NAME'] donne dynamiquement le chemin d'accés jusqu'au fichier en cours
//dirname récupère uniquement le chemin (sans le fichier index.php par exemple)
$projectRacine = str_replace('\\','/',realpath(__DIR__));
$documentRoot = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
$cheminRelatif = str_replace($documentRoot,'', $projectRacine);

define('BASE_URL', $cheminRelatif);
// var_dump($_SESSION);
