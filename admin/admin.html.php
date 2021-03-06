<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/voteonline/include/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php if(isset($success) or isset($_GET['success'])): ?><meta http-equiv="Refresh" content="3; url=/voteonline/admin/" /> <?php     endif;?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline Admin</title>
    <link rel="shortcut icon" href="/voteonline/img/favicon.ico">
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
                <a href="/voteonline/"><img src="/voteonline/img/VO_1.png" alt="logo aplikacji" class="navlogo"></a>
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
    <hr/>
    <div class="container">
        <?php if(isset($success)): ?> <div class="row alert alert-success"><p class="text-center"><?php htmlprint($success) ?></p></div> <?php endif;?>
       <!--<?php if(isset($_GET['success'])): ?> <div class="row alert alert-success"><p class="text-center"><?php htmlprint('Hasło użytkownika zostało zmienione'); ?></p></div> <?php endif;?>-->
        <?php if(isset($error)): ?> <div class="row alert alert-danger"><p class="text-center"><?php htmlprint($error); ?></p></div> <?php endif;?>
<!--<img src="/voteonline/img/VO_1.png" alt="logo aplikacji" class="img-responsive center-block"> -->
        <div class="row">
            <form action="" method="post">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Dodawanie nowego użytkownika</div>
                    <div class="panel-body">
                    <div><label for="userlogin">Login: <input type="text" class="form-control <?php if(isset($error)) echo('alert-danger') ?>" name="userlogin"
                                                              id="userlogin" placeholder="Podaj login" value="<?php if(isset($error)) htmlprint($userlogin); ?>" required></label>
                    <label for="userpassword">Hasło: <input type="password" class="form-control" name="userpassword"
                                                            id="userpassword" placeholder="Podaj hasło" required></label>
                    <label for="useremail">Adres email: <input type="email" class="form-control" name="useremail"
                                                               id="useremail" placeholder="Podaj adres email" value="<?php if(isset($error)) htmlprint($useremail); ?>" required></label>
                    </div>
                    <div>
                        <?php foreach ($roles as $role): ?>
                        <label><hn title="Rola jaką ma posiadać dodawany użytkownik"><input type="radio" name="role"
                            id="<?php htmlprint($role['id']); ?>" value="<?php htmlprint($role['id']); ?>" required><?php htmlprint($role['id']); ?></hn></label>
                        <?php endforeach; ?>
                    </div>
                        <input type="submit" class="btn btn-default" name="adduser" value="Dodaj">
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="row hidden-sm hidden-xs">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading text-center">Użytkownicy Voteonline:</div>
                    <div class="panel-body">
                        <table class="table table-bordered table-responsive text-center">
                            <tr class="info"><td><b>Login</b></td><td><strong>Adres email</strong></td><td><strong>Uprawnienia</strong></td></tr>
                                <?php foreach ($users as $user): ?>
                                <form action="" method="get">
                                    <tr><input type="hidden" name="login" value="<?php htmlprint ($user['login']); ?>"><td><?php htmlprint($user['login']); ?></td><td><?php htmlprint($user['email']); ?></td><td><?php htmlprint($user['roleid']); ?></td><td>
                                        <input type="submit" class="btn btn-default" name="action" value="Edytuj">
                                        <input type="submit" class="btn btn-warning" name="action" value="Resetuj hasło">
                                        <input type="submit" class="btn btn-danger"name="action" value="Usuń"></td></tr></form>
                                <?php endforeach; ?>
                        </table>
                     <?php if(isset($menageuserid)): ?>
                    <br />
                    <form action="" method="post">
                        <fieldset>
                            <legend class="text-center">Edycja danych użytkownika</legend>
                        <input type="hidden" name="userid" value="<?php htmlprint($menageuserid); ?>">
                        <label for="newuserlogin">Login<input class="form-control"type="text" name="newuserlogin" id="newuserlogin" value="<?php htmlprint($menageuserlogin); ?>"required></label>
                        <label for="newuseremail">Email<input class="form-control"type="text" name="newuseremail" id="newuseremail" value="<?php htmlprint($menageuseremail); ?>"required></label>
                         <?php foreach ($roles as $role): ?>
                        <label><hn title="Rola"><input type="radio" name="newroleid"
                            id="<?php htmlprint($role['id']); ?>" value="<?php htmlprint($role['id']); ?>" required <?php if($menageuserrole == $role['id']) htmlprint('checked'); ?>><?php htmlprint($role['id']); ?></hn></label>
                        <?php endforeach; ?>
                        <input type="submit" name="menage" value="Zapisz" class="btn btn-default">
                        </fieldset>
                        </form>
                    <?php                    endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="" method="get">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Funkcje</div>
                    <div class="panel-body text-center">
                        <input type="submit" class="btn btn-default" name="action" value="Zmiana hasła">
                        <input type="submit" class="btn btn-default" name="action" value="Dziennik zdarzeń">
                    </div>
                </div>
                </form>
            </div>
        </div>
    <!-- Wyskakujące okno logowania -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/voteonline/templates/logout.inc.html.php';?>  
        </div>
      </div></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
