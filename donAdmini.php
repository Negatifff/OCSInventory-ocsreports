<?
//====================================================================================
// OCS INVENTORY REPORTS
// Copyleft Pierre LEMMET 2005
// Web: http://ocsinventory.sourceforge.net
//
// This code is open source and may be copied and modified as long as the source
// code is always made freely available.
// Please refer to the General Public Licence http://www.gnu.org/ or Licence.txt
//====================================================================================
//Modified on 9/30/2005
include ('fichierConf.class.php');

include('req.class.php');
if($_GET["suppAcc"]) {
	@mysql_query("ALTER TABLE accountinfo DROP ".$_GET["suppAcc"], $_SESSION["writeServer"]);
	unset($_SESSION["availFieldList"], $_SESSION["currentFieldList"]);
	echo "<br><br><center><font face='Verdana' size=-1 color='red'><b>". $_GET["suppAcc"] ."</b> ".$l->g(226)." </font></center><br>";
}

if($_POST["nom"])
{
	switch($_POST["type"]) {
		case $l->g(229): $suff = "VARCHAR(255)"; break;
		case $l->g(230): $suff = "INT"; break;
		case $l->g(231): $suff = "REAL"; break;
		case $l->g(232): $suff = "DATE"; break;
	}
	
	$queryAccAddN = "ALTER TABLE accountinfo ADD ".$_POST["nom"]." $suff";
	if(mysql_query($queryAccAddN, $_SESSION["writeServer"]))
		echo "<br><br><center><font face='Verdana' size=-1 color='green'><b>". $_POST["nom"] ."</b> ".$l->g(234)." </font></center><br>";
	else 
		echo "<br><br><center><font face='Verdana' size=-1 color='red'><b>".$l->g(259)."</b></font></center><br>";
}//fin if	
?>
			<script language=javascript>
				function confirme(did)
				{
					if(confirm("<?echo $l->g(227)?> "+did+" ?"))
						window.location="index.php?multi=<?=$_GET["multi"]?>&c=<?=($_SESSION["c"]?$_GET["c"]:2)?>&a=<?=$_GET["a"]?>&page=<?=$_GET["page"]?>&suppAcc="+did;
				}
			</script>
<?
printEnTete($l->g(56));
echo "
			<br>
		 <form name='ajouter_reg' method='POST' action='index.php?multi=9'>
	<center>
	<table width='60%'>
	<tr>
		<td align='right' width='50%'>
			<font face='Verdana' size='-1'>".$l->g(228)." :&nbsp;&nbsp;&nbsp;&nbsp;</font>
		</td>
		<td width='50%' align='left'><input size=40 name='nom'>
		</td>
	</tr>
	<tr>
		<td align=center>
			<font face='Verdana' size='-1'>".$l->g(66).":</font>
		</td>
		<td>
			<select name='type'>
				<option>".$l->g(229)."</option>
				<option>".$l->g(230)."</option>
				<option>".$l->g(231)."</option>
				<option>".$l->g(232)."</option>
			</select>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
		<tr>
		<td colspan='2' align='center'>
			<input class='bouton' name='enre' type='submit' value=".$l->g(114)."> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	
	</table></center></form><br>
	";
	printEnTete($l->g(233));
	$reqAc = mysql_query("SELECT * FROM accountinfo LIMIT 0,1", $_SESSION["readServer"]) or die(mysql_error($_SESSION["readServer"]));
	echo "<br><table BORDER='0' WIDTH = '50%' ALIGN = 'Center' CELLPADDING='0' BGCOLOR='#C7D9F5' BORDERCOLOR='#9894B5'>";
	echo "<tr><td align='center'><b>".$l->g(49)."</b></font></td><td align='center'><b>".$l->g(66)."</b></font></td></tr>";		
	while($colname=mysql_fetch_field($reqAc)) {		
		if( $colname->name!="DEVICEID" && $colname->name!=TAG_NAME) {
			$x++;
			echo "<TR height=20px bgcolor='". ($x%2==0 ? "#FFFFFF" : "#F2F2F2") ."'>";	// on alterne les couleurs de ligne			
			echo "<td align=center>".$colname->name."</font></td><td align=center>".$colname->type."</font></td><td align=center>
			<a href=# OnClick='confirme(\"".$colname->name."\");'><img src=image/supp.png></a></td></tr>";
		}
	}
	echo "</table><br>";

?>

