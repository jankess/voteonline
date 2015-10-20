<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Logowanie do Voteonline</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style>body{padding-top:50px;}.starter-template{padding:40px 15px;text-align:center;}.img-responsive { max-width: 35%;}</style>

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
                <a class="navbar-brand" href="/voteonline/">VoteOnline</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="">Panel Administratora</a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        <img src="/voteonline/VO_1.png" class="img-responsive center-block">
        <h1>Logowanie</h1>
    <p>Strona dostępna tylko dla zalogowanych użytkowników.</p>
    <?php if (isset($loginError)): $alert = 'alert alert-danger'; ?>
          <div class="<?php echo($alert); ?>"><p><?php htmlout($loginError);?></p></div>
      <?php else: $alert = ''; endif; ?>
    <form action="" method="post">
        <div>
            <label for="userlogin">Login:<input type="text" name="userlogin" id="userlogin" class="form-control <?php echo($alert); ?>"></label>
        </div>  
        <div>
            <label for="password">Hasło:<input type="password" name="password" id="password" class="form-control <?php echo($alert); ?>"></label>
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
