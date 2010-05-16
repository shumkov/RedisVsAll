<?php

require 'config.php';

$memcached = new Memcached();
$memcached->addServer('127.0.0.1', 11211);

foreach ($STEPS as $count) {
	// Set
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $memcached->set("key$i", TEXT_256);
		if (!$value) {
			die('SET error!');
		}
	}
	$elapsedSetTime = microtime(true) - $startTime;
	// Get
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $memcached->get("key$i");
		if ($value != TEXT_256) {
			die('GET error!');
		}
	}
	$elapsedGetTime = microtime(true) - $startTime;
	
	print sprintf('Memcached (%d): SET - %.4f, GET - %.4f', $count, $elapsedSetTime, $elapsedGetTime)  . "\n";

	$memcached->flush();
}