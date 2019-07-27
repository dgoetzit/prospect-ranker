<a href="{{ route('major-league-teams.index') }}" class="btn btn-default">Back</a>

<div class="container team-container">
	<div class="row team-row">
		<div class="col-12">
			<h1>{{ $majorLeagueTeam->name }}</h1>
		</div>
	</div>
</div>

<div class="container team-container">
	<div class="row team-row">
		<div class="col-12">
			@foreach($years as $year) 
				<a href="{{ route('major-league-teams.year', [$majorLeagueTeam->id, $year->year]) }}"><h1>{{ $year->year }}</h1></a>
				@foreach($majorLeagueTeam->minorLeagueTeams as $minorLeagueTeam)
					@if($minorLeagueTeam->pivot->year_id == $year->id)
						<a href="{{ route('minor-league-teams.show', [$minorLeagueTeam->id, $year->year]) }}"><p>{{ $minorLeagueTeam->name }}</p></a>
					@endif
				@endforeach
			@endforeach
		</div>
	</div>
</div>


