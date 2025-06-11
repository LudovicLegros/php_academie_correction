<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=perigueux_academie;charset=utf8', 'root', '');
//realpath(__DIR__) renvoie le chemin depuis la racine de la machine
//$_SERVER['DOCUMENT_ROOT'] renvoie le chemin de la racine de la machine jusqu'a la racine du serveur PHP
//str_replace change tout les \ en / pour avoir la même structure de chemin
//On enleve ensuite le chemin d'accès racine > server PHP du chemin racine > projet 
$projectRacine = str_replace('\\','/',realpath(__DIR__));
$documentRoot = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
$cheminRelatif = str_replace($documentRoot,'', $projectRacine);
//la fonction define met dans le premier parametre le contenu du deuxieme parametre
define('BASE_URL', $cheminRelatif);
// var_dump($_SERVER);
// var_dump($projectRacine);
