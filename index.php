<?php

include_once $_SERVER['DOCUMENT_ROOT'] .
        '/voteonline/include/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .
        '/voteonline/include/access.inc.php';
if (userIsLoggedIn() == FALSE) {
    $loginstate = 'Zaloguj';
} else {
    $loginstate = 'Wyloguj(' . $_SESSION['userlogin'] . ')';
}
try {
    include $_SERVER['DOCUMENT_ROOT'] . '/voteonline/include/db.inc.php';
    $sql = 'SELECT variants.id, variants.name FROM variants INNER JOIN voting ON variants.votingid = voting.id WHERE voting.active = 1';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania wariantów głosowania.' . $e->getMessage();
    include '/templates/error.html.php';
    exit();
}

foreach ($result as $row) {
    $variants[] = array(
        'id' => $row['id'],
        'name' => $row['name']
    );
}
try {
    $sql = 'SELECT id, description FROM voting WHERE active = 1';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = 'Błąd podczas pobierania danych głosowania.' . $e->getMessage();
    include '/templates/error.html.php';
    exit();
}
foreach ($result as $row) {
    $votingid = $row['id'];
    $votingdescription = $row['description'];
}
if (isset($_POST['variants']) and ( !isset($_COOKIE[$votingid]) or $_COOKIE[$votingid] != TRUE)) {
    include $_SERVER['DOCUMENT_ROOT'] . '/voteonline/include/db.inc.php';
    try {
        $sql = 'INSERT INTO votes SET
          variantid = :variantid,
          votedate = CURDATE()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':variantid', $_POST['variants']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Błąd podczas zapisu głosu do bazy';
        include '/templates/error.html.php';
        exit();
    }
    $voted = TRUE;
    setcookie($votingid, $voted, time() + 3600 * 24 * 365);
    $success = 'Dziękujemy za oddanie głosu';
} elseif (isset($_POST['variants']) and $_COOKIE[$votingid] == TRUE) {
    $error = 'Wziąłeś już udział w tym głosowaniu, kolejne oddanie głosu nie jest możliwe';
    include '/templates/error.html.php';
}
include 'votes.html.php';
