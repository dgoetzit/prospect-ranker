<div class="container team-container">
	<div class="row team-row">
		<div class="col-12">
			@foreach($majorLeagueTeams as $team)

				<a href="{{ route('major-league-teams.show', $team->abbreviation, false) }}"><h1 class="team-name" style="font-size: 14px;">{{ $team->name }}</h1></a>

			@endforeach
		</div>
	</div>
</div>

