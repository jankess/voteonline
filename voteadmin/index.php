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
if (!userHasRole('VoteAdministrator')) {
    $error = 'Dostęp do tej strony mają tylko Administratorzy głosowania';
    include '../templates/accessdenied.html.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/voteonline/include/db.inc.php';

//Dodawanie nowego wariantu
if (isset($_POST['newvariant']) and $_POST['newvariant'] != '') {
    $newvariantdata = explode(",", $_POST['votingselect']);
    try {
        $sql = 'INSERT INTO variants SET
        name = :name, votingid = :votingid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['newvariant']);
        $s->bindValue(':votingid', $newvariantdata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania nowego wariantu do bazy.';
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Dodanie nowego wariantu "' . $_POST['newvariant'] . '" do głosowania "' . $newvariantdata[1] . '"');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
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
        $error = 'Błąd podczas dodawania nowego głosowania do bazy.';
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Dodanie nowego głosowania "' . $_POST['votingname'] . '"');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Nowe głosowanie zostało dodane';
}
//Pobieranie informacji na temat głosowań
try {
    include $_SERVER['DOCUMENT_ROOT'] . '/voteonline/include/db.inc.php';
    $sql = 'SELECT id, name , description, active FROM voting';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania danych głosowań.' . $e->getMessage();
    include '../templates/error.html.php';
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
    $error = 'Błąd podczas pobierania danych aktywnego głosowania.' . $e->getMessage();
    include '../templates/error.html.php';
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
    $error = 'Błąd podczas pobierania liczby oddanych głosów.';
    include '../templates/error.html.php';
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
//pokazywanie wyników głosowania
if(isset($_GET['action']) and $_GET['action'] == 'Pokaż'){
    try {
    $sql = 'SELECT variants.id, variants.name FROM variants INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votingid';
      $s = $pdo->prepare($sql);
      $s->bindValue(':votingid', $_GET['votingresults']);
      $s->execute();
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania liczby głosów.';
    include '../templates/error.html.php';
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
            $error = 'Błąd podczas pobierania liczby głosów.';
            include '../templates/error.html.php';
            exit();
        }
        $result = $s->fetch();
        $voteResults[] = $result[0];
    }
}
try {
    $sql = 'SELECT COUNT(*) FROM votes INNER JOIN variants ON votes.variantid = variants.id INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votingid';
     $s = $pdo->prepare($sql);
      $s->bindValue(':votingid', $_GET['votingresults']);
      $s->execute();
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania liczby oddanych głosów.';
    include '../templates/error.html.php';
    exit();
}
$voteCount = $s->fetch();
    
}  else {
    
//Pobieranie informacji o wariantach
try {
    $sql = 'SELECT variants.id, variants.name FROM variants INNER JOIN voting ON variants.votingid = voting.id WHERE voting.active = 1';
    $s = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania informacji o wariantach.';
    include '../templates/error.html.php';
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
            $error = 'Błąd podczas pobierania informacji na temat ilości oddanych głosów na konkretny wariant.';
            include '../templates/error.html.php';
            exit();
        }
        $result = $s->fetch();
        $voteResults[] = $result[0];
    }
}
}
//Wybór głosowania do aktywacji
if (isset($_POST['votingactiv'])) {
    $activationdata = explode(",", $_POST['votingactiv']);
    try {
        $sql = 'UPDATE voting SET
        active = "0" ';
        $s = $pdo->query($sql);
        $sql = 'UPDATE voting SET
        active = "1" WHERE id = :votingactive';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votingactive', $activationdata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas aktywacji głosowania.';
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Głosowanie "' . $activationdata[1] . '" zostało aktywowane');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Wybrane głosowanie zostało aktywowane';
}
//zmiana hasła własnego
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
    //if (isset($_GET['editpass'])){
    include '../templates/passform.html.php';
    exit();
}
if (isset($_GET['votmenselect']) and $_GET['menage'] == 'Zarządzaj wariantami głosowania') {
    $votedata = explode(",", $_GET['votmenselect']);
    try {
        $sql = 'SELECT variants.id, variants.name FROM variants INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $votedata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania danych wariantów.';
        include '../templates/error.html.php';
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
    $variantdata = explode(",", $_POST['variantid']);
    $votedata = explode(",", $_GET['votmenselect']);
    try
    {
    //usuwanie głosów powiązanych z wariantem {
        $sql = 'DELETE FROM votes WHERE variantid = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $variantdata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas usuwania głosów powiązanych z wariantem.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
//usuwanie wariantu
    try {
        $sql = 'DELETE FROM variants WHERE id = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $variantdata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas usuwania wariantu.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Usunięcie wariantu "' . $variantdata[1] . '" ('. $votedata[1] .') oraz powiązanych z nim głosów');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Wybrany wariant został usunięty';
}

//Zarządzanie danymi głosowania
if (isset($_GET['votmenselect']) and $_GET['menage'] == 'Zarządzaj danymi głosowania') {
    $votedata = explode(",", $_GET['votmenselect']);
    try {
        $sql = 'SELECT id,name,description FROM voting WHERE id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $votedata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania danych wybranego głosowania.';
        include '../templates/error.html.php';
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
    $votingdata = explode(",", $_POST['votingid']);
    echo $votingdata[1];
    try {
        $sql = 'UPDATE voting SET name = :newvotingname, description = :newvotingdesc WHERE id = :votingid ';
        $s = $pdo->prepare($sql);
        $s->bindValue(':newvotingname', $_POST['newvotingname']);
        $s->bindValue(':newvotingdesc', $_POST['newvotingdesc']);
        $s->bindValue(':votingid', $votingdata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas zapisu nowych danych głosowania.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        if($_POST['newvotingname'] != $votingdata[1]) {$s->bindValue(':action', 'Zmiana danych głosowania "' . $votingdata[1] . '" - nowa nazwa "' .$_POST['newvotingname'] .'"' );}else{
        $s->bindValue(':action', 'Zmiana danych głosowania "' . $votingdata[1] . '"');}
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Dane wybranego glosowania zostały zmienione';
}
if (isset($_GET['votmenselect']) and $_GET['menage'] == 'Usuń głosowanie') {
    $votedata = explode(",", $_GET['votmenselect']);
    try {
        $sql = 'SELECT COUNT(*) FROM votes INNER JOIN variants ON votes.variantid = variants.id INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $votedata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania liczby głosów powiązanych z głosowaniem.';
        include '../templates/error.html.php';
        exit();
    }
    $votecheck = $s->fetch();
    try {
        $sql = 'SELECT COUNT(*) FROM variants where variants.votingid = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $votedata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania liczby wariantów powiązanych z głosowaniem';
        include '../templates/error.html.php';
        exit();
    }
    $variantcheck = $s->fetch();
    if ($votecheck[0] > 0) {
        try {
            $sql = 'DELETE votes FROM votes INNER JOIN variants ON variants.id = votes.variantid INNER JOIN voting ON variants.votingid = voting.id WHERE voting.id = :votmenselect';
            $s = $pdo->prepare($sql);
            $s->bindValue(':votmenselect', $votedata[0]);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Bład podczas usuwania głosów powiązanych z głosowaniem.' . $e->getMessage();
            include '../templates/error.html.php';
            exit();
        }
    }
    if ($variantcheck[0] > 0) {
        try {
            $sql = 'DELETE FROM variants WHERE variants.votingid= :votmenselect';
            $s = $pdo->prepare($sql);
            $s->bindValue(':votmenselect', $votedata[0]);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Bład podczas usuwania wariantów powiązanych z głosowaniem.' . $e->getMessage();
            include '../templates/error.html.php';
            exit();
        }
    }
    try {
        $sql = 'DELETE FROM voting WHERE id = :votmenselect';
        $s = $pdo->prepare($sql);
        $s->bindValue(':votmenselect', $votedata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Bład podczas usuwania głosowania.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Usunięcie głosowania "' . $votedata[1] . '" oraz powiązanych z nim wariantów i głosów');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    $success = 'Wybrane głosowanie zsotało usunięte';
}
if (isset($_POST['action']) and $_POST['action'] == 'Edytuj') {
    $variantdata = explode(",", $_POST['variantid']);
    try {
        $sql = 'SELECT name FROM variants WHERE id = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $variantdata[0]);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania danych wariantu.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    foreach ($s as $row) {
        $menagevariantname = $row['name'];
    }
    $type = 'variant';
    $menagevariantid = $variantdata[0];
}
if (isset($_POST['actionvar']) and $_POST['actionvar'] == 'Zapisz') {
    $variantdata = explode(",", $_POST['variantid']);
    $votedata = explode(",", $_GET['votmenselect']);
    try {
        $sql = 'UPDATE variants SET name = :menagevariant WHERE id = :variantid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $variantdata[0]);
        $s->bindValue(':menagevariant', $_POST['menagevariant']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas zapisu nowych danych wariantu' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    try {
        $sql = 'INSERT INTO votelog SET inituserinfo = :inituser, action = :action, actiondate = NOW()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':inituser', $_SESSION['userlogin']);
        $s->bindValue(':action', 'Edycja wariantu "' . $variantdata[1] . '" (' . $votedata[1] . ') - nowa nazwa "'. $_POST['menagevariant']. '"');
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas dodawania wpisu dziennika zdarzeń do bazy.' . $e->getMessage();
        include '../templates/error.html.php';
        exit();
    }
    header('refresh: 0;');
}
if (isset($_GET['action']) and $_GET['action'] == "Dziennik zdarzeń") {
    try {
        $sql = 'SELECT inituserinfo, action, actiondate FROM votelog ORDER BY id DESC';
        $result = $pdo->query($sql);
    } catch (PDOException $e) {
        $error = 'Błąd podczas pobierania wpisów dziennika zdarzeń.' . $e->getMessage();
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
include 'voteadmin.html.php';
?>
