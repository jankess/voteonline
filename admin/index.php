<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/access.inc.php';

if (!userIsLoggedIn())
{
    $loginstate = 'Zaloguj';
    include '../login.html.php';
    exit();
}else
{
    $loginstate = 'Wyloguj(' . $_SESSION['userlogin'] .')';
}
if (!userHasRole('Administrator'))
{
    $error = 'Dostęp do tej strony mają tylko Administratorzy';
    include '../accessdenied.html.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';
//Dodawanie nowego użytkownika


if (isset($_GET['adduser']))
    {
     if(!isset($_POST['userlogin']) or !isset($_POST['userpassword']) or !isset($_POST['useremail']) or $_POST['userlogin'] != '' or $_POST['userpassword'] != '' or $_POST['useremail'] != '')
                                             {
try
  {
    $sql = 'INSERT INTO users SET
        login = :userlogin, password = :userpassword, email = :useremail';
    $s = $pdo->prepare($sql);
    $s->bindValue(':userlogin', $_POST['userlogin']);
       $s->bindValue(':userpassword', $_POST['userpassword']);
       $s->bindValue(':useremail', $_POST['useremail']);
    $s->execute();
    
     $sql = 'INSERT INTO userrole SET
        userlogin = :userlogin, roleid = :role';
    $s = $pdo->prepare($sql);
    $s->bindValue(':userlogin', $_POST['userlogin']);
    $s->bindValue(':role', $_POST['role']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Błąd przy dodawaniu użytkownika.';
    include '../error.html.php';
    exit();
  }
header('Location: .');
exit();
    }
}

try
{
  $sql = 'SELECT id FROM role';
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
  $roles[] = array(
    'id' => $row['id'],
  );
}
try
{
  $result = $pdo->query('SELECT login, email FROM users');
}
catch (PDOException $e)
{
  $error = 'Błąd bazy danych w trakcie pobierania listy użytkowników!';
  include '../error.html.php';
  exit();
}

foreach ($result as $row)
{
  $users[] = array('login' => $row['login'], 'email' => $row['email']);
}
include 'admin.html.php';
