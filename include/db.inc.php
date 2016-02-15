<?php
$dsn = 'mysql:host=localhost;dbname=voteonline';
$user = 'voteuser';
$pass = 'voteonline';
try
{
  $pdo = new PDO($dsn,$user,$pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Nie można nawiązać połączenia z serwerem bazy danych.';
  include $_SERVER['DOCUMENT_ROOT']. '/voteonline/templates/error.html.php';
  exit();
}
?>
