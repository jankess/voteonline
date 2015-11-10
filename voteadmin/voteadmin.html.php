<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/include/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VoteOnline VoteAdmin</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
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
        <!--<img src="/voteonline/VO_1.png" class="img-responsive center-block"> -->
        <div class="row">
        <form action="" method="get">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Dodawanie nowego głosowania</div>
                    <div class="panel-body">
                        <label for="votingname">Nazwa głosowania<input type="text" class="form-control" name="votingname" id="votingname" required></label>
                        <label for="votingdesc">Pytanie dotyczące głosowania<input type="text" class="form-control" name="votingdesc" id="votingdesc" required></label>
                        <input type="submit" class="btn btn-default" name="voting" value="Dodaj">
                    </div>
                </div>
            </div>
        </form>
        <form action="" method="post">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Dodawanie nowego wariantu do głosowania</div>
                    <div class="panel-body">
                        <label for="newvariant">Nazwa wariantu: <input type="text" class="form-control" name="newvariant"
                            id="newvariant"></label>
                        <label for="votingselect">Głosowanie do którego wariant ma zostać dodany
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
        <form action="" method="post">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Wybór aktywnego głosowania</div>
                    <div class="panel-body">
                        <label for="votingactiv">Głosowanie które ma zostać uaktywnione
                        <select name="votingactiv" class="form-control">
                            <?php foreach ($votings as $voting): ?>
                            <option value="<?php echo $voting['id'];?>" <?php if($voting['active']>0) {echo 'selected'; $active = $voting['name'];} ?>><?php echo $voting['name']; ?></option>
                            <?php endforeach; ?>
                        </select></label>
                        <input type="submit" class="btn btn-default" value="Uaktywnij">
                    </div>
                    <p>Obecnie aktywnej jest głosowanie: <?php if(isset($active)) {echo $active;} else {echo 'Nie zostało aktywowane żadne głosowanie';} ?> </p> 
                </div>    
            </div></form>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Szczegółowe dane głosowania</div>
                    <div class="panel-body">
                        <?php if(isset($warianty)){$i=0; foreach($warianty as $variant):?>
                        <p><?php echo $variant['name']; echo ': ' . $voteResults[$i] . ' (' . round((($voteResults[$i]/$voteCount[0])*100),2) . '%)'; $i++;?></p>
                        <?php endforeach; } else echo 'Do głosowania nie został jeszcze dodany żaden wariant'; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Ogólne dane głosowania</div>
                    <div class="panel-body">
                        <p>Ilość oddanych głosów: <?php echo $voteCount[0]; ?></p>
                        <p>Ilość wariantów odpowiedzi: <?php if(isset($warianty)) echo count($warianty); else echo '0';?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default hidden-xs hidden-sm">
                <div class="panel-heading text-center">Wykres przedstawiający wyniki głosowania</div>
                <div class="panel-body">    
                    <div id="piechart_3d"></div>
                </div>  
                </div>  
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
