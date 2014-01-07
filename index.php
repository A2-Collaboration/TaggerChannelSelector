<html>
<head>
	<title>Tagger Channel Selector</title>
	<style type="text/css">
.notset { color: blue; }
.ok { color: green; }
.error { color: red; }
.share { color: green; font-style: italic;}
div.info { font-size: small; position: absolute; top: 0px; right: 0px;}
	</style>
</head>
<body>
<h1>A2 Tagger Channel Selector</h1>
<div class="info">V0.1, Oliver Steffen <<a href="mailto:steffen@kph.uni-mainz.de">steffen@kph.uni-mainz.de</a>></div>
<?php
error_reporting(E_STRICT);

$phpURL = $_SERVER['PHP_SELF'];

$MYSQL_HOST="localhost";
$MYSQL_USER="tagchsel";
$MYSQL_PASS="UedxCsbQWCLLYz3E";
$MYSQL_DB="tagchsel";

$con = mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASS);
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($MYSQL_DB, $con) || die (mysql_error());


//Delete row in table inputpattern
if (!empty($_GET['DeleteID']) ) {
	mysql_query("DELETE FROM `config` WHERE `id`='".$_GET['DeleteID']."'");
	header("Location: ".$phpURL);
}

//Insert row in table inputpattern
if (!empty($_GET['InsertButton']) ) {
	mysql_query("INSERT INTO `config` (`output`, `input`) VALUES (".$_GET['OutputCh'].", ".$_GET['SelectedCh'].")") || die (mysql_error());
	header("Location: ".$phpURL."?LastOutputCh=".$_GET['OutputCh']);
}

//Insert row in table inputpattern
if (!empty($_GET['ClearButton']) ) {
	mysql_query("TRUNCATE config;") || die (mysql_error());
	header("Location: ".$phpURL);
}

?>

<table>
<tr>
<th>Output</th>
<th>Inputs</th>
</tr>
<?php
function getClass( $status ) {
	switch ($status) {
	case 0:
		return "notset";
		break;
	case 1:
		return "ok";
		break;
	case 2:
		return "error";
		break;
	case 3:
		return "share";
		break;
	default:
		return $status;
		break;
	}
}

$result = mysql_query("SELECT distinct output FROM config ORDER BY output;");

$ActualOutputCh = -1;
while($row = mysql_fetch_array($result)) {
	$output = $row['output'];
	echo "<tr><td>$output</td><td>";
	$r2 = mysql_query("select config.id,config.input,channel.name,config.status from config JOIN channel ON config.input=channel.input WHERE config.output=$output ORDER BY config.input;");

	while($row2 = mysql_fetch_array($r2)) {
		echo "<a class=\"".getClass($row2['status'])."\" href=\"".$phpURL."?DeleteID=".$row2['id']."\">".$row2['name']."</a> ";
	}
	echo "</td></tr>";
}
?>

</table>
<p>Click on number to delete.</p>
<p>
	<div>Legend:</div>
	<div class="ok">OK, Input is connected</div>
	<div class="share">OK, but a bit pattern is shared with another output</div>
	<div class="error">ERROR, Input can not be connected, corresponding pattern is already in use</div>
</p>
<p>&nbsp;</p>

<p>&nbsp;</p>
<p><b>Add Output</b></p>
<form method="get">
<select name="OutputCh">
<?php
for ($i=0; $i<33; $i++) {
	echo "<option value=\"".$i."\" ";
	if ($_GET['LastOutputCh'] == $i) {
		echo " selected ";
	}

	if ($i == 32) {
		echo ">NIM Out client card</option>";
	}else {
		echo ">Output Ch ".$i."</option>";
	}
}
?>
</select>
<select name="SelectedCh">
<?php
$result2 = mysql_query("SELECT input, name FROM channel ORDER BY LENGTH(name), name;");
while($row2 = mysql_fetch_array($result2)) {
	echo "<option value=\"".$row2['input']."\">";
	echo $row2['name'];
	echo "</option>\n";
}
?>
</select>
<input name="InsertButton" type="submit" value="Insert">
</form>

<form method="get">
<input name="ClearButton" type="submit" value="Clear">
<input name="WriteButton" type="submit" value="Write to VUPROMs">
</form>

