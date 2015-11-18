<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php if(isset($success)): ?><meta http-equiv="Refresh" content="3; url=/voteonline/voteadmin/" /> <?php     endif;?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline VoteAdmin</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" href="/voteonline/css/bootstrap.css">
    <link rel="stylesheet" href="/voteonline/css/bootstrap-theme.css">
    <style>body{padding-top:50px;}.starter-template{padding:40px 15px;text-align:center;}.logo { max-width: 35%;} .wykres {min-width: 200px;} .navlogo {width: 100px; height: 50px; }</style>

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
        <!--<img src="/voteonline/VO_1.png" class="img-responsive center-block"> -->
        <div class="row">
        <form action="" method="post">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 hidden-xs">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Tworznie nowego głosowania</div>
                    <div class="panel-body">
                        <label for="votingname">Nazwa<input type="text" class="form-control" name="votingname" id="votingname" placeholder="Podaj nazwę głosowania" required></label>
                        <label for="votingdesc">Opis<input type="text" class="form-control" name="votingdesc" id="votingdesc" placeholder="Podaj opis głosowania" required></label>
                        <input type="submit" class="btn btn-default" name="voting" value="Dodaj">
                    </div>
                </div>
            </div>
        </form>
        <form action="" method="post">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Aktywacja głosowania</div>
                    <div class="panel-body">
                        <p>Obecnie aktywnej jest głosowanie: <?php if(isset($votingname)) {echo $votingname;} else {echo 'Nie zostało aktywowane żadne głosowanie';} ?> </p>
                        <label for="votingactiv">Uaktywnij:
                        <select name="votingactiv" class="form-control">
                            <?php foreach ($votings as $voting): ?>
                            <option value="<?php echo $voting['id'];?>" <?php if($voting['active']>0) {echo 'selected'; $active = $voting['name'];} ?>><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                        </select></label>
                        <input type="submit" class="btn btn-default" value="Uaktywnij">
                    </div>
                </div>    
            </div></form>
        </div>
        <div class="row hidden-xs">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden-xs">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Zarządzanie głosowaniem</div>
                <div class="panel-body">
                    <form action="" method="get">
                    <label for="votmenselect">Wybór głosowania
                        <select name="votmenselect" class="form-control">
                            <?php foreach ($votings as $voting): ?>
                            <option value="<?php echo $voting['id'];?>"<?php if(isset($_GET['votmenselect']) and $_GET['votmenselect'] == $voting['id']) echo 'selected'; ?>><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </label>
                        <input type="submit" name="menage" value="Zarządzaj danymi głosowania" class="btn btn-default">
                        <input type="submit" name="menage" value="Zarządzaj wariantami głosowania" class="btn btn-default">
                        <input type="submit" name="menage" value="Usuń głosowanie" class="btn btn-danger" title="Usuwając głosowanie usuwasz również warianty oraz głosy z nim powiązane">
                    </form>
                    <?php if(isset($menagevariants)): ?>
                     <table class="table table-bordered table-responsive text-center">
                     <tr class="info"><td><b>Nazwa wariantu</b></td><td><strong></tr>
                     <?php foreach ($menagevariants as $menagevariant): ?>
                    <form action="" method="post">
                     <tr><input type="hidden" name="variantid" value="<?php echo ($menagevariant['id']); ?>"><td><?php echo ($menagevariant['name']); ?></td><td><input type="submit" name="action" value="Edytuj"><input type="submit" name="action" value="Usuń"></td></tr></form>
                    <?php endforeach;?></table><?php endif;?>
                    <?php if(isset($menagevotingid)): ?>
                    <form action="" method="post">
                        <input type="hidden" name="votingid" value="<?php echo $menagevotingid; ?>">
                        <label for="newvotingname">Nazwa<input class="form-control"type="text" name="newvotingname" id="newvotingname" value="<?php echo $menagevotingname; ?>"required></label>
                        <label for="newvotingdesc">Opis<input class="form-control"type="text" name="newvotingdesc" id="newvotingdesc" value="<?php echo $menagevotingdesc; ?>"required></label>
                        <input type="submit" name="menage" value="Zapisz" class="btn btn-default">
                    </form>
                    <?php                    endif;?>
                </div>
            </div>
            </div>
        </div>
        <div class="row hidden-xs">
          <form action="" method="post">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Tworznie wariantu głosowania</div>
                    <div class="panel-body">
                        <label for="newvariant">Nazwa<input type="text" class="form-control" name="newvariant"
                                                            id="newvariant" placeholder="Podaj nazwę wariantu" required></label>
                        <label for="votingselect">Dodaj do:
                        <select name="votingselect" class="form-control">
                            <?php foreach ($votings as $voting): ?>
                            <option value="<?php echo $voting['id'];?>"><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </label>
                        <input type="submit" class="btn btn-default" value="Dodaj">
                    </div>
                </div>
            </div>
        </form>  
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Wyniki głosowania</div>
                    <div class="panel-body">
                        <?php if(isset($warianty)){$i=0; foreach($warianty as $variant):?>
                        <p><?php if($voteCount[0]>0){ echo $variant['name']; echo ': ' . $voteResults[$i] . ' (' . round((($voteResults[$i]/$voteCount[0])*100),2) . '%)'; $i++;}
                                 else {echo $variant['name']; echo ': ' . $voteResults[$i] . ' (0%)'; $i++;}?></p>
                        <?php endforeach; } else echo 'Do głosowania nie został jeszcze dodany żaden wariant'; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Statystyki głosowania</div>
                    <div class="panel-body">
                        <p>Ilość oddanych głosów: <?php echo $voteCount[0]; ?></p>
                        <p>Ilość wariantów odpowiedzi: <?php if(isset($warianty)) echo count($warianty); else echo '0';?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row hidden-xs">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                <div class="panel-heading text-center">Wykres przedstawiający wyniki głosowania</div>
                <div class="panel-body">    
                    <div id="piechart_3d"></div>
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
