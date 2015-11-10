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
if (!userHasRole('VoteAdministrator'))
{
    $error = 'Dostęp do tej strony mają tylko Administratorzy głosowania';
    include '../accessdenied.html.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';
//Dodawanie nowego wariantu
if (isset($_POST['newvariant']) and $_POST['newvariant'] != '')
{
  try
  {
    $sql = 'INSERT INTO variants SET
        name = :name, votingid = :votingid';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['newvariant']);
    $s->bindValue(':votingid', $_POST['votingselect']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Błąd przy dodawaniu wariantu.';
    include '../error.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

if(isset($_POST['voting'])and $_POST['voting'] == 'Dodaj')
{
    try
  {
    $sql = 'INSERT INTO voting SET
        name = :name, description = :description';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['votingname']);
    $s->bindValue(':description', $_POST['votingdesc']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Błąd przy dodawaniu głosowania.';
    include '../error.html.php';
    exit();
  }

  header('Location: .');
  exit();    
}

try
{
include $_SERVER['DOCUMENT_ROOT'] . '/include/db.inc.php';
  $sql = 'SELECT id, name , description, active FROM voting';
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
  $votings[] = array(
    'id' => $row['id'],
    'name' => $row['name'],
    'description' => $row['description'],
     'active' => $row['active']
  );
}


//Liczenie ilośći oddanych głosów
try
{
$sql = 'SELECT COUNT(*) FROM votes';
$s = $pdo->query($sql);
}
catch (PDOException $e)
  {
    $error = 'Błąd przy pobieraniu liczby głosów.';
    include 'error.html.php';
    exit();
  }
$voteCount = $s->fetch();

//Liczenie ilości wariantów
try
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

//Pobieranie informacji o wariantach
try
{
$sql = 'SELECT id,name FROM variants';
$s = $pdo->query($sql);
}
catch (PDOException $e)
  {
    $error = 'Błąd przy pobieraniu liczby głosów.';
    include 'error.html.php';
    exit();
  }
foreach ($s as $row)
{
  $variantsId[] = $row['id'];
  $variantsName[] = $row['name'];
}
$voteResults = array();
//Zliczanie ilości oddanych głosów na dany wariant
for($i=0;$i<$variantsCount[0];$i++)
{
    try
    {
        $sql = "SELECT COUNT(*) FROM votes WHERE variantid = $variantsId[$i]";
        $s = $pdo->query($sql);
    }
    catch (PDOException $e)
    {
        $error = 'Błąd przy pobieraniu liczby głosów.';
        include 'error.html.php';
        exit();
    }
    $result = $s->fetch();
    $voteResults[] = $result[0];
}
if(isset($_POST['votingactiv']))
{
    try
  {
    $sql = 'UPDATE voting SET
        active = "0" ';
    $s = $pdo->prepare($sql);
    $s->bindValue(':votingactive', $_POST['votingactiv']);
    $s->execute();
    $sql = 'UPDATE voting SET
        active = "1" WHERE id = :votingactive';
    $s = $pdo->prepare($sql);
    $s->bindValue(':votingactive', $_POST['votingactiv']);
    $s->execute();

  }
  catch (PDOException $e)
  {
    $error = 'Błąd przy aktywacji głosowania.';
    include '../error.html.php';
    exit();
  }

  header('Location: .');
  exit();    
}
include 'voteadmin.html.php';