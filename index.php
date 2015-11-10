<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/access.inc.php';
if (userIsLoggedIn() == FALSE)
{
    $loginstate = 'Zaloguj';
}else
{
    $loginstate = 'Wyloguj(' . $_SESSION['userlogin'] .')';
}
try
{
include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';
  $sql = 'SELECT variants.id, variants.name FROM variants INNER JOIN voting ON variants.votingid = voting.id WHERE voting.active = 1';
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
include 'votes.html.php';

if (isset($_POST['variants']) and $_SESSION['voted'] !=TRUE)
  {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';
    try
    {
      $sql = 'INSERT INTO votes SET
          variantid = :variantid,
          votedate = CURDATE()';
      $s = $pdo->prepare($sql);
      $s->bindValue(':variantid', $_POST['variants']);
      $s->execute();
     session_start();
    }
    catch (PDOException $e)
    {
      $error = 'Błąd podczas oddawania głosu';
      include 'error.html.php';
      exit();
    }
  $_SESSION['voted'] = TRUE;
  //header('Location: .');
  exit();
}elseif (isset($_POST['variants']) and $_SESSION['voted'] == TRUE)
{
    $error = 'Wziąłeś już udział w głosowaniu, kolejne oddanie głosu nie jest możliwe';
      include 'error.html.php';
}
