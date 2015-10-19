<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; 
?>
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
                <a class="navbar-brand">VoteOnline</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="admin/">Panel Administratora</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="" data-toggle="modal" data-target="#myModal"><?php htmlout($loginstate) ?></a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
    </nav>
    <div class="container">
        <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <form action="" method="post">
          <h2>Twój ulubiony serial to:</h2>
        <?php foreach ($variants as $variant): ?>
          <div><label><input type="radio" name="variants[]"
              id="variant<?php htmlout($variant['id']); ?>"
              value="<?php htmlout($variant['id']); ?>" required><?php htmlout($variant['name']); ?></label></div>
        <?php endforeach; ?>
        <div>
        <input type="submit" class="btn btn-default" value="Głosuj">
      </div>
          </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <h2>Zarezerwowane na dane głosującego</h2>
        <div class="form-group">
            <label for="sel1">Płeć:</label>
            <select class="form-control" id="sex" required>
                <option>K</option>
                <option>M</option>
            </select>
        </div>
    </div>
        </div>
    </div></form>
    
 <!-- Wyskakujące okno logowania -->
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <?php if ($loginstate == 'Zaloguj'): include 'login.inc.html.php'; ?>
    <?php elseif($loginstate == 'Wyloguj'): include 'logout.inc.html.php'; endif ?>  
  </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
