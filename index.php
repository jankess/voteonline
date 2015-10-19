<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/magicquotes.inc.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/access.inc.php';
if (!userIsLoggedIn())
{
    $loginstate = 'Zaloguj';
}else
{
    $loginstate = 'Wyloguj(' . $_SESSION['userlogin'] .')';
}
try
{
  $sql = 'SELECT id, name FROM variants';
  $result = $pdo->query($sql);
}
catch (PDOException $e)
{
  $error = 'Błąd przy pobieraniu wariantów: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

foreach ($result as $row)
{
  $variants[] = array(
    'id' => $row['id'],
    'name' => $row['name']
  );
}

if (isset($_POST['variants']))
  {
    try
    {
      $sql = 'INSERT INTO votes SET
          variantid = :variantid,
          votedate = CURDATE()';
      $s = $pdo->prepare($sql);
      foreach ($_POST['variants'] as $variantid)
      {
        $s->bindValue(':variantid', $variantid);
        $s->execute();
      }
    }
    catch (PDOException $e)
    {
      $error = 'Błąd podczas oddawania głosu';
      include 'error.html.php';
      exit();
    }
  header('Location: .');
  exit();
}
include 'votes.html.php';