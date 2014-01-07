#!/usr/bin/php
<?php


$MYSQL_HOST="localhost";
$MYSQL_USER="a2service";
$MYSQL_PASS="a2";
$MYSQL_DB="tagchsel";

$con = mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASS);
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($MYSQL_DB, $con) || die (mysql_error());

$setup = array ( "IJOPCD", "GHQRKL", "EFSTMN", "ABUV" );
mysql_query("TRUNCATE channel;");
$input=0;

$query = "INSERT INTO channel (input,modul,pattern,bit,name,zbit) VALUES ";
foreach ($setup as $m => $conf) {
	$bit=0;
	$p=0;
	for($i=0;$i<strlen($conf);$i++)
	{
		$base = ord($conf[$i])-65;
		for($c=0;$c<16;++$c) {
			$ch = $base*16+$c;
			echo "Module $m, Char=$conf[$i], Base=$base, Subch=$c, Ch=$ch, Bit=$bit, Pattern=$p\n";
			$query .= "($input,$m,$p,$bit,\"Tagger Ch $ch\",0),";
			++$bit;
			++$input;
			if($bit==64) {
				$bit = 0;
				$p++;
			}
		}
	} 
}
$query[strlen($query)-1] = ";";

mysql_query($query) || die(mysql_error());

?>
