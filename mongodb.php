<?php

require 'config.php';

$mongo = new Mongo();

foreach ($STEPS as $count) {
	// Set
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$value = $mongo->test->test->insert(array('_id' => $i, 'field' => TEXT_256));
		if (!$value) {
			die('SET error!');
		}
	}
	$elapsedSetTime = microtime(true) - $startTime;
	// Get
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$cursor = $mongo->test->test->find(array('_id' => $i));
		$value = $cursor->getNext();

		if (!$value || $value['field'] != TEXT_256) {
			die('GET error!');
		}
	}
	$elapsedGetTime = microtime(true) - $startTime;

	print sprintf('Mongo (%d): SET - %.4f, GET - %.4f', $count, $elapsedSetTime, $elapsedGetTime)  . "\n";

	$mongo->test->drop();
}