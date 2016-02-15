<?php

include_once $_SERVER['DOCUMENT_ROOT'] .
        '/voteonline/include/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .
        '/voteonline/include/access.inc.php';

if (!userIsLoggedIn()) {
    $loginstate = 'Zaloguj';
    include '../templates/login.html.php';
    exit();
} else {
    $loginstate = 'Wyloguj(' . $_SESSION['userlogin'] . ')';
}
if (!userHasRole('Administrator')) {
    $error = 'Dostęp do tej strony mają tylko Administratorzy';
    include '../templates/accessdenied.html.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/voteonline/include/db.inc.php';

//wybór danych użytkownika do edycji
if (isset($_GET['action']) and $_GET['action'] == 'Edytuj') {
    try {
        $sql = 'SELECT id, login, email, roleid FROM users WHERE login = :login';
        $s = $pdo->prepare($sql);
        $s->bindValue(':login', $_GET['login']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania danych użytkownika.';
        include '../templates/error.html.php';
        exit();
    }
    foreach ($s as $row) {
        $menageuserid = $row['id'];
        $menageuserlogin = $row['login'];
        $menageuseremail = $row['email'];
        $menageuserrole = $row['roleid'];
    }
}
//Edycja danych użytkownika
if (isset($_POST['menage']) and $_POST['menage'] == 'Zapisz') {
    try {
        $sql = 'UPDATE users SET login = :login, email = :email, roleid = :roleid WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':login', $_POST['newuserlogin']);
        $s->bindValue(':email', $_POST['newuseremail']);
        $s->bindValue(':roleid', $_POST['newroleid']);
        $s->bindValue(':id', $_POST['userid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas zapisu nowych danych użytkownika.';
        include '../templates/error.html.php';
        exit();
    }
    try {
        if ($menageuserlogin != $_POST['newuserlogin'])
            $menageuserlogin .= ' (nowy login "' . $_POST['newuserlogin'] . '")';
        $sql = 'INSERT INTO adminlog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Edycja danych użytkownika "' . $menageuserlogin . '"');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Dane użytkownika zostały zmienione';
}
//reset hasła uzytkownika
if (isset($_POST['passreset'])) {
    if ($_POST['newpass1'] == $_POST['newpass2']) {
        try {
            $sql = 'UPDATE users SET
                password = :password WHERE login = :userlogin';
            $s = $pdo->prepare($sql);
            $s->bindValue(':password', md5($_POST['newpass1'] . 'voapp'));
            $s->bindValue(':userlogin', $_GET['login']);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Błąd podczas zapisu zmienionego hasła użytkownika do bazy.';
            include '../templates/error.html.php';
            exit();
        }
    } else if ($_POST['newpass1'] != $_POST['newpass2']) {
        $action = ' Reset hasła użytkownika <strong>' . $_GET['login'] . '</strong>';
        $passerror = 'Powtórzone hasło jest nieprawidłowe';
        include '../templates/passform.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO adminlog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Edycja hasła użytkownika "' . $_GET['login'] . '"');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    header('Location: .?success');
    exit();
}
if (isset($_GET['action']) and $_GET['action'] == 'Resetuj hasło') {
    $action = ' Reset hasła użytkownika <strong>' . $_GET['login'] . '</strong>';
    include '../templates/passform.html.php';
    exit();
}

//Dodawanie nowego użytkownika
if (isset($_POST['adduser'])) {
        try {
            $sql = 'SELECT COUNT(*) FROM users WHERE login = :userlogin';
            $s = $pdo->prepare($sql);
            $s->bindValue(':userlogin', $_POST['userlogin']);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Błąd podczas dodawania użytkownika do bazy.';
            include '../templates/error.html.php';
            exit();
        }
        $userexistscheck = $s->fetch();
        if ($userexistscheck[0] > 0) {
            $error = 'Podany login jest zajęty!';
            $userlogin = $_POST['userlogin'];
            $useremail = $_POST['useremail'];
        } else {
            try {
                $sql = 'INSERT INTO users SET
        login = :userlogin, password = :userpassword, email = :useremail, roleid=:role';
                $s = $pdo->prepare($sql);
                $s->bindValue(':userlogin', $_POST['userlogin']);
                $s->bindValue(':userpassword', md5($_POST['userpassword'] . 'voapp'));
                $s->bindValue(':useremail', $_POST['useremail']);
                $s->bindValue(':role', $_POST['role']);
                $s->execute();
            } catch (PDOException $e) {
                $error = 'Błąd podczas dodawania użytkownika do bazy.';
                include '../templates/error.html.php';
                exit();
            }
            $success = 'Pomyślnie dodano użytkownika';
            try {
                $sql = 'INSERT INTO adminlog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
                $s = $pdo->prepare($sql);
                $s->bindValue(':inituser', $_SESSION['userlogin']);
                $s->bindValue(':action', 'Dodanie użytkownika "' . $_POST['userlogin'] . '"');
                $s->execute();
            } catch (PDOException $e) {
                $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
                include '../templates/error.html.php';
                exit();
            }
        }
    }
//zmiana hasła przez użytkownika
if (isset($_POST['passedit'])) {
    if (md5($_POST['actpass'] . 'voapp') == $_SESSION['password']) {
        if ($_POST['newpass1'] == $_POST['newpass2']) {
            try {
                $sql = 'UPDATE users SET
                password = :password WHERE login = :userlogin';
                $s = $pdo->prepare($sql);
                $s->bindValue(':password', md5($_POST['newpass1'] . 'voapp'));
                $s->bindValue(':userlogin', $_SESSION['userlogin']);
                $s->execute();
            } catch (PDOException $e) {
                $error = 'Błąd podczas zapisu zmienionego hasła do bazy.';
                include '../templates/error.html.php';
                exit();
            }
            $success = 'Hasło zostało zmienione';
        } else if ($_POST['newpass1'] != $_POST['newpass2']) {
            $passerror = 'Powtórzone hasło jest nieprawidłowe';
            include '../templates/passform.html.php';
            exit();
        }
    } else {
        $passerror = 'Podane aktualne hasło jest nieprawidłowe';
        include '../templates/passform.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO adminlog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Zmiana własnego hasła dostępowego');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Hasło zostało zmienione';
}
if (isset($_GET['action']) and $_GET['action'] == 'Zmiana hasła') {
    include '../templates/passform.html.php';
    exit();
}

if (isset($_GET['action']) and $_GET['action'] == "Dziennik zdarzeń") {
    try {
        $sql = 'SELECT inituserinfo, action, actiondate FROM adminlog ORDER BY id DESC';
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania wpisów dziennika zdarzeń' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    foreach ($result as $row) {
        $logs[] = array(
            'inituserinfo' => $row['inituserinfo'],
            'action' => $row['action'],
            'actiondate' => $row['actiondate']
        );
    }
    include '../templates/logform.html.php';
    exit();
}

if (isset($_GET['action']) and $_GET['action'] == 'Usuń') {
//usuwanie użytkownika
    try {
        $sql = 'DELETE FROM users WHERE login = :login';
        $s = $pdo->prepare($sql);
        $s->bindValue(':login', $_GET['login']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas usuwania użytkownika.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO adminlog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Usunięcie użytkownika "' . $_GET['login'] . '"');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Użytkownik został usunięty';
}

try {
    $sql = 'SELECT id FROM role';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania danych ról z bazy.' . $e->getMessage();
    include '../templates/error.html.php';
    exit();
}
foreach ($result as $row) {
    $roles[] = array(
        'id' => $row['id'],
    );
}
try {
    $result = $pdo->query('SELECT login, email, roleid FROM users');
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania danych użytkowników z bazy.';
    include '../templates/error.html.php';
    exit();
}
foreach ($result as $row) {
    $users[] = array('login' => $row['login'], 'email' => $row['email'], 'roleid' => $row['roleid']);
}
include 'admin.html.php';
?>
