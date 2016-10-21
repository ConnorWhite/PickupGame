<?php

$cd_stock = ("CdCount.txt");

function updateStock($num)
{
 	global $cd_stock;
	$count = file($cd_stock);
	$count = (int)$count[0];
	$count = $count - $num;
	if ($count < 0) $count = 0;
	$fp = fopen($cd_stock , "w");
	fputs($fp , "$count");
	fclose($fp);

	echo $count;
}

function getCdCount()
{
	srand();
	$newOrder  = rand(1, 3);
	$sleeptime = rand(2, 10);
	sleep($sleeptime);

	updateStock($newOrder);
}

$num = $_GET['num'];
if ( $num == "")
{
 	getCdCount();
}
else
{
 	updateStock((int)$num);
}
?>