<form method="get">
Set Mode of NIM-Out:
<input name="SetDAQMode" type="submit" value="DAQ Mode">
<input name="SetNIMOutMode" type="submit" value="NIM-Out Mode">
</form>


Generating patterns<hr><pre>
<?php
// output patterns
$modules=4;
$patterns=2;
$instances=8;

for($modul=0;$modul<$modules;++$modul)
	for($pattern=0;$pattern<$patterns;++$pattern) {

		// Initialize per output whishlist for input patterns
		for($o=0;$o<32;++$o)
			$whishlist[$o][$modul][$pattern]=0;

		// Initialize final bit patterns
		for($instance=0;$instance<$instances;++$instance)
			$Bits[$modul][$pattern][$instance]=0;
	}

// Initialize final per output pattern selectors (wich modul/pattern to use)
for($instance=0;$instance<$instances;++$instance) {
	for($instout=0;$instout<4;++$instout)
		$Bits2[$instance][$instout]=0;
}

$result = mysql_query("SELECT modul,pattern,bit,output FROM channel JOIN config ON channel.input=config.input;");
while($row = mysql_fetch_array($result)) {
	$m = $row['modul'];
	$p = $row['pattern'];
	$b = $row['bit'];
	$o = $row['output'];

	$whishlist[$o][$m][$p] |= ( 1 << $b );	// set bit in whishlist
}


for($instance=0;$instance<$instances;++$instance) {
	echo "\nInstance $instance\n";
	$outputs = array( $instance, $instance +8, $instance +16, $instance +24);

	for($modul=0;$modul<$modules;++$modul)
		for($pattern=0;$pattern<$patterns;++$pattern)
			$PatUse[$modul][$pattern]=-1;

	echo "Outputs:\n";
	print_r($outputs);
	$zbits = 0;
	//---
	for($instout=0;$instout<4;++$instout) {
		$o = $outputs[$instout];

		for($modul=0;$modul<$modules;++$modul)
			for($pattern=0;$pattern<$patterns;++$pattern) {
				if( $whishlist[$o][$modul][$pattern] != 0 ) {
				echo "Output $o: (Modul $modul, Pattern $pattern) ";
					if ($PatUse[$modul][$pattern] == -1 ) {
						echo "is not in use. Grabbing for us\n";
						// clain the pattern for this output
						$PatUse[$modul][$pattern] = $instout;
						$Bits2[$instance][$instout] |= ( 1 << ($modul*2 + $pattern));
						$Bits[$modul][$pattern][$instance] = $whishlist[$o][$modul][$pattern];
						mysql_query("UPDATE config JOIN channel ON channel.input=config.input SET config.status = 1 WHERE (modul=$modul AND pattern=$pattern AND output=$o);") || die (mysql_error());
					} else {
						echo "is in use by InstOut ".$PatUse[$modul][$pattern]."\n";
						// pattern already in use
						// see if we have the same pattern. then we can use it too
						if( $whishlist[$o][$modul][$pattern] == $Bits[$modul][$pattern][$instance] ) {
							echo "  We have the same pattern though. Using it too!\n";
							$Bits2[$instance][$instout] |= ( 1 << ($modul*2 + $pattern));
							mysql_query("UPDATE config JOIN channel ON channel.input=config.input SET config.status = 3 WHERE (modul=$modul AND pattern=$pattern AND output=$o);") || die(mysql_error());
						} else {
							// Can't use it too. Mark inputs as invalid
							echo "  ...and we have a different pattern :(\n";
							mysql_query("UPDATE config JOIN channel ON channel.input=config.input SET config.status = 2 WHERE (modul=$modul AND pattern=$pattern AND output=$o);") || die(mysql_error());
						}
					}

				}
			}
	}

}

// Write to VUPROMs of pressed
if (!empty($_GET['WriteButton']) ) {
	program();
}

if (!empty($_GET['SetDAQMode']) ) {
	echo "Setting NIM-Out to DAQ Mode\n";
	writeReg( 0x11002210, 0 );
} else if(!empty($_GET['SetNIMOutMode']) ) {
	echo "Setting NIM-Out to NIM-Out Mode\n";
	writeReg( 0x11002210, 1 );
}

//---
echo "</pre><hr>";
$instance=0;

