<?php

include_once $_SERVER['DOCUMENT_ROOT'] .
        '/include/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .
        '/include/access.inc.php';

if (!userIsLoggedIn()) {
    $loginstate = 'Zaloguj';
    include '../login.html.php';
    exit();
} else {
    $loginstate = 'Wyloguj(' . $_SESSION['userlogin'] . ')';
}
if (!userHasRole('Administrator')) {
    $error = 'Dostęp do tej strony mają tylko Administratorzy';
    include '../accessdenied.html.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';


//Dodawanie nowego użytkownika
if (isset($_POST['adduser'])) {
    if (isset($_POST['userlogin']) and isset($_POST['userpassword']) and isset($_POST['useremail']) and $_POST['userlogin'] != '' and $_POST['userpassword'] != '' and $_POST['useremail'] != '') {
        try {
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
        } catch (PDOException $e) {
            $error = 'Błąd przy dodawaniu użytkownika.';
            include '../error.html.php';
            exit();
        }
        $success = 'Pomyślnie dodano użytkownika';
        //include '../success.inc.html.php';
    }
}
//zmiana hasła przez użytkownika
if (isset($_POST['action']) and $_POST['action'] == 'editpass') {

    include '../passform.html.php';
    exit();
}
if (isset($_POST['passedit'])) {
    if ($_POST['actpass'] == $_SESSION['password']) {
        if ($_POST['newpass1'] == $_POST['newpass2']) {
            try {
                $sql = 'UPDATE users SET
        password = :password WHERE login = :userlogin';
                $s = $pdo->prepare($sql);
                $s->bindValue(':password', $_POST['newpass1']);
                $s->bindValue(':userlogin', $_SESSION['userlogin']);
                $s->execute();
            } catch (PDOException $e) {
                $error = 'Błąd podczas zapisu zmienionego hasła do bazy.';
                include '../error.html.php';
                exit();
            }
            $success = 'Hasło zostało zmienione';
        } else if ($_POST['newpass1'] != $_POST['newpass2']) {
            $passerror = 'Powtórzone hasło jest nieprawidłowe';
            include '../passform.html.php';
            exit();
        }
    } else {
        $passerror = 'Podane aktualne hasło jest nieprawidłowe';
        include '../passform.html.php';
        exit();
    }
}

if (isset($_POST['action']) and $_POST['action'] == 'Usuń') {
    try
    //usuwanie powiązania użytkownika z rolą  
    {
        $sql = 'DELETE FROM userrole WHERE userlogin = :login';
        $s = $pdo->prepare($sql);
        $s->bindValue(':login', $_POST['login']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy usuwaniu autora.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
//usuwanie użytkownika
    try {
        $sql = 'DELETE FROM users WHERE login = :login';
        $s = $pdo->prepare($sql);
        $s->bindValue(':login', $_POST['login']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy usuwaniu autora.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

try {
    $sql = 'SELECT id FROM role';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd przy pobieraniu wariantów: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $roles[] = array(
        'id' => $row['id'],
    );
}
try {
    $result = $pdo->query('SELECT login, email, roleid FROM users INNER JOIN userrole ON userlogin = users.login ');
} catch (PDOException $e) {
    $error = 'Błąd bazy danych w trakcie pobierania listy użytkowników!';
    include '../error.html.php';
    exit();
}

foreach ($result as $row) {
    $users[] = array('login' => $row['login'], 'email' => $row['email'], 'roleid' => $row['roleid']);
}
include 'admin.html.php';
