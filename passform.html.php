<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <?php if(isset($success) or isset($_GET['success'])): ?><meta http-equiv="Refresh" content="3; <?php echo $_SERVER['PHP_SELF']; ?>" /> <?php     endif;?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline Admin</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="/voteonline/css/bootstrap.css">
    <link rel="stylesheet" href="/voteonline/css/bootstrap-theme.css">
    <link rel="stylesheet" href="/voteonline/css/style.css">
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
              <ul class="nav navbar-nav" >
                    <li><a href="/voteonline/voteadmin/">Panel Administratora Głosowania</a></li>
                    <li><a href="/voteonline/admin/">Panel Administratora</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="" data-toggle="modal" data-target="#myModal"><?php htmlout($loginstate) ?></a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>
    <hr/>
    <div class="container">
        <?php if(isset($success)): ?> <div class="row alert alert-success"><p class="text-center"><?php echo($success) ?></p></div> <?php endif;?>
        <?php if(isset($passerror)): ?> <div class="row alert alert-danger"><p class="text-center"><?php echo($passerror);?></p></div> <?php endif;?>
        <!--<img src="/voteonline/VO_1.png" class="img-responsive center-block"> -->
        <div class="row">
            <div class="panel panel-primary">
                <?php if(isset($action)): ?>
                <div class="panel-heading text-center"><?php echo $action; ?></div>
                <div class="panel-body">
                    <form action="" method="post">
                        <label for="newpass1">Nowe hasło:<input type="password" name="newpass1" id="newpass1" class="form-control" placeholder="Podaj nowe hasło" required></label>
                        <label for="newpass2">Powtórz nowe hasło:<input type="password" name="newpass2" id="newpass2" class="form-control" placeholder="Ponownie podaj nowe hasło" required></label>
                        <input class="btn btn-default"type="submit" name="passreset" value="Zmień">
                    </form>    
                </div>
                <?php endif; if(!isset($action)): ?>
                <div class="panel-heading text-center">Zmiana hasła</div>
                <div class="panel-body">
                    <form action="" method="post">
                        <label for="actpass">Aktualne hasło:<input type="password" name="actpass" id="actpass" class="form-control" placeholder="Podaj aktualne hasło" required></label>
                        <label for="newpass1">Nowe hasło:<input type="password" name="newpass1" id="newpass1" class="form-control" placeholder="Podaj nowe hasło" required></label>
                        <label for="newpass2">Powtórz nowe hasło:<input type="password" name="newpass2" id="newpass2" class="form-control" placeholder="Ponownie podaj nowe hasło" required></label>
                        <input class="btn btn-default"type="submit" name="passedit" value="Zmień">
                    </form>    
                </div>
                <?php                 endif;?>
            </div>
        <div class="text-center">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><button class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Powrót</button></a>
         </div>
        <br>
        </div>
    </div>
    <!-- Wyskakujące okno logowania -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <?php include '../logout.inc.html.php';?>  
        </div>
      </div></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
