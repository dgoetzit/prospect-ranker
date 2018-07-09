<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content=" " />
    <meta name="author" content=" " />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <!-- Use maximum-scale and user-scalable at your own risk. It disables pinch/zoom. Think about usability/accessibility before including.-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="/css/app.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.typekit.net/vdf8zgz.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />

    <link rel="stylesheet" href="animate.min.css">

    <!-- temp -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>

<div class="container-fluid intro-section">
  <div class="row">
    <div class="col-lg-12">
      <h1>Prospect Ranking System</h1>
      <p> Players are ranked and sorted by a value called "Season Score", which is computed from simple player data and is meant to be a predictor of future success.</p>
      <p> Players are only shown on the ranking if they have more than 100 at-bats</p>  

      <p class="green"> Players highlighted in green are players that can potentially be impact MLB players </p>
      <p class="yellow"> Players highlighted in yellow are players that can potentially be solid contributor type players in MLB </p>
      <p class="orange"> Players highlighted in orange are players that are considered borderline, but are not expected to be impact or contributor type players </p>
      <p class="red"> Players highlighted in red are players that are not expected to be contributors on an MLB roster </p>
    </div>
  </div>
</div>
    

    <div class="container-fluid player-section">
      <div class="row" >
        <?php $i=0 ?>
        @foreach ($players as $player)
        <?php $i++; ?>
        <div class="col-lg-12 player-row">
          <p>Rank: <?php echo $i; ?></p>{{ $player->name }} @ {{ $player->level }}: <h1 class="season-score">{{ $player->seasonScore }}</h1>
        </div>
        
        @endforeach
      </div>
    </div>

    <div class="container-fluid intro-section">
  <div class="row">
    <div class="col-lg-12">
      <h1>Disclaimer</h1>
      <p> This algorithm is by no means perfect, and some players that are ranked highly may flounder, as well as those ranked low, may flourish. The Season Score algorithm is meant to help determine a player's future success based on a statistical analysis of their minor league performance, but is by no means an absolute measure. Predicting the future is always hard, but hopefully, with more data and feedback, the Season Score can be a fairly accurate predictor of future big leaguer's success. </p>
      <p> This web application was created by Derek Goetz, and you can visit his personal website to get in touch here. </p>
    </div>
  </div>
</div>


    <script>

    $(document).ready(function() {
      $('.player-row').each(function(index, element) {
          if ($(element).find(".season-score").text() >= .9) {
              $(element).addClass('green');
          } else if ($(element).find(".season-score").text() >= .6) {
              $(element).addClass('yellow');
          } else if ($(element).find(".season-score").text() >= .01) {
              $(element).addClass('orange');
          } else if ($(element).find(".season-score").text() <= 0) {
              $(element).addClass('red');
          }
      });
    });

  </script>
    
  </body>
</html>

