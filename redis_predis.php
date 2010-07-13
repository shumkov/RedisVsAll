<?php

require 'config.php';

require_once 'Predis/lib/Predis.php';

$predis = new Predis\Client();

foreach ($STEPS as $count) {
	// Set
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $predis->set("key$i", TEXT_256);
		if (!$value) {
			die('SET error!');
		}
	}
	$elapsedSetTime = microtime(true) - $startTime;
	// Get
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $predis->get("key$i");
		if ($value != TEXT_256) {
			die('GET error!');
		}
	}
	$elapsedGetTime = microtime(true) - $startTime;

	print sprintf('Predis (%d): SET - %.4f, GET - %.4f', $count, $elapsedSetTime, $elapsedGetTime)  . "\n";

	$predis->flushdb();
}