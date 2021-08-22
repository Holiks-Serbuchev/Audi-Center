<?php
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$host = 'localhost';
$dbname = 'audicenter';
$charset = 'utf8'; 
$user = 'root';
$pass = '';
$dsh = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass, $options);
?>