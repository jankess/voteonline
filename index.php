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
      foreach ($_POST['variants'] as $variantid)
      {
        $s->bindValue(':variantid', $variantid);
        $s->execute();
      }
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
