<html>
<head>
	<title>Tagger Channel Selector</title>
	<style type="text/css">
.notset { color: blue; }
.ok { color: green; }
.error { color: red; }
.share { color: green; font-style: italic;}
div.info { font-size: small; position: absolute; top: 0px; right: 0px;}
form { background-color: #f0f0f0; }
	</style>
</head>
<body>
<h1>A2 Tagger Channel Selector</h1>
<div class="info">V0.2, Oliver Steffen <<a href="mailto:steffen@kph.uni-mainz.de">steffen@kph.uni-mainz.de</a>></div>
<?php
error_reporting(E_STRICT);

// Load configuration
require_once("conf.inc.php");

$phpURL = $_SERVER['PHP_SELF'];

$con = mysql_connect($MYSQL_HOST, $MYSQL_USER, $MYSQL_PASS);
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($MYSQL_DB, $con) || die (mysql_error());


$Set=$_GET['Set'];

set_selection_box();
new_set_box();


$result=mysql_query("SELECT name FROM setname WHERE id=\"$Set\";");

if( !( $row = mysql_fetch_array($result) )) {
	echo "</body></html>";
	die();
}

$SetName = $row['name'];

echo "<h2>Set: $SetName</h2>";

//Delete row in table inputpattern
if (!empty($_GET['DeleteID']) ) {
	mysql_query("DELETE FROM `config` WHERE `id`='".$_GET['DeleteID']." AND set=\"$Set\"'");
	header("Location: ".$phpURL."?Set=$Set");
}

//Insert row in table inputpattern
if (!empty($_GET['InsertButton']) ) {
	mysql_query("INSERT INTO `config` (`output`, `input`, `set`) VALUES (".$_GET['OutputCh'].", ".$_GET['SelectedCh'].", $Set);") || die (mysql_error());
	header("Location: ".$phpURL."?Set=$Set&LastOutputCh=".$_GET['OutputCh']);
}

//Insert row in table inputpattern
if (!empty($_GET['ClearButton']) ) {
	mysql_query("DELETE FROM config WHERE `set`=\"$Set\";") || die (mysql_error());
	header("Location: ".$phpURL."?Set=$Set");
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

$result = mysql_query("SELECT distinct output FROM config WHERE `set`=\"$Set\" ORDER BY output;");

$ActualOutputCh = -1;
while($row = mysql_fetch_array($result)) {
	$output = $row['output'];
	echo "<tr><td>$output</td><td>";
	$r2 = mysql_query("select config.id,config.input,channel.name,config.status from config JOIN channel ON config.input=channel.input WHERE (config.output=$output AND config.set=\"$Set\") ORDER BY config.input;");

	while($row2 = mysql_fetch_array($r2)) {
		echo "<a class=\"".getClass($row2['status'])."\" href=\"".$phpURL."?Set=$Set&DeleteID=".$row2['id']."\">".$row2['name']."</a> ";
	}
	mysql_free_result($r2);
	echo "</td></tr>";
}
mysql_free_result($result);
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
for ($i=0; $i<32; $i++) {
	echo "<option value=\"".$i."\" ";
	if ($_GET['LastOutputCh'] == $i) {
		echo " selected ";
	}
	echo ">Output Ch ".$i."</option>";
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
mysql_free_result($result2);
?>

</select>
<input name="InsertButton" type="submit" value="Insert">
<input name="Set" type="hidden" value="<?php echo $Set; ?>">
</form>

<form method="get">
<input name="ClearButton" type="submit" value="Clear">
<input name="WriteButton" type="submit" value="Write to VUPROMs">
<input name="Set" type="hidden" value="<?php echo $Set; ?>">
</form>

<form method="get">
Set Mode of NIM-Out:
<input name="SetDAQMode" type="submit" value="DAQ Mode">
<input name="SetNIMOutMode" type="submit" value="NIM-Out Mode">
<input name="Set" type="hidden" value="<?php echo $Set; ?>">
</form>


Generating patterns<hr><pre>
<?php
// output patterns
$modules=4;
$patterns=2;
$instances=8;
$outputs=32;

for($modul=0;$modul<$modules;++$modul)
	for($pattern=0;$pattern<$patterns;++$pattern) {

		// Initialize per output whishlist for input patterns
		for($o=0;$o<$outputs;++$o)
			$whishlist[$o][$modul][$pattern]=0;

		// Initialize final bit patterns
		for($instance=0;$instance<$instances;++$instance)
			$Bits[$modul][$pattern][$instance]=0;
	}

// Initialize final per output pattern selectors (wich modul/pattern to use)
for($output=0;$output<$outputs;++$output) {
		$Bits2[$output]=0;
}

// Generate whishlists
$result = mysql_query("SELECT modul,pattern,bit,output FROM channel JOIN config ON channel.input=config.input WHERE `set`=\"$Set\";");
while($row = mysql_fetch_array($result)) {
	$m = $row['modul'];
	$p = $row['pattern'];
	$b = $row['bit'];
	$o = $row['output'];

	$whishlist[$o][$m][$p] |= ( 1 << $b );	// set bit in whishlist
}
mysql_free_result($result);

// try to fulfill wishes...
// useage memory
for($instance=0;$instance<$instances;++$instance)
	for($modul=0;$modul<$modules;++$modul)
		for($pattern=0;$pattern<$patterns;++$pattern)
			$PatUse[$modul][$pattern][$instance]=-1;

for($output=0;$output<$outputs;++$output) {

	for($modul=0;$modul<$modules;++$modul)
		for($pattern=0;$pattern<$patterns;++$pattern) {

			if( $whishlist[$output][$modul][$pattern] != 0 ) {

				$found=false;
				$instance=0;

				echo "Output $output: (Modul $modul, Pattern $pattern) Trying (";
				while( !$found && $instance < $instances ) {
					echo "$instance, ";
					if ($PatUse[$modul][$pattern][$instance] == -1 ) {
						echo ") $instance is not in use. Grabbing for us\n";
						// clain the pattern for this output
						$PatUse[$modul][$pattern][$instance] = $output;
					    $Bits2[$output] |= ( 1 << ($modul*16 + $pattern*8 + $instance));
						$Bits[$modul][$pattern][$instance] = $whishlist[$output][$modul][$pattern];
						mysql_query("UPDATE config JOIN channel ON channel.input=config.input SET config.status = 1 WHERE (modul=$modul AND pattern=$pattern AND output=$output);") || die (mysql_error());
						$found=true;
					} else {
						// pattern already in use
						// see if we have the same pattern. then we can use it too
						if( $whishlist[$output][$modul][$pattern] == $Bits[$modul][$pattern][$instance] ) {
						    echo ") $instance is in use by Output ".$PatUse[$modul][$pattern][$instance]." We have the same pattern, sharing.\n";
					    	$Bits2[$output] |= ( 1 << ($modul*16 + $pattern*8 + $instance));
							mysql_query("UPDATE config JOIN channel ON channel.input=config.input SET config.status = 3 WHERE (modul=$modul AND pattern=$pattern AND output=$output);") || die(mysql_error());
							$found = true;
						}
					}
					++$instance;
				}

				if( !$found ) {
					echo ") Could not find a free instance of (Module $modul, Pattern $pattern) for output $output.\n";
					mysql_query("UPDATE config JOIN channel ON channel.input=config.input SET config.status = 2 WHERE (modul=$modul AND pattern=$pattern AND output=$o);") || die(mysql_error());
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
	writeReg( 0x11002510, 0 );
} else if(!empty($_GET['SetNIMOutMode']) ) {
	echo "Setting NIM-Out to NIM-Out Mode\n";
	writeReg( 0x11002510, 1 );
}

//---
echo "</pre><hr>";

echo "<table><tr><th>Output</th><th>Pattern</th></tr>";
for($output=0;$output<$outputs;++$output)
	printf('<tr><td>%d</td><td>%064b</td></tr>',$output,$Bits2[$output]);
echo "</table>";

echo "<table><tr><th>Mod</th><th>Pat</th><th>Inst</th><th>Pattern</th></tr>";
for($modul=0;$modul<$modules;++$modul)
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

				$str = sprintf("%064b",$Bits[$modul][$pattern][$instance]);

				$data = substr($str, 32, 32);
				$data2 = base_convert($data, 2, 10);
				$data2 += 0;
				$addr = calc_address_1( $modul, $pattern, $instance, 0);
				writeReg( $addr, $data2 );

				$data = substr($str, 0, 32);
				$data2 = base_convert($data, 2, 10);
				$data2 += 0;
				$addr = calc_address_1( $modul, $pattern, $instance, 1);
				writeReg( $addr, $data2 );
			}

		}
	}
	echo "</pre>";
}

// ======= Moeller ========

function calc_address_2 ( $output, $half ) {
	return 0x11002100 + ($output*2+$half)*0x10;
}

function write_moeller_patterns() {
	global $outputs;
	global $Bits2;

	echo "<pre name=\"prog_moeller\">";
	echo "Programming output ORs to VUPROM (Moeller)...\n";
	printf("Firmware VUPROM x11: 0x%08x\n",readReg( 0x11002f00 ));

	for($output=0; $output<$outputs; ++$output) {
		$data =  $Bits2[$output] & 0x00000000ffffffff;
		$addr = calc_address_2( $output, 0);
		writeReg( $addr, $data );

		$data =  $Bits2[$output] & 0xffffffff00000000;
		$data >>= 32;
		$addr = calc_address_2( $output, 1);
		writeReg( $addr, $data );

	}

	echo "</pre>";
}


function set_selection_box() {
	
	global $phpURL, $Set;
	$DeleteSet=$_GET["DeleteSet"];
	if(!empty($DeleteSet) ) {
		$id = $_GET["Set"];
		mysql_query("DELETE FROM config WHERE `set`=\"$id\";") || die(mysql_error());
		mysql_query("DELETE FROM setname WHERE id=\"$id\";") || die(mysql_error());
		header("Location: ".$phpURL);
	}
	echo "Set: $Set";
	echo "<form method=\"get\">";
	echo "<select name=\"Set\">";

	$result = mysql_query("SELECT id,name FROM setname ORDER BY LENGTH(name), name;");
	while($row = mysql_fetch_array($result)) {
		echo "<option value=\"".$row['id']."\"";
		if( $Set == $row['id'] ) echo " selected ";
		echo ">";
		echo $row['name'];
		echo "</option>\n";
	}
	mysql_free_result($result);
	echo "</select><input type=\"submit\" value=\"Use Set\"><input type=\"submit\" value=\"Delete Set\" name=\"DeleteSet\"></form>";
}

function new_set_box() {
	global $phpURL;
	$NewSet=$_GET["NewSet"];
	if(!empty($NewSet) ) {
		if( mysql_query("INSERT INTO setname (name) VALUES (\"$NewSet\");") ) {
			echo "New set created: $NewSet\n";
			header("Location: ".$phpURL);
		} else {
			echo "Could not add set $NewSet\n";
		}
	}
	echo "<form method=\"get\">";
	echo "<input type=\"text\" maxlength=32 name=\"NewSet\">";
	echo "<input type=\"submit\" value=\"New Set\">";
	echo "</form>";
}

function delete_set_box() {
	global $phpURL;
	$DeleteSet=$_GET["DeleteSet"];
	if(!empty($DeleteSet) ) {
		if( mysql_query("INSERT INTO setname (name) VALUES (\"$NewSet\");") ) {
			echo "New set created: $NewSet\n";
			header("Location: ".$phpURL);
		} else {
			echo "Could not add set $NewSet\n";
		}
	}

	echo "<form method=\"get\">";
	echo "<input type=\"submit\" value=\"Delete this Set\" name=\"DeleteSet\">";
	echo "</form>";
}
