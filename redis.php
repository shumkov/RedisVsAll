<?php

require 'config.php';

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

foreach ($STEPS as $count) {
	// Set
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $redis->set("key$i", TEXT_256);
		if (!$value) {
			die('SET error!');
		}
	}
	$elapsedSetTime = microtime(true) - $startTime;
	// Get
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $redis->get("key$i");
		if ($value != TEXT_256) {
			die('GET error!');
		}
	}
	$elapsedGetTime = microtime(true) - $startTime;

	print sprintf('Redis (%d): SET - %.4f, GET - %.4f', $count, $elapsedSetTime, $elapsedGetTime)  . "\n";

	$redis->flushDB();
}