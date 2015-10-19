<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style>body{padding-top:50px;}.starter-template{padding:40px 15px;text-align:center;}</style>

</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">VoteOnline</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/voteonline/">VoteOnline</a>
            </div>
          <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/voteonline/admin/">Panel Administratora</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="" data-toggle="modal" data-target="#myModal"><?php htmlout($loginstate) ?></a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>
    <div class="container">
        <div class="row">
        <form action="" method="post">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <br />
          <p><b>Dodawanie nowego wariantu do głosowania</b></p>
        <label for="name">Nazwa wariantu: <input type="text" class="form-control" name="name"
            id="name"></label>
          <input type="submit" class="btn btn-default" value="Dodaj"></form>
      </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <br />
         <h3>Ogólne dane głosowania</h3>
         <p>Ilość oddanych głosów: <?php echo $voteCount[0]; ?></p>
         <p>Ilość wariantów odpowiedzi: <?php echo $variantsCount[0]; ?></p>
         <h3>Sczegółowe dane głosowania</h3>
         <?php for($i=0;$i<$variantsCount[0];$i++): ?>
         <p><?php echo $variantsName[$i]; echo ': ' . $voteResults[$i] . ' (' . round((($voteResults[$i]/$voteCount[0])*100),2) . '%)' ; ?></p>
         <?php endfor; ?>
        <button class="btn btn-default"><a href="..">Powrót do storny głównej</button></a>
            </div>
          </div>
        </div>
    
    <!-- Wyskakujące okno logowania -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <?php include '../logout.inc.html.php';?>  
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
