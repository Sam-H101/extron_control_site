<?php 
	// CRONTAB DAILY FILE
	// RUN AT MIDNIGHT EVERY NIGHT
	
	require_once "../includes/charts.php";
	require_once "../includes/commands.php";
	resetAllRecLogs();
	setDailyCounts();
	
?>