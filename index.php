<?php


require_once('engine.php');

if (isset($_POST['submit'])){
    $Engine = new Engine();
    $Engine->setLogin($_POST['login']);
    $Engine->getPhoto();
}


require_once('template.php');