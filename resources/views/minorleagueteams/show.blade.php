<!DOCTYPE html>
<html>
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-86644623-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-86644623-2');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prospect Rank</title>
    <meta name="description" content="Chicago Cubs prospect rankings" />
    <meta name="author" content="Derek Goetz" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <!-- Use maximum-scale and user-scalable at your own risk. It disables pinch/zoom. Think about usability/accessibility before including.-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="/css/app.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.typekit.net/wll4evl.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />

    <link rel="stylesheet" href="animate.min.css">

    <!-- temp -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>

<a href="{{ url()->previous() }}" class="btn btn-default">Back</a>

<div class="container team-container">
	<div class="row team-row">
		<div class="col-12">
			<h1>{{ $minorLeagueTeam->name }}</h1>
		</div>
	</div>
</div>


@if($minorLeagueTeam->players())
<div class="container-fluid player-section">
  <div class="row" >
    <h1>Players</h1>
    <?php $i=0 ?>
    @foreach ($players as $player)
    <?php $i++; ?>
    <div class="col-lg-12 player-row">
      <p class="player-rank">Rank: <?php echo $i; ?> </p><p class="player-headline">{{ $player->name }} @ {{ $minorLeagueTeam->name }}:</p><h1 class="season-score">{{ $player->seasonScore }}</h1>
    </div>
    
    @endforeach
  </div>
</div>
@endif

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