<?php
require ("../inc/php/admin_header.inc.php");


if($angemeldet == 1 && $statadmin['admin_status'] > 0 || $angemeldet == 1 && $statadmin1['admin_status'] > 0)
	{
	$objAstcc = new DB(); $objAstcc->connect(ASTCC);
	if($angemeldet == 1 && $statadmin['admin_status'] < 1 && $statadmin['admin_status'] !='' || 
	$angemeldet == 1 && $statadmin1['admin_status'] < 1 && $statadmin1['admin_status'] !='' )
	{echo "<SCRIPT LANGUAGE='JavaScript'>window.location.replace('rate_sorted.php')</script>";}

	switch ($_VARS['action'])
		{
		case "add":
		$aTrunks = $objAstcc->select("SELECT name FROM asterisk.trunks ORDER BY name");
		if($_VARS['button'] == "store")
  			{
   				$sTrunks = $_VARS['input_trunks0'];
				if ($_VARS['input_trunks1'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks1'];
				}
				if ($_VARS['input_trunks2'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks2'];
				}
				if ($_VARS['input_trunks3'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks3'];
				}
				if ($_VARS['input_trunks4'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks4'];
				}
				if ($_VARS['input_trunks5'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks5'];
				}
				
			mysqli_query($ladmin,"INSERT INTO routes SET pattern='". $_VARS['input_pattern']."', trunks='". $sTrunks . "', 
			comment='". $_VARS['input_comment'] ."', ek='".(Tarif($_VARS['input_ek']) * 10000)."', cost='".(Tarif($_VARS['input_cost']) * 10000)."', 
			connectcost='".(Tarif($_VARS['input_connectcost']) * 10000)."', includedseconds='". $_VARS['input_includedseconds'] ."'");
			$sMessage = translate("adminratesnewsaved");
  			}
			echo'<div class="bigboldblack">'.translate("adminratesheadline").'</div>
			<div class="boldred">'.translate("adminratessubheadline").'<div></p>
			</strong></font>
			<form name="new_rates_frm" action="'.$_SERVER['PHP_SELF'].'" method="POST">
			<input type="hidden" name="action" value="add" />
			<input type="hidden" name="button" value="store" />
			<table class="rates_tbl" align="center">';
  			printFormText("Prefix","input_pattern",$_VARS['input_pattern']);
			printFormText("Comment","input_comment",$_VARS['input_comment']);				
			echo'<tr>
				<th class="txt">'.translate("provider").'</th>
				<td class="txt" style="padding-top:5px;">';
			$CTX = 0 ;
			while($CTX < 6)
				{
				echo'<select name="input_trunks'.$CTX.'">
				<option value=""></option>';
				foreach((array)$aTrunks as $key=>$val)
					{
					echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
					}
				$CTX = $CTX + 1 ;
				echo'</select><br/>';
				}
			echo'</td></tr>';
			printFormText(translate("adminratesrateek2") ,"input_ek",$_VARS['input_ek']);
			printFormText(translate("adminratesratevk2"),"input_cost",$_VARS['input_cost']);
			printFormText(translate("connectcost") ,"input_connectcost",$_VARS['imput_connectcost']);
			printFormText(translate("includetime") ,"input_includedseconds",$_VARS['imput_includedseconds']);
			echo'<tr>
    		<td class="gapright" colspan="6">
     	 	<input type="submit">
			</td></tr></table></form>
			<div class="messages">'.$sMessage.'</div>';
			break;
			
			
		#############
		# Edit rate #
		#############				
		case "edit":
		
			if($_VARS['button'] == "store")
  			{
   				$sTrunks = $_VARS['input_trunks0'];
				if ($_VARS['input_trunks1'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks1'];
				}
				if ($_VARS['input_trunks2'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks2'];
				}
				if ($_VARS['input_trunks3'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks3'];
				}
				if ($_VARS['input_trunks4'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks4'];
				}
				if ($_VARS['input_trunks5'] <> "")
				{
					$sTrunks .= ":" . $_VARS['input_trunks5'];
				}
								
			mysqli_query($ladmin,"UPDATE ".ASTCC.".routes SET pattern='". $_VARS['input_pattern']."', trunks='". $sTrunks . "', 
			comment='". $_VARS['input_comment'] ."', cost='".(Tarif($_VARS['input_cost']) * 10000)."', 
			connectcost='".(Tarif($_VARS['input_connectcost']) * 10000)."', includedseconds='". $_VARS['input_includedseconds'] ."' 
			WHERE pattern='".$_VARS['pat']."' LIMIT 1");
			$sMessage = translate("adminrateschangesaved");
  			}

			$aTrunks = $objAstcc->select("SELECT name FROM asterisk.trunks ORDER BY name");
				if ( strlen($_VARS['input_pattern']) > 0)
				{
				$iPattern = $_VARS['input_pattern'];
				}
				else
				{
				$iPattern = $_VARS['pat'];
				}
			$aRate = $objAstcc->select("SELECT * FROM ".ASTCC.".routes WHERE pattern='".$iPattern."' LIMIT 1");
			list($erster, $zweiter, $dritter) = explode(":",$aRate[0]['trunks']);
			echo'<div class="headline_global">'.translate("adminratesheadline").'</div><br />';
			?>						 
			<p align="center"><font color="#330000" ><?=translate("actrateis"); ?> 
			<? echo ($aRate[0]['pattern']); ?> <?=translate("to"); ?> <? echo ($aRate[0]['comment']); ?> <?=translate("is"); ?> :<br />
			<?=translate("adminratesrateek2"); ?>: <font color="#0000FF"><strong><? echo (($aRate[0]['ek'])/100); ?>
			</font></strong> Cents, 
			<?=translate("adminratesratevk2"); ?>: <font color="#0000FF"><strong><? echo (($aRate[0]['cost'])/100); ?></font></strong> Cents, 
			<?=translate("connectcost"); ?>: <font color="#0000FF"><strong><? echo (($aRate[0]['connectcost'])/100); ?></font></strong> Cents, 
			<?=translate("includetime"); ?>: <font color="#0000FF"><strong><? echo ($aRate[0]['includedseconds']); ?></font></strong> Seconds</font>
			<form name="new_rates_frm" action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
			<input type="hidden" name="button" value="store" />
			<table class="rates_tbl" align="center">
  			<?=printFormText(translate("adminratesldcall") ,"input_pattern",$aRate[0]['pattern'])?>
			<?=printFormText(translate("description") ,"input_comment",$aRate[0]['comment'])?>
			<tr>
			<th class="txt"><?=translate("provider"); ?></th>
			<td class="txt">
			<?					
			$Co = 0 ;
			while($Co < 6)
				{
				echo'<select name="input_trunks'.$Co.'">
					<option value=""></option>';
				foreach((array)$aTrunks as $key=>$val)
					{
					echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
					}
				$Co = ($Co + 1) ;
				echo'</select><br/>';
				}
			echo'</td>';
			?>			
			</tr>				
			<? //=printFormText(translate("adminratesrateek2") ,"input_ek",$aRate[0]['ek'])?>
			<?=printFormText(translate("adminratesratevk2") ,"input_cost",($aRate[0]['cost'] / 10000))?>
			<?=printFormText(translate("connectcost") ,"input_connectcost",$aRate[0]['connectcost'])?>
			<?=printFormText(translate("includetime") ,"input_includedseconds",$aRate[0]['includedseconds'])?>
			<tr>
			<td class="gapright" colspan="6">
			<input type="hidden" name="action" value="edit" />
			<input type="hidden" name="pat" value="<?=$_VARS['pat'];?>" />
			<input type="hidden" name="input_ek" value="<?=$aRate[0]['ek'];?>" />				
			<input type="submit" value="<?=translate("admincustchangesubmit"); ?>" />
			</td></tr></table>
			</form>
			<?php
			echo'<div class="messages">'.$sMessage.'</div>';
			break;
		
		
		###############
		# Delete rate #
		###############
		case "del":
			mysqli_query($ladmin,"DELETE FROM ".ASTCC.".routes WHERE pattern='" . $_VARS['pat'] . "' LIMIT 1");
			if ($iDelRoute == 1)
				{
				$sMessage= translate("adminratesdeleted")."<br />".translate("admincustclicklink").": <a class='big_links' href='".$_SERVER['PHP_SELF']."'>Link</a>";
				}
			echo'<div class="bigboldblack">'.translate("adminratesheadline").'</div>
			<div class="messages">'.$sMessage.'</div>';
			break;
		##################
		# Rates overview #
		##################
		default:
			############## 
			# Navigation #
			##############

################### select form ###########################		
echo '<form name="Myselect" action="'.$_SERVER['PHP_SELF'].'?sort=" method="get">';
$sel = mysql_query("SELECT comment , pattern FROM ".ASTCC.".routes");
echo ''.translate("firstname").'/Prefix <input type="texte" name="letter" />';
echo '<input type="button" class="back_button" value="Ok" OnClick="document.Myselect.submit()"></form>';
################### /select form ##########################

if(isset($_GET["letter"]))
	{  
	$letter =  mysqli_real_escape_string($ladmin,$_GET["letter"]);
	///////////////////////////////////////////////////// MASS TARIF MODULE //////////////////////////////////////////	
	echo'<table width="800" align="center"><tr>
		<td colspan="7" align="center">'.translate("gentarif").'</td></tr><tr><form action="'.$_SERVER['PHP_SELF'].'?letter='.$letter.'" method="POST">
		<td>'.translate("adminratesratevk2").' : </td><td><input type="text" name="Sp" /></td>
		<td>'.translate("connectcost").' : </td><td><input type="text" name="Cc" /></td>
		<td>'.translate("includetime").' : </td><td><input type="text" name="It" /></td>
		<input type="hidden" name="letter" value="'.$letter.'" />
		<input type="hidden" name="update" value="update" />
		<td><input type="submit" /></td></form></tr></table>';
	
	if (isset($_POST['letter']) && isset($_POST['Sp']) && isset($_POST['update']))
		{
		echo'yes';
		mysqli_query($ladmin,"UPDATE routes SET cost='".(Tarif($_POST['Sp']) * 10000)."', connectcost='".(Tarif($_POST['Cc']) * 10000)."', 
		includedseconds='".$_POST['It']."' WHERE comment LIKE '".$letter."%' || pattern LIKE '".$letter."%'") or die(mysqli_error($ladmin));
		}
	///////////////////////////////////////////////// END MASS TARIF MODULE //////////////////////////////////////////
$sCdrsql = "SELECT comment,trunks,ek,cost,connectcost,includedseconds,pattern FROM routes WHERE comment LIKE '".$letter."%' || pattern LIKE '".$letter."%' ORDER BY comment";
$aRates = $objAstcc->select($sCdrsql);
?>
<div class="headline_global"><?=translate("adminratesheadline"); ?></div><table class="bigtbl" align="center"><tr>
<th class="small_headline"><?=translate("destination"); ?></th>
<th class="small_headline"><?=translate("provider"); ?></th>
<th class="small_headline"><?=translate("adminratesldcall"); ?></th>
<th class="small_headline"><?=translate("adminratesrateek2"); ?></th>
<th class="small_headline"><?=translate("adminratesratevk2"); ?></th>
<th class="small_headline"><?=translate("connectcost"); ?></th>
<th class="small_headline"><?=translate("includetime"); ?></th>
<th class="small_headline">&nbsp;</th>
</tr>
<?php
for($i = 0; $i < count($aRates); $i++)
{
@extract($aRates[$i]);
$iRate = $cost/10000;
$iEkRate = $ek/10000;
$iconnectcost = $connectcost/10000;
$iincludedseconds = number_format($includedseconds, 0, ",", ".");
?>
<tr id="tr_<?=$i;?>" onmouseout="showRow(<?=$i;?>,0)" onmousemove="showRow(<?=$i;?>,1);">
<td class="border_tds"><?=$comment;?></td>
<td class="border_tds"><?=$trunks;?></td>
<td class="border_tds"><?=$pattern;?></td>
<td class="border_tds"><?=$iEkRate;?></td>
<td class="border_tds"><?=$iRate;?></td>
<td class="border_tds"><?=$iconnectcost;?>
<td class="border_tds"><?=$iincludedseconds;?>&nbsp;<?="Seconds"; ?></td>
<td class="border_tds" style="text-align:center;">
<a class="big_links" href='<?=$_SERVER['PHP_SELF'];?>?action=edit&title=<?=translate("adminratesheadline"); ?>&pat=<?=$pattern;?>'><img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a>
			<?php
				echo'<a class="big_links" 
				href="javascript:if(confirm(\''.translate("adminratesconfirmdelete").' '.$pattern.'\')) 
				document.location.href=\''.$_SERVER['PHP_SELF'].'?action=del&pat='.$pattern.'\';">';
				echo'<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete" title="Delete" /></a></td></tr>';
				}
			echo'<tr><td class="gapright" colspan="8"><a class="big_links" href="'.$_SERVER['PHP_SELF'].'?action=add">'.translate("adminratescreatenew").'</a>
				</td></tr></table><br />';
			$sHeadline;
	
			}
		echo "<p align=\"center\"><a href=\"importsql.php\">Import from cvs database click here</a>";
		}
	}
else
	{
	echo'<div class="headline_global">'.translate("adminratesheadline").'</div>
		<div class="boldred">'.translate("loginfailed").'</div>';
	}
require("../inc/php/admin_footer.inc.php");
?>