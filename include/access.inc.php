<?php

function userIsLoggedIn()
{
  if (isset($_POST['action']) and $_POST['action'] == 'login')
  {
    if (!isset($_POST['userlogin']) or $_POST['userlogin'] == '' or
      !isset($_POST['password']) or $_POST['password'] == '')
    {
      $GLOBALS['loginError'] = 'Oba pola muszą zostać wypełnione';
      return FALSE;
    }

    $password = md5($_POST['password'] . 'voapp');

    if (databaseContainsAuthor($_POST['userlogin'], $password))
    {
      session_start();
      $_SESSION['loggedIn'] = TRUE;
      $_SESSION['userid'] = $GLOBALS['userID'];
      $_SESSION['userlogin'] = $_POST['userlogin'];
      $_SESSION['password'] = $password;
        
        include $_SERVER['DOCUMENT_ROOT'] . '/voteonline/include/db.inc.php';
 try {
        $sql = 'INSERT INTO adminlog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Logowanie do aplikacji z IP:' . $_SERVER['REMOTE_ADDR']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' .$e->getMessage();
        include '../error.html.php';
        exit();
    }
      return TRUE;
    }
    else
    {
      session_start();
      unset($_SESSION['loggedIn']);
      unset($_SESSION['userid']);
      unset($_SESSION['userlogin']);
      unset($_SESSION['password']);
      $GLOBALS['loginError'] =
          'Login lub hasło są niepoprawne.';
      return FALSE;
    }
  }

  if (isset($_POST['action']) and $_POST['action'] == 'logout')
  {
    session_start();
    unset($_SESSION['loggedIn']);
    unset($_SESSION['userlogin']);
    unset($_SESSION['password']);
    header('Location: ' . $_POST['goto']);
    exit();
  }

  session_start();
  if (isset($_SESSION['loggedIn']))
  {
    return databaseContainsAuthor($_SESSION['userlogin'], $_SESSION['password']);
  }

}

function databaseContainsAuthor($login, $password)
{
  include 'db.inc.php';

  try
  {
    $sql = 'SELECT COUNT(*) FROM users
        WHERE login = :userlogin AND password = :password';
    $s = $pdo->prepare($sql);
    $s->bindValue(':userlogin', $login);
    $s->bindValue(':password', $password);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Błąd przy wyszukiwaniu użytkownika.';
    include 'error.html.php';
    exit();
  }

  $row = $s->fetch();

  if ($row[0] > 0)
  {
      try {
        $sql = 'SELECT id FROM users WHERE login = :userlogin';
        $s = $pdo->prepare($sql);
        $s->bindValue(':userlogin', $login);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu identyfikatora użytkownika.';
        include 'error.html.php';
        exit();
    }
      global $userID;
    foreach ($s as $row) {
        $userID = $row['id'];
    }
    return TRUE;
  }
  else
  {
    return FALSE;
  }
    
}

function userHasRole($role)
{
  include 'db.inc.php';

  try
  {
    $sql = "SELECT COUNT(*) FROM users
        WHERE id = :userid AND roleid = :roleId";
    $s = $pdo->prepare($sql);
    $s->bindValue(':userid', $_SESSION['userid']);
    $s->bindValue(':roleId', $role);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Błąd przy wyszukiwaniu roli użytkownika.';
    include 'error.html.php';
    exit();
  }
  $row = $s->fetch();

  if ($row[0] > 0)
  {
    return TRUE;
  }
  else
  {
    return FALSE;
  }
}