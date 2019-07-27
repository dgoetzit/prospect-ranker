<?php

// Schema Changes

// Tables

// Major League Teams
	// id
	// name
// Minor League Teams
	// id
	// name
// Major League - Minor League (intermediary)
	// id
	// major_league_id
	// minor_league_id
	// year

// A lot of these models will need to be associated with years, because club levels and associations change year to year, and in order to have a consistently correct system, this would be th eway to build it

// Do Stats belong to Levels or Teams

// A player hasMany stats
// And they are paired with him and a minor league team
// Because the team is paired with a level
