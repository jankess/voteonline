<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/voteonline/include/helpers.inc.php'; 
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <?php if(isset($success)): ?><meta http-equiv="Refresh" content="3; url=/voteonline" /> <?php     endif;?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline</title>
    <link rel="shortcut icon" href="/voteonline/img/favicon.ico">
    <link rel="stylesheet" href="/voteonline/css/bootstrap.css">
    <link rel="stylesheet" href="/voteonline/css/bootstrap-theme.css">
    <link rel="stylesheet" href="/voteonline/css/style.css">
    <link rel="stylesheet" href="/voteonline/css/radio.css">
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">VoteOnline</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <li><a href="/voteonline/"><img src="/voteonline/img/VO_1.png" alt="Logo aplikacji" class="navlogo"></a></li>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav" >
                    <li><a href="/voteonline/voteadmin/">Panel Administratora Głosowania</a></li>
                    <li><a href="/voteonline/admin/">Panel Administratora</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="" data-toggle="modal" data-target="#myModal"><?php htmlprint($loginstate) ?></a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>
    <div class="container">
        <img src="/voteonline/img/VO_1.png" alt="logo aplikacji" class="img-responsive center-block"> 
        <div class="row">
            <?php if(isset($success)): ?> <div class="row alert alert-success"><p class="text-center"><?php htmlprint($success) ?></p></div> <?php endif;?>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <form action="" method="post">
                <h2><?php if(isset($votingdescription)) echo $votingdescription; else echo 'Brak głosowań'; ?></h2>
                <?php if(isset($variants)){foreach ($variants as $variant): ?>
                <div><input type="radio" name="variants"
                    id="<?php htmlprint($variant['id']); ?>"
                    value="<?php htmlprint($variant['id']); ?>" required <?php if(isset($_COOKIE[$votingid])) echo 'disabled';?>><label for="<?php htmlprint($variant['id']); ?>"><span></span><?php htmlprint($variant['name']); ?></label></div>
                <?php endforeach; }else echo 'Do głosowania nie został jeszcze dodany żaden wariant';?>
                <div>
                <?php if(isset($variants)): ?><input type="submit" class="btn <?php if(isset($_COOKIE[$votingid])) echo 'btn-danger'; else echo 'btn-default'; ?>" value="<?php if(isset($_COOKIE[$votingid])) echo 'Wziąłeś już udział w tym głosowaniu'; else echo 'Głosuj'; ?>" 
                    <?php if(isset($_COOKIE[$votingid])) echo 'disabled'; ?>> <?php endif; ?>
                </div>
                </form>
            </div>
            <!--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <h2>Dane głosującego</h2>
                <div class="form-group">
                    <label for="sel1">Płeć:</label>
                    <select class="form-control" id="sex" required>
                        <option>K</option>
                        <option>M</option>
                    </select>
                </div>
            </div>
            </form>
        </div>-->
    </div>
        <hr>
         <footer>
                <div class="row">
                    <div class="col-lg-4 text-left">
                        <p>Copyright &copy; Kucharski Michał 2015</p>
                    </div>
                    <div class="col-lg-offset-5 col-lg-3 text-right">
                        
                        <p><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:starcar@gmail.com">mkucharski13@gmail.com</a>
                </p>   
                    </div>
                </div>
            </footer>
    </div>
    
 <!-- Wyskakujące okno logowania -->
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <?php if ($loginstate == 'Zaloguj'): include $_SERVER['DOCUMENT_ROOT'] .  '/voteonline/include/login.inc.html.php'; ?>
    <?php elseif($loginstate != 'Zaloguj'): include  $_SERVER['DOCUMENT_ROOT'] . '/voteonline//include/logout.inc.html.php'; endif ?>  
  </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
