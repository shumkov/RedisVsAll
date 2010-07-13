<?php

require 'config.php';

require_once 'Rediska/library/Rediska.php';

$rediska = new Rediska();

foreach ($STEPS as $count) {
	// Set
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $rediska->set("key$i", TEXT_256);
		if (!$value) {
			die('SET error!');
		}
	}
	$elapsedSetTime = microtime(true) - $startTime;
	// Get
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $rediska->get("key$i");
		if ($value != TEXT_256) {
			die('GET error!');
		}
	}
	$elapsedGetTime = microtime(true) - $startTime;

	print sprintf('Rediska (%d): SET - %.4f, GET - %.4f', $count, $elapsedSetTime, $elapsedGetTime)  . "\n";

	$rediska->flushDb();
}