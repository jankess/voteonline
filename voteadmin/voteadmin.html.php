<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php if(isset($success)): ?><meta http-equiv="Refresh" content="1; url=/voteonline/voteadmin/" /> <?php     endif;?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline VoteAdmin</title>
    <link rel="shortcut icon" href="../favicon.ico">
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
                     
                    <!--<li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php                              echo $_SESSION['userlogin'];?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li role="separator" class="divider"></li>
            <li><form action="" method="post"><input type="submit" class="list-group-item" name="action" value="Zmiana hasła"></form></li>
          </ul>
        </li>-->
                    <li><a href="" data-toggle="modal" data-target="#myModal"><?php htmlout($loginstate) ?></a></li>
                </ul>
            </div><!--.nav-collapse -->
        </div>
        
    </nav>
    <hr/>
    <div class="container">
        <?php if(isset($success)): ?> <div class="row alert alert-success"><p class="text-center"><?php echo($success) ?></p></div> <?php endif;?>
        <!--<img src="/voteonline/VO_1.png" class="img-responsive center-block"> -->
        <div class="row">
        <form action="" method="post">
            <div class="col-sm-6 col-md-6 col-lg-6 hidden-xs">
                <div class="panel panel-success">
                    <div class="panel-heading text-center"><strong>Tworzenie nowego głosowania</strong></div>
                    <div class="panel-body">
                        <label for="votingname">Nazwa<input type="text" class="form-control" name="votingname" id="votingname" placeholder="Podaj nazwę głosowania" required></label>
                        <label for="votingdesc">Opis<input type="text" class="form-control" name="votingdesc" id="votingdesc" placeholder="Podaj opis głosowania" required></label>
                        <input type="submit" class="btn btn-default" name="voting" value="Dodaj">
                    </div>
                </div>
            </div>
        </form>
        <form action="" method="post">
            <div class="col-sm-6 col-md-6 col-lg-6 hidden-xs">
               <div class="panel panel-success">
                   <div class="panel-heading text-center"><strong>Tworzenie wariantu głosowania</strong></div>
                    <div class="panel-body">
                        <label for="newvariant">Nazwa<input type="text" class="form-control" name="newvariant"
                                                            id="newvariant" placeholder="Podaj nazwę wariantu" required></label>
                        <label for="votingselect">Dodaj do:
                        <select name="votingselect" class="form-control" title="Wybierz głosowanie do którego ma zostać dodany wariant">
                            <?php foreach ($votings as $voting): ?>
                            <option value="<?php echo $voting['id'] . ','.$voting['name'];?>"><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </label>
                        <input type="submit" class="btn btn-default" value="Dodaj">
                    </div>
                </div>  
            </div></form>
        </div>
        <div class="row hidden-xs">
            <div class="col-sm-12 col-md-12 col-lg-12 hidden-xs">
            <div class="panel panel-primary">
                <div class="panel-heading text-center"><strong>Zarządzanie głosowaniem</strong></div>
                <div class="panel-body">
                    <form action="" method="get">
                    <fieldset>
                        <legend class="text-center">Wybór głosowania</legend>
                        <select name="votmenselect" class="form-control">
                            <?php foreach ($votings as $voting): ?>
                            <option value="<?php echo $voting['id']. ',' . $voting['name'];?>"<?php if(isset($_GET['votmenselect'])){$votmendata = explode(",", $_GET['votmenselect']); if($votmendata[0] == $voting['id']) echo 'selected'; }?>><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        <br />
                        <div class="text-center">
                            <input type="submit" name="menage" value="Zarządzaj danymi głosowania" class="btn btn-default" title="Pozwala edytować dane głosowania">
                            <input type="submit" name="menage" value="Zarządzaj wariantami głosowania" class="btn btn-default" title="Pozwala edytować/usuwać warianty">
                        <input type="submit" name="menage" value="Usuń głosowanie" class="btn btn-danger" title="Usuwając głosowanie usuwasz również warianty oraz głosy z nim powiązane">
                        </div>
                        </fieldset>
                        </form>
                    <?php if(isset($menagevariants)): ?>
                    <br />
                    <fieldset>
                        <legend class="text-center">Zarządzanie wariantami</legend>
                     <table class="table table-bordered table-responsive text-center">
                         <tr class="info"><td><strong>Nazwa wariantu</strong></td><td><strong>Akcja</strong></td></tr>
                     <?php foreach ($menagevariants as $menagevariant): ?>
                    <form action="" method="post">
                        <tr><input type="hidden" name="variantid" value="<?php echo ($menagevariant['id']. ',' . $menagevariant['name']); ?>"><td><?php echo ($menagevariant['name']); ?></td><td><input type="submit" class="btn btn-default" name="action" value="Edytuj"><input type="submit" class="btn btn-danger"name="action" value="Usuń" title="Usuwając wariant usuwasz również powiązane z nim głosy"></td></tr></form>
                    <?php endforeach;?></table></fieldset><?php endif;?>
                    <?php if(isset($menagevotingid)): ?>
                    <br />
                    <form action="" method="post">
                        <fieldset>
                            <legend class="text-center">Edycja danych głosowania</legend>
                        <input type="hidden" name="votingid" value="<?php echo $menagevotingid . ',' . $menagevotingname; ?>">
                        <label for="newvotingname">Nazwa<input class="form-control"type="text" name="newvotingname" id="newvotingname" value="<?php echo $menagevotingname; ?>"required></label>
                        <label for="newvotingdesc">Opis<input class="form-control"type="text" name="newvotingdesc" id="newvotingdesc" value="<?php echo $menagevotingdesc; ?>"required></label>
                        <input type="submit" name="menage" value="Zapisz" class="btn btn-default">
                        </fieldset>
                        </form>
                    <?php                    endif;?>
                <?php if(isset($type) and $type=='variant'): ?>
                    <div class="text-center">
                    <form action="" method="post">
                        <input type="hidden" name="variantid" id="variantid" value="<?php echo $menagevariantid .  "," . $menagevariantname; ?>">
                        <label for="menagevariant">Nazwa<input type="text" class="form-control" name="menagevariant" id="menagevariant" value="<?php echo $menagevariantname; ?>" autofocus></label>    
                        <input type="submit" class="btn btn-default" name="actionvar" value="Zapisz">
                    </form>
                    </div>
                    <?php                     endif; ?>
                </div>
            </div>
            </div>
        </div>
        <div class="row ">
          <form action="" method="post">
            <div class="hidden-xs col-sm-6 col-md-6 col-lg-6 ">
             <div class="panel panel-primary">
                 <div class="panel-heading text-center"><strong>Aktywacja głosowania</strong></div>
                    <div class="panel-body">
                        <p>Obecnie aktywnej jest głosowanie: <?php if(isset($votingname)) {echo $votingname;} else {echo 'Nie zostało aktywowane żadne głosowanie';} ?> </p>
                        <label for="votingactiv">Uaktywnij:
                            <select name="votingactiv" class="form-control">
                            <?php foreach ($votings as $voting): ?>
                            <option value="<?php echo $voting['id'] . "," .$voting['name']; ?>" <?php if($voting['active']>0) {echo 'selected'; $active = $voting['name'];} ?>><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                        </select></label>
                        <input type="submit" class="btn btn-default" value="Uaktywnij">
                    </div>
                </div>     
            </div>
        </form>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center"><strong>Statystyki głosowania</strong></div>
                    <div class="panel-body">
                        <p>Ilość oddanych głosów: <?php echo $voteCount[0]; ?></p>
                        <p>Ilość wariantów odpowiedzi: <?php if(isset($warianty)) echo count($warianty); else echo '0';?></p>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">
                        <form action="" method="get">
                            <label for="votingresults">Wyniki głosowania<select name="votingresults" class="form-control">
                            <?php foreach ($votings as $voting): ?>
                                    <option value="<?php echo $voting['id']; ?>" <?php if(isset($_GET['votingresults'])and ($voting['id'] == $_GET['votingresults'])) {echo 'selected';} ?>><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                                </select></label>
                            <input type="submit" class="btn btn-default" name="action" value="Pokaż">
                        </form></div>
                    <div class="panel-body">
                        <?php if(isset($warianty)){$i=0; foreach($warianty as $variant):?>
                        <p><?php if($voteCount[0]>0){ echo $variant['name']; echo ': ' . $voteResults[$i] . ' (' . round((($voteResults[$i]/$voteCount[0])*100),2) . '%)'; $i++;}
                                 else {echo $variant['name']; echo ': ' . $voteResults[$i] . ' (0%)'; $i++;}?></p>
                        <?php endforeach; } else echo 'Do głosowania nie został jeszcze dodany żaden wariant'; ?>
                    </div>
                </div>
            </div>
          <div class="col-sm-8 col-md-6 col-lg-6 hidden-xs">
                <div class="panel panel-info">
                    <div class="panel-heading text-center"><strong>Wykres wyników głosowania</strong></div>
                <div class="panel-body">    
                    <div id="piechart_3d"></div>
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
    </div>
    <!-- Wyskakujące okno logowania -->
    <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
    <!-- Modal content-->
        <?php include '../logout.inc.html.php';?>  
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/voteonline/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1.1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['All Votes', 'Votes'],
        <?php if(isset($warianty)) {$i=0; foreach($warianty as $variant):?>
          ['<?php echo $variant['name']; ?>', <?php echo $voteResults[$i]; $i++;?>],
        <?php endforeach; }?>
        ]);

        var options = {
            is3D: true,
            width:500,
            height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
</body>
</html>
