<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php if(isset($success) or isset($_GET['success'])): ?><meta http-equiv="Refresh" content="3; url=/voteonline/admin/" /> <?php     endif;?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline Admin</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" href="/voteonline/css/bootstrap.css">
    <link rel="stylesheet" href="/voteonline/css/bootstrap-theme.css">
    <style>body{padding-top:50px;}.starter-template{padding:40px 15px;text-align:center;}.img-responsive { max-width: 35%;}
        .navlogo {width: 100px; height: 50px; } .active{ border-left:solid; border-width: 1px;}</style>

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
        <?php if(isset($_GET['success'])): ?> <div class="row alert alert-success"><p class="text-center"><?php echo 'Hasło użytkownika zostało zmienione'; ?></p></div> <?php endif;?>
<!--<img src="/voteonline/VO_1.png" class="img-responsive center-block"> -->
        <div class="row">
            <form action="" method="post">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Dodawanie nowego użytkownika</div>
                    <div class="panel-body">
                    <div><label for="userlogin">Login: <input type="text" class="form-control" name="userlogin"
                                                              id="userlogin" placeholder="Podaj login" required></label>
                    <label for="userpassword">Hasło: <input type="password" class="form-control" name="userpassword"
                                                            id="userpassword" placeholder="Podaj hasło" required></label>
                    <label for="useremail">Adres email: <input type="email" class="form-control" name="useremail"
                                                               id="useremail" placeholder="Podaj adres email"required></label>
                    </div>
                    <div>
                        <?php foreach ($roles as $role): ?>
                        <label><hn title="Rola jaką ma posiadać dodawany użytkownik"><input type="radio" name="role"
                            id="<?php htmlout($role['id']); ?>" value="<?php htmlout($role['id']); ?>" required><?php htmlout($role['id']); ?></hn></label>
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
                                    <tr><input type="hidden" name="login" value="<?php echo ($user['login']); ?>"><td><?php htmlout($user['login']); ?></td><td><?php htmlout($user['email']); ?></td><td><?php htmlout($user['roleid']); ?></td><td>
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
                        <input type="hidden" name="userid" value="<?php echo $menageuserid; ?>">
                        <label for="newuserlogin">Login<input class="form-control"type="text" name="newuserlogin" id="newuserlogin" value="<?php echo $menageuserlogin; ?>"required></label>
                        <label for="newuseremail">Email<input class="form-control"type="text" name="newuseremail" id="newuseremail" value="<?php echo $menageuseremail; ?>"required></label>
                         <?php foreach ($roles as $role): ?>
                        <label><hn title="Rola"><input type="radio" name="newroleid"
                            id="<?php htmlout($role['id']); ?>" value="<?php htmlout($role['id']); ?>" required <?php if($menageuserrole == $role['id']) echo 'checked'; ?>><?php htmlout($role['id']); ?></hn></label>
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
                <form action="" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Funkcje</div>
                    <div class="panel-body text-center">
                        <button class="btn btn-default" name="action" value="editpass">Zmiana hasła</button>
                        <button class="btn btn-default" name="action" value="showlog">Logi administratora</button>
                    </div>
                </div>
                </form>
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