echo "<table><tr><th>Inst</th><th>InstOutp</th><th>Pattern</th><th>Output</th></tr>";
for($instance=0;$instance<$instances;++$instance)
	for($output=0;$output<4;++$output)
		printf('<tr><td>%d</td><td>%d</td><td>%08b</td><td>%d</td></tr>',$instance,$output,$Bits2[$instance][$output],$instance+$output*8);
echo "</table>";

echo "<table><tr><th>Mod</th><th>Pat</th><th>Inst</th><th>Pattern</th></tr>";
for($modul=0;$modul<4;++$modul)
	for($pattern=0;$pattern<2;++$pattern)
		for($instance=0;$instance<$instances;++$instance)
			printf('<tr><td>%d</td><td>%d</td><td>%d</td><td>%064b</td></tr>',$modul,$pattern,$instance,$Bits[$modul][$pattern][$instance]);

echo "</table>";
?>
</body>
</html>

<?php

// ======= Remote VME Access stuff ========

function writeReg( $addr, $val, $verify=true ) {
	$URL = sprintf("http://vme-beampolmon.online.a2.kph:8888/vmeext.pl?%08x=%08x",$addr, $val);
	file_get_contents($URL);
	
	if( $verify )
		$status = ($val == readReg( $addr )) ? "OK" : "FAILED";
	else
		$status = "";

	printf("Writing to 0x%08x, data: 0b%032b: %s\n", $addr, $val, $status);
}

function readReg( $addr ) {
	$URL = sprintf("http://vme-beampolmon.online.a2.kph:8888/vmeext.pl?%08x",$addr);
	$val=0xffffffff;
	$content = file_get_contents($URL);
	$r = sscanf($content, "%08x", $val);
	if( $r != 1 )
		die( sprintf("Error reading VME Address 0x%80x.", $addr));
	return $val;

}

function program() {
	write_input_patterns();
	write_moeller_patterns();
}

// ======= Tagger VUPROMs ========

/**
 * @param module Module number (0..3)
 * @param pattern Pattern number (0,1). Which 64bit pattern
 * @param instance
 * @param half 0=lower 32 bit, 1=higher 32 bit
 */
function calc_address_1( $module, $pattern, $instance, $half ) {
	$output = $pattern * 8 + $instance;
	return ($module+1) * 0x01000000  + 4 * $half + (1<<11)+ 0x2000 + ($output << 4);
}

function write_input_patterns() {
	echo "<pre name=\"prog\">";
	echo "Programming input patterns to VUPROMS...\n";
	printf("Firmware VUPROM 1: 0x%08x\n",readReg( 0x01002f00 ));
	printf("Firmware VUPROM 2: 0x%08x\n",readReg( 0x02002f00 ));
	printf("Firmware VUPROM 3: 0x%08x\n",readReg( 0x03002f00 ));
	printf("Firmware VUPROM 4: 0x%08x\n",readReg( 0x04002f00 ));
	global $modules, $instances;
	global $Bits;


	for($modul=0; $modul<$modules; ++$modul) {
		for($pattern=0; $pattern<2; ++$pattern) {
			for($instance=0; $instance<$instances; ++$instance) {

				$data = $Bits[$modul][$pattern][$instance] & 0x00000000ffffffff;
				$addr = calc_address_1( $modul, $pattern, $instance, 0);
				writeReg( $addr, $data );

				$data = $Bits[$modul][$pattern][$instance] & 0xffffffff00000000;
				$data >>= 32;
				$addr = calc_address_1( $modul, $pattern, $instance, 1);
				writeReg( $addr, $data );
			}

		}
	}
	echo "</pre>";
}

// ======= Moeller ========

function calc_address_2 ( $instance ) {
	return 0x11002100 + $instance * 0x10;
}

function write_moeller_patterns() {
	global $instances;
	global $Bits2;

	echo "<pre name=\"prog_moeller\">";
	echo "Programming output ORs to VUPROM (Moeller)...\n";
	printf("Firmware VUPROM x11: 0x%08x\n",readReg( 0x11002f00 ));

	for($instance=0; $instance<$instances; ++$instance) {
		$data =  ($Bits2[$instance][3] << (3*8))
			   + ($Bits2[$instance][2] << (2*8))
			   + ($Bits2[$instance][1] << (1*8))
			   + ($Bits2[$instance][0]);
		$addr = calc_address_2( $instance );
		writeReg( $addr, $data );

	}

	echo "</pre>";
}



