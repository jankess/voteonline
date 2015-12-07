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
if (!userHasRole('VoteAdministrator')) {
    $error = 'Dostęp do tej strony mają tylko Administratorzy głosowania';
    include '../accessdenied.html.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';

//Dodawanie nowego wariantu
if (isset($_POST['newvariant']) and $_POST['newvariant'] != '') {
    try {
        $sql = 'INSERT INTO variants SET
        name = :name, votingid = :votingid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['newvariant']);
        $s->bindValue(':votingid', $_POST['votingselect']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy dodawaniu wariantu.';
        include '../error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Dodanie nowego wariantu ("' . $_POST['newvariant'] . '") do głosowania (id:' . $_POST['votingselect'] . ')');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    $success = 'Nowy wariant został dodany';
}
//Dodawanie nowego głosowania
if (isset($_POST['voting'])and $_POST['voting'] == 'Dodaj') {
    try {
        $sql = 'INSERT INTO voting SET
        name = :name, description = :description';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['votingname']);
        $s->bindValue(':description', $_POST['votingdesc']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy dodawaniu głosowania.';
        include '../error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Dodanie nowego głosowania (' . $_POST['votingname'] . ')');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    $success = 'Nowe głosowanie zostało dodane';
}
//Pobieranie informacji na temat głosowań
try {
    include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';
    $sql = 'SELECT id, name , description, active FROM voting';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd przy pobieraniu wariantów: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}

foreach ($result as $row) {
    $votings[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
        'active' => $row['active']
    );
}
//pobieranie informacji na temat aktywnego głosowania
try {
    $sql = 'SELECT id,name FROM voting WHERE active = 1';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd przy pobieraniu wariantów: ' . $e->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $votingid = $row['id'];
    $votingname = $row['name'];
}

//Liczenie ilości oddanych głosów
try {
    $sql = 'SELECT COUNT(*) FROM votes INNER JOIN variants ON votes.variantid = variants.id INNER JOIN voting ON variants.votingid = voting.id WHERE voting.active = 1';
    $s = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd przy pobieraniu liczby głosów.';
    include 'error.html.php';
    exit();
}
$voteCount = $s->fetch();

//Liczenie ilości wariantów
/* try
  {
  $sql = 'SELECT COUNT(*) FROM variants';
  $s = $pdo->query($sql);
  }
  catch (PDOException $e)
  {
  $error = 'Błąd przy pobieraniu liczby wariantów.';
  include 'error.html.php';
  exit();
  }
  $variantsCount = $s->fetch();
 */

//Pobieranie informacji o wariantach
try {
    $sql = 'SELECT variants.id, variants.name FROM variants INNER JOIN voting ON variants.votingid = voting.id WHERE voting.active = 1';
    $s = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd przy pobieraniu liczby głosów.';
    include 'error.html.php';
    exit();
}
foreach ($s as $row) {
    //$variantsId[] = $row['id'];
    //$variantsName[] = $row['name'];
    $warianty[] = array(
        'id' => $row['id'],
        'name' => $row['name']
    );
}
//print_r($warianty);
$voteResults = array();
//Zliczanie głosów oddanych na konkretny wariant
if (isset($warianty)) {
    foreach ($warianty as $wariant) {
        $variantsId = $wariant['id'];
        try {
            $sql = "SELECT COUNT(*) FROM votes WHERE variantid = $variantsId";
            $s = $pdo->query($sql);
        } catch (PDOException $e) {
            $error = 'Błąd przy pobieraniu liczby głosów.';
            include 'error.html.php';
            exit();
        }
        $result = $s->fetch();
        $voteResults[] = $result[0];
    }
}
//Wybór głosowania do aktywacji
if (isset($_POST['votingactiv'])) {
    try {
        $sql = 'UPDATE voting SET
        active = "0" ';
        $s = $pdo->query($sql);
        $sql = 'UPDATE voting SET
        active = "1" WHERE id = :votingactive';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votingactive', $_POST['votingactiv']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktywacji głosowania.';
        include '../error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Głosowanie o id :' . $_POST['votingactiv'] . ' zostało aktywowane');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    $success = 'Wybrane głosowanie zostało aktywowane';
}
if (isset($_POST['action']) and $_POST['action'] == 'Zmiana hasła') {
    //if (isset($_GET['editpass'])){
    include '../passform.html.php';
    exit();
}
if (isset($_POST['passedit'])) {
    if (md5($_POST['actpass'] . 'voapp') == $_SESSION['password']) {
        if ($_POST['newpass1'] == $_POST['newpass2']) {
            try {
                $sql = 'UPDATE users SET
        password = :password WHERE login = :userlogin';
                $s = $pdo->prepare($sql);
                $s->bindValue(':password', MD5($_POST['newpass1'] . 'voapp'));
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
    try {
        $sql = 'INSERT INTO adminlog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Zmiana własnego hasła dostępowego');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    $success = 'Hasło zostało zmienione';
}
if (isset($_GET['votmenselect']) and $_GET['menage'] == 'Zarządzaj wariantami głosowania') {
    try {
        $sql = 'SELECT variants.id, variants.name FROM variants INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $_GET['votmenselect']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu liczby głosów.';
        include 'error.html.php';
        exit();
    }
    foreach ($s as $row) {
        //$variantsId[] = $row['id'];
        //$variantsName[] = $row['name'];
        $menagevariants[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
}
if (isset($_POST['action']) and $_POST['action'] == 'Usuń') {
    try
    {
    //usuwanie głosów powiązanych z wariantem {
        $sql = 'DELETE FROM votes WHERE variantid = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $_POST['variantid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy usuwaniu głosów powiązanych z wariantem.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
//usuwanie wariantu
    try {
        $sql = 'DELETE FROM variants WHERE id = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $_POST['variantid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy usuwaniu wariantu.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Usunięcie wariantu (id:' . $_POST['variantid'] . ') oraz powiązanych z nim głosów');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    $success = 'Wybrany wariant został usunięty';
}


if (isset($_GET['votmenselect']) and $_GET['menage'] == 'Zarządzaj danymi głosowania') {
    try {
        $sql = 'SELECT id,name,description FROM voting WHERE id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $_GET['votmenselect']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu wariantów wybranego głosowania.';
        include 'error.html.php';
        exit();
    }
    foreach ($s as $row) {
        //$variantsId[] = $row['id'];
        //$variantsName[] = $row['name'];

        $menagevotingid = $row['id'];
        $menagevotingname = $row['name'];
        $menagevotingdesc = $row['description'];
    }
}
if (isset($_POST['menage']) and $_POST['menage'] == 'Zapisz') {
    try {
        $sql = 'UPDATE voting SET name = :newvotingname, description = :newvotingdesc WHERE id = :votingid ';
        $s = $pdo->prepare($sql);
        $s->bindValue(':newvotingname', $_POST['newvotingname']);
        $s->bindValue(':newvotingdesc', $_POST['newvotingdesc']);
        $s->bindValue(':votingid', $_POST['votingid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu wariantów wybranego głosowania.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Zmiana danych głosowania (id:' . $_POST['votingid'] . ')');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    $success = 'Dane wybranego glosowania zostały zmienione';
}
if (isset($_GET['votmenselect']) and $_GET['menage'] == 'Usuń głosowanie') {
    try {
        $sql = 'SELECT COUNT(*) FROM votes INNER JOIN variants ON votes.variantid = variants.id INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $_GET['votmenselect']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu liczby głosów.';
        include 'error.html.php';
        exit();
    }
    $votecheck = $s->fetch();
    try {
        $sql = 'SELECT COUNT(*) FROM variants where variants.votingid = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $_GET['votmenselect']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu liczby głosów.';
        include 'error.html.php';
        exit();
    }
    $variantcheck = $s->fetch();
    if ($votecheck[0] > 0) {
        try {
            $sql = 'DELETE votes FROM votes INNER JOIN variants ON variants.id = votes.variantid INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votmenselect';
            $s = $pdo->prepare($sql);
            $s->bindValue(':votmenselect', $_GET['votmenselect']);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Błąd przy pobieraniu wariantów wybranego głosowania.' . $e->getMessage();
            include '../error.html.php';
            exit();
        }
    }
    if ($variantcheck[0] > 0) {
        try {
            $sql = 'DELETE FROM variants WHERE variants.votingid= :votmenselect';
            $s = $pdo->prepare($sql);
            $s->bindValue(':votmenselect', $_GET['votmenselect']);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Błąd przy pobieraniu wariantów wybranego głosowania.' . $e->getMessage();
            include '../error.html.php';
            exit();
        }
    }
    try {
        $sql = 'DELETE FROM voting WHERE id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $_GET['votmenselect']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu wariantów wybranego głosowania.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Usunięcie głosowania (id:' . $_GET['votmenselect'] . ') oraz powiązanych z nim wariantów i głosów');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    $success = 'Wybrane głosowanie zsotało usunięte';
}
if (isset($_POST['action']) and $_POST['action'] == 'Edytuj') {
    try {
        $sql = 'SELECT name FROM variants WHERE id = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $_POST['variantid']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu danych wybranego wariantu.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    foreach ($s as $row) {
        $menagevariantname = $row['name'];
    }
    $type = 'variant';
    $menagevariantid = $_POST['variantid'];
}
if (isset($_POST['actionvar']) and $_POST['actionvar'] == 'Zapisz') {
    try {
        $sql = 'UPDATE variants SET name = :menagevariant WHERE id = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $_POST['variantid']);
        $s->bindValue(':menagevariant', $_POST['menagevariant']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy pobieraniu danych wybranego wariantu.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Edycja danych wariantu (id:' . $_POST['variantid'] . ')');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd przy aktualizacji danych użytkownika.' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    header('refresh: 0;');
}
if (isset($_POST['action']) and $_POST['action'] == "Log administratora głosowania") {
    try {
        $sql = 'SELECT inituserinfo, action, actiondate FROM votelog';
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania logów' . $e->getMessage();
        include '../error.html.php';
        exit();
    }
    foreach ($result as $row) {
        $logs[] = array(
            'inituserinfo' => $row['inituserinfo'],
            'action' => $row['action'],
            'actiondate' => $row['actiondate']
        );
    }
    include '../logform.html.php';
    exit();
}
include 'voteadmin.html.php';
