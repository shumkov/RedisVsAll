<?php

require 'config.php';

$mysql = new PDO('mysql:host=localhost;dbname=test', 'test', 'test');
$s = $mysql->prepare('CREATE TABLE IF NOT EXISTS `test` (`id` int(11) NOT NULL, `field` text NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDb');
$s->execute();

foreach ($STEPS as $count) {
	// Set
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$s = $mysql->prepare("INSERT INTO test SET `id` = $i, `field` = '" . TEXT_256 . "'");
		$s->execute();
	}
	$elapsedSetTime = microtime(true) - $startTime;
	// Get
	$startTime = microtime(true);
	for ($i = 1; $i <= $count - 1; $i++) {
		$s = $mysql->prepare("SELECT field FROM test WHERE `id` = $i");
		$s->execute();
		$value = $s->fetch();

		if ($value['field'] != TEXT_256) {
			die('GET error!');
		}
	}
	$elapsedGetTime = microtime(true) - $startTime;

	print sprintf('Mysql (%d): SET - %.4f, GET - %.4f', $count, $elapsedSetTime, $elapsedGetTime)  . "\n";

	$s = $mysql->prepare("TRUNCATE TABLE test");
	$s->execute();
}