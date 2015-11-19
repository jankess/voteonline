<?php
try
{
  $pdo = new PDO('mysql:host=localhost;dbname=voteonline', 'voteuser', 'voteonline');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Nie można nawiązać połączenia z serwerem bazy danych.';
  include $_SERVER['DOCUMENT_ROOT']. '/voteonline/error.html.php';
  exit();
}

