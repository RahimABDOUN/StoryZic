<?php

try{
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', 'root');
} catch(PDOException $e){
    die($e->getMessage());
}