<?php

require 'config.php';

$tokyo = new TokyoTyrant("localhost");

foreach ($STEPS as $count) {
	// Set
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $tokyo->put("key$i", TEXT_256);
		if (!$value) {
			die('SET error!');
		}
	}
	$elapsedSetTime = microtime(true) - $startTime;
	// Get
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $tokyo->get("key$i");
		if ($value != TEXT_256) {
			die('GET error!');
		}
	}
	$elapsedGetTime = microtime(true) - $startTime;
	
	print sprintf('Tokyo Tyrant (%d): SET - %.4f, GET - %.4f', $count, $elapsedSetTime, $elapsedGetTime)  . "\n";

	$tokyo->vanish();
}