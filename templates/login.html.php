<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/voteonline/include/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Logowanie do Voteonline</title>
    <link rel="shortcut icon" href="/voteonline/img/favicon.ico">
    <link rel="stylesheet" href="/voteonline/css/bootstrap.css">
    <link rel="stylesheet" href="/voteonline/css/bootstrap-theme.css">
    <link rel="stylesheet" href="/voteonline/css/style.css">
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
                <a href="/voteonline/"><img src="/voteonline/img/VO_1.png" alt="logo aplikacji" class="navlogo"></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/voteonline/voteadmin/">Panel Administratora Głosowania</a></li>
                    <li><a href="/voteonline/admin/">Panel Administratora</a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        <img src="/voteonline/img/VO_1.png" alt="logo aplikacji" class="img-responsive center-block">
        <h1>Logowanie</h1>
        <p>Strona dostępna tylko dla zalogowanych użytkowników.</p>
        <?php if (isset($loginError)): $alert = 'alert alert-danger'; ?>
        <div class="<?php htmlprint($alert); ?>"><p class="text-center"><?php htmlprint($loginError);?></p></div>
        <?php else: $alert = ''; endif; ?>
        <form action="" method="post">
            <div>
                <label for="userlogin">Login:<input type="text" name="userlogin" id="userlogin" class="form-control <?php htmlprint($alert); ?>"></label>
            </div>  
            <div>
                <label for="password">Hasło:<input type="password" name="password" id="password" class="form-control <?php htmlprint($alert); ?>"></label>
            </div>
            <div>
                <input type="hidden" name="action" value="login">
                <input type="submit" value="Zaloguj" class="btn btn-default">
            </div>
        </form>  
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
