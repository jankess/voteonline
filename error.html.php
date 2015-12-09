<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="/voteonline/css/bootstrap.css">
    <link rel="stylesheet" href="/voteonline/css/bootstrap-theme.css">
    <style>body{padding-top:50px; background-image: url("img/fresh_snow.png");}.starter-template{padding:40px 15px;text-align:center;}.img-responsive { max-width: 35%;} .navlogo {width: 100px; height: 50px; }</style>

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                <a href="/voteonline/"><img src="/voteonline/VO_1.png" class="navlogo"></a>
            </div>
             <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/voteonline/voteadmin/">Panel Administratora Głosowania</a></li>
                    <li><a href="/voteonline/admin/">Panel Administratora</a></li>
                </ul>
                 <ul class="nav navbar-nav navbar-right">
                    <li><a href="" data-toggle="modal" data-target="#myModal"><?php if(!isset($_SESSION['loggedIn'])) { echo('Zaloguj');}else { echo('Wyloguj(' . $_SESSION['userlogin'] . ')');}?></a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>
    <div class="container">    
        <div class="alert alert-danger" role="alert">
            <p class="text-center">
            <?php echo $error; ?>
            </p>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
    <!-- Modal content-->
        <?php if (!isset($_SESSION['loggedIn'])): include 'login.inc.html.php'; ?>
        <?php elseif(isset($_SESSION['loggedIn']) or $loginstate != 'Zaloguj'): include 'logout.inc.html.php'; endif ?>  
    </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
