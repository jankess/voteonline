<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline Admin</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style>body{padding-top:50px;}.starter-template{padding:40px 15px;text-align:center;}.img-responsive { max-width: 35%;}</style>

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
                    <li class="active"><a href="/voteonline/voteadmin/">Panel Administratora Głosowania</a></li>
                    <li class="active"><a href="/voteonline/admin/">Panel Administratora</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="" data-toggle="modal" data-target="#myModal"><?php htmlout($loginstate) ?></a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>
    <div class="container">
        <img src="/voteonline/VO_1.png" class="img-responsive center-block">
        <div class="row">
        <form action="?adduser" method="post">
            <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <div><p><b>Dodawanie nowego użytkownika</b></p>
        <label for="userlogin">Login: <input type="text" class="form-control" name="userlogin"
            id="userlogin" required></label>
          <label for="userpassword">Hasło: <input type="password" class="form-control" name="userpassword"
                                                  id="userpassword" required></label>
          <label for="useremail">Adres email: <input type="email" class="form-control" name="useremail"
                                                  id="useremail" required></label>
          </div>
          <div>
              <?php foreach ($roles as $role): ?>
              <label><input type="radio" name="role"
              id="<?php htmlout($role['id']); ?>"
              value="<?php htmlout($role['id']); ?>" required><?php htmlout($role['id']); ?></label>
               <?php endforeach; ?>
        </div>
          <input type="submit" class="btn btn-default" value="Dodaj"></form>
      </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <p>Użytkownicy Voteonline:</p>
         <table class="table table-bordered table-responsive text-center">
         <tr class="info"><td>Login</td><td>Adres email</td></tr>
        <?php foreach ($users as $user): ?>
             <tr><td><?php htmlout($user['login']); ?></td><td><?php htmlout($user['email']); ?></td></tr>
      <?php endforeach; ?>
        </table>
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
