<?php
require ("../inc/php/admin_header.inc.php");
###############  Comdif Telecom Billing software  ###############
							$adminver= 01;
###############  Christian Zeler  Comdif Telecom  ###############
if($angemeldet == 1 && $aAdmin[0]['admin_status'] > 0)
{
$objAstcc = new DB(); $objAstcc->connect(ASTCC);
	switch ($_VARS['action']) {
# add rate #######################################
			case "add":
			$aTrunks = $objAstcc->select("SELECT name FROM trunks ORDER BY name");
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
				
$iNewRates = $objAstcc->query("INSERT INTO routes SET pattern='". $_VARS['input_pattern']."',
 trunks='". $sTrunks . "', comment='". $_VARS['input_comment'] ."', ek='" . $_VARS['input_ek'] . "', cost='". $_VARS['input_cost'] ."', connectcost='". $_VARS['input_connectcost'] ."', includedseconds='". $_VARS['input_includedseconds'] ."'");
$sMessage = translate("adminratesnewsaved");
  			}
			?><div class="bigboldblack"><?=translate("adminratesheadline"); ?></div>
			<div class="boldred"><?=translate("adminratessubheadline"); ?><div>
			<p align="center"><font color="#CC0000"><strong><?=translate("ratehelp"); ?>

</p>
			</strong></font>
			<form name="new_rates_frm" action="<?=$PHP_SELF;?>" method="POST">
			<input type="hidden" name="action" value="add" />
			<input type="hidden" name="button" value="store" />
			<table class="rates_tbl" align="center">
  				<?=printFormText("Prefix","input_pattern",$_VARS['input_pattern'])?>
				<?=printFormText("Comment","input_comment",$_VARS['input_comment'])?>				
				<tr>
					<th class="txt"><?=translate("provider"); ?></th>
					<td class="txt" style="padding-top:5px;">
						<select name="input_trunks0">
							<?
							if (strlen($_VARS['input_trunks0']) > 1)
							{
							?>
		<option value="<?=$_VARS['input_trunks0'];?>" selected><?=$_VARS['input_trunks0'];?></option>	
							<?
							}
							else
							{
							?>
							<option value="" selected><?=translate("pleasechoose"); ?></option> 
          					<?
							}
							
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
						</select>
						<select name="input_trunks1">
							<?
							if (strlen($_VARS['input_trunks1']) > 1)
							{
							?>
		<option value="<?=$_VARS['input_trunks1'];?>" selected><?=$_VARS['input_trunks1'];?></option>	
							<?
							}
							else
							{
							?>
							<option value="" selected><?=translate("pleasechoose"); ?></option> 
          					<?
							}
							
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
						</select>
						<select name="input_trunks2">
							<?
							if (strlen($_VARS['input_trunks2']) > 1)
							{
							?>
		<option value="<?=$_VARS['input_trunks2'];?>" selected><?=$_VARS['input_trunks2'];?></option>	
							<?
							}
							else
							{
							?>
							<option value="" selected><?=translate("pleasechoose"); ?></option> 
          					<?
							}
							
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
						</select>
						<select name="input_trunks3">
							<?
							if (strlen($_VARS['input_trunks3']) > 1)
							{
							?>
		<option value="<?=$_VARS['input_trunks3'];?>" selected><?=$_VARS['input_trunks3'];?></option>	
							<?
							}
							else
							{
							?>
							<option value="" selected><?=translate("pleasechoose"); ?></option> 


          					<?
							}
							
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
						</select>
						<select name="input_trunks4">
							<?
							if (strlen($_VARS['input_trunks4']) > 1)
							{
							?>
		<option value="<?=$_VARS['input_trunks4'];?>" selected><?=$_VARS['input_trunks4'];?></option>	
							<?
							}
							else
							{
							?>
							<option value="" selected><?=translate("pleasechoose"); ?></option> 
          					<?
							}
							
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
						</select>
						<select name="input_trunks5">
							<?
							if (strlen($_VARS['input_trunks5']) > 1)
							{
							?>
		<option value="<?=$_VARS['input_trunks5'];?>" selected><?=$_VARS['input_trunks5'];?></option>	
							<?
							}
							else
							{
							?>
							<option value="" selected><?=translate("pleasechoose"); ?></option> 
          					<?
							}
							
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
						</select></td>
				</tr>
				
<?=printFormText(translate("adminratesrateek") ,"input_ek",$_VARS['input_ek'])?>
<?=printFormText("Sale-price (1 cent = 100)","input_cost",$_VARS['input_cost'])?>
<?=printFormText("Connect-cost (1 cent = 100)" ,"input_connectcost",$_VARS['imput_connectcost'])?>
<?=printFormText("Include-Seconds" ,"input_includedseconds",$_VARS['imput_includedseconds'])?>
				<tr>
    				<td class="gapright" colspan="6">
     	 				<input type="submit" value="<?=translate("adminratescreate"); ?>"></td>
  				</tr>
			</table>
			</form>
			
			<div class='messages'><?=$sMessage;?></div>
			
			<?php
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
				
								
			 $iEditRates = $objAstcc->query("UPDATE routes SET pattern='". $_VARS['input_pattern']."',
					trunks='". $sTrunks . "', comment='". $_VARS['input_comment'] ."', ek='" . $_VARS['input_ek'] . "', cost='". $_VARS['input_cost'] ."',  connectcost='". $_VARS['input_connectcost'] ."',  includedseconds='". $_VARS['input_includedseconds'] ."' WHERE pattern='" . $_VARS['pat'] ."' LIMIT 1");

				$sMessage = translate("adminrateschangesaved");
  			}
			
			# Gets names of trunks for drop down
			$aTrunks = $objAstcc->select("SELECT name FROM trunks ORDER BY name");
			
			if ( strlen($_VARS['input_pattern']) > 0)
			{
				$iPattern = $_VARS['input_pattern'];
			}
			else
			{
				$iPattern = $_VARS['pat'];
			}
			
			# Gets data for this rate
			$aRate = $objAstcc->select("SELECT * FROM routes WHERE pattern='" . $iPattern . "' LIMIT 1");
			
			# Put concatenated trunks to stand alone variables
			list($erster, $zweiter, $dritter) = explode(":",$aRate[0]['trunks']);
			
			?>
			
			<div class="headline_global"><?=translate("adminratesheadline"); ?></div>
						  <br />
						 <p align="center"><font color="#CC0000"><strong><?=translate("ratehelp"); ?></p></strong></font>
			              <p align="center"><font color="#330000" ><?=translate("actrateis"); ?> <? echo ($aRate[0]['pattern']); ?> <?=translate("to"); ?> <? echo ($aRate[0]['comment']); ?> <?=translate("is"); ?> :<br />
			<?=translate("adminratesrateek2"); ?>: <font color="#0000FF"><strong><? echo (($aRate[0]['ek'])/100); ?></font></strong> Cents, 
			<?=translate("adminratesratevk2"); ?>: <font color="#0000FF"><strong><? echo (($aRate[0]['cost'])/100); ?></font></strong> Cents, 
			<?=translate("connectcost"); ?>: <font color="#0000FF"><strong><? echo (($aRate[0]['connectcost'])/100); ?></font></strong> Cents, 
<?=translate("includetime"); ?>: <font color="#0000FF"><strong><? echo ($aRate[0]['includedseconds']); ?></font></strong> Seconds			</font>
<form name="new_rates_frm" action="<?=$PHP_SELF;?>" method="POST">
			<input type="hidden" name="button" value="store" />
			<table class="rates_tbl" align="center">
  				<?=printFormText(translate("adminratesldcall") ,"input_pattern",$aRate[0]['pattern'])?>
				<?=printFormText(translate("description") ,"input_comment",$aRate[0]['comment'])?>
				<tr>
					<th class="txt"><?=translate("provider"); ?></th>
					<td class="txt">
					

<select name="input_trunks0">
<option value="<?=$erster;?>" selected><?=$erster;?></option>
							<?
							foreach((array)$aTrunks as $key=>$val)
							{
							echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
	<option value="">&nbsp;</option>
</select><br />
<select name="input_trunks1">
<option value="<?=$zweiter;?>" selected><?=$zweiter;?></option> 
          					<?
							foreach((array)$aTrunks as $key=>$val)
							{
							echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
							<option value="">&nbsp;</option>
</select><br />
<select name="input_trunks2">
<option value="<?=$dritter;?>" selected><?=$dritter;?></option> 
          					<?
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
							<option value="">&nbsp;</option>
</select><br />
<select name="input_trunks3">
<option value="<?=$quatre;?>" selected><?=$quatre;?></option> 
          					<?
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
							<option value="">&nbsp;</option>
</select>
<select name="input_trunks4">
<option value="<?=$cinq;?>" selected><?=$cinq;?></option> 
          					<?
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
							<option value="">&nbsp;</option>
</select><br />
<select name="input_trunks5">
<option value="<?=$six;?>" selected><?=$six;?></option> 
          					<?
							foreach((array)$aTrunks as $key=>$val)
							{
								echo "<option value='" . $val['name'] . "'>".$val['name']."</option>";
							}
							?>
							<option value="">&nbsp;</option>
							
							
</select></td>
</tr>				
<?=printFormText(translate("adminratesrateek2") ,"input_ek",$aRate[0]['ek'])?>
<?=printFormText(translate("adminratesratevk2") ,"input_cost",$aRate[0]['cost'])?>
<?=printFormText(translate("connectcost") ,"input_connectcost",$aRate[0]['connectcost'])?>
<?=printFormText(translate("includetime") ,"input_includedseconds",$aRate[0]['includedseconds'])?>
<tr>
<td class="gapright" colspan="6">
<input type="hidden" name="action" value="edit" />
<input type="hidden" name="pat" value="<?=$_VARS['pat'];?>" />				
<input type="submit" value="<?=translate("admincustchangesubmit"); ?>" /></td>
</tr>
</table>
</form>
<font color="#CC0000"><strong><?=translate("ratehelp"); ?>			
</font></strong><div class='messages'><?=$sMessage;?></div>
			<?php
			break;
		
		
		###############
		# Delete rate #
		###############
		case "del":
			$iDelRoute = $objAstcc->query("DELETE FROM routes WHERE pattern='" . $_VARS['pat'] . "' LIMIT 1");
			if ($iDelRoute == 1)
			{
				$sMessage = translate("adminratesdeleted") . "<br />" . translate("admincustclicklink") . ": <a class='big_links' href='$PHP_SELF'>Link</a>";
			}
			?>
			
			<div class="bigboldblack"><?=translate("adminratesheadline"); ?></div>
			<div class='messages'><?=$sMessage;?></div>
			
			<?php
			break;
		
		
		##################
		# Rates overview #
		##################
		default:
			############## 
			# Navigation #
			##############

################### select form ###########################		
echo '<form name="Myselect" action="'.$PHP_SELF.'?sort=" method="get">';
$sel = mysql_query("SELECT comment , pattern FROM ".ASTCC.".routes");
echo ''.translate("firstname").'/Prefix <input type="texte" name="letter" />';
echo '<input type="button" class="back_button" value="Ok" OnClick="document.Myselect.submit()"></form>';
################### /select form ##########################


if ($_GET['letter'] !='')
		{
		$letter = $_GET['letter'];
		$iRecords_per_page = 1000; $iOffset_record = $iPage * $iRecords_per_page; $iPages_per_pageList = 10;
		$sCdrsql = "SELECT comment, trunks, ek, cost, connectcost, includedseconds, pattern FROM routes WHERE comment 
		LIKE '".$letter."%' || pattern LIKE '".$letter."%' ORDER BY comment";
		}
		else
		{			
		echo '<strong>'.translate("srate").'</strong>';
		exit();
		}

$sCountQuery = "SELECT comment, trunks, ek, cost, connectcost, includedseconds, pattern FROM routes ORDER BY comment";
$aPager = $objAstcc->pager($iPage, $iRecords_per_page, $iPages_per_pageList, $sCdrsql, $sCountQuery);		
if($aPager->total_pages!=1)
{
$sHeadline.="<table border='0' cellspacing='0' cellpadding='0' align='center'>"; $sHeadline.="<tr>";
if($aPager->current_page>3) $sHeadline.="<td><a href=\"new_rates.php?iPage=0\" class='pager'><img src='../imgs/pager/pagerBack2.gif' border='0'></a></td>";
if($aPager->pageList_preceding) $sHeadline.="<td><a href=\"new_rates.php?iPage=".(($aPager->last_page_in_pageList)-20)."\" class='pager'><img src='../imgs/pager/pagerBack1.gif' border='0'></a></td>";
for($i=$aPager->offset_page;$i<$aPager->last_page_in_pageList;$i++)
			  {
if($iPage==$i)
				{
$sHeadline.="<td background='../imgs/pager/pagerCurrent.gif' width='20' height='20' align='center' class='pager'>".($i+1)."</td> ";
}else{
$sHeadline.="<td background='../imgs/pager/pager.gif' width='20' height='20' align='center'><a href=\"new_rates.php?iPage=$i\" class='pager'>".($i+1)."</a></td> ";
				}
			  }
					
if($aPager->pageList_subsequent) $sHeadline.="<td align='center' width='20' height='20'><a href=\"new_rates.php?iPage=".(($aPager->last_page_in_pageList))."\" class='pager'><img src='../imgs/pager/pagerFor1.gif' border='0'></a></td>";
if($aPager->total_pages>=10 && $aPager->last_page_in_pageList!=$aPager->total_pages) $sHeadline.="<td align='center' width='20' height='20'><a href=\"new_rates.php?iPage=".($aPager->total_pages-1)."\" class='pager'><img src='../imgs/pager/pagerFor2.gif' border='0'></a></td>";
$sHeadline.="</tr>"; $sHeadline.="</table>";
			  }
$aRates = $objAstcc->select($sCdrsql);
?>
<div class="headline_global"><?=translate("adminratesheadline"); ?></div><table class="bigtbl" align="center"><tr>
	<th class="small_headline"><?=translate("destination"); ?></th><th class="small_headline"><?=translate("provider"); ?></th>
	<th class="small_headline"><?=translate("adminratesldcall"); ?></th><th class="small_headline"><?=translate("adminratesrateek2"); ?></th>
	<th class="small_headline"><?=translate("adminratesratevk2"); ?></th><th class="small_headline"><?=translate("connectcost"); ?></th>
	<th class="small_headline"><?=translate("includetime"); ?></th>
	<th class="small_headline"></th>
	<th class="small_headline"></th>
	</tr>
<?php
for($i = 0; $i < count($aRates); $i++)
{
@extract($aRates[$i]);
$iRate = number_format($cost/100, 1, ",", ".");
$iEkRate = number_format($ek/100, 1, ",", ".");
$iconnectcost = number_format($connectcost/100, 0, ",", ".");
$iincludedseconds = number_format($includedseconds, 0, ",", ".");
?>
<tr id="tr_<?=$i;?>" onmouseout="showRow(<?=$i;?>,0)" onmousemove="showRow(<?=$i;?>,1);">
	<td class="border_tds"><?=$comment;?></td><td class="border_tds"><?=$trunks;?></td><td class="border_tds"><?=$pattern;?></td>
	<td class="border_tds" title="<?=$iEkRate * $tva; echo ' '.$dictionary["ttc"];?>"><?=$iEkRate;?>&nbsp;<?=translate("centperminute"); ?></td>
	<td class="border_tds"><?=$iRate;?>&nbsp;<?=translate("centperminute"); ?></td>
	<td class="border_tds"><?=$iconnectcost;?>&nbsp;Cents
	<td class="border_tds"><?=$iincludedseconds;?>&nbsp;<?="Seconds"; ?></td>
	<td class="border_tds"><a href='<?=$PHP_SELF;?>?action=edit&title=<?=translate("adminratesheadline"); ?>&pat=<?=$pattern;?>'>
		<img src="../imgs/gimmics/info.gif" width="12" height="12" alt="Info/Edit" title="Info/Edit" /></a>&nbsp;</td>
	<td class="border_tds">&nbsp;<a href="javascript:if(confirm('<?=translate("adminratesconfirmdelete"); ?> <?=$pattern;?>')) document.location.href
		='<?=$PHP_SELF;?>?action=del&pat=<?=$pattern;?>';"><img src="../imgs/gimmics/del.gif" width="12" height="12" alt="Delete" title="Delete" /></a>
		</td></tr>
<?php
}
?>
<tr>
	<td class="gapright" colspan="9"><a class="big_links" href='<?=$PHP_SELF;?>?action=add'><?=translate("adminratescreatenew"); ?></a></td></tr></table><br />
<?
$sHeadline;
}
echo "<p align=\"center\"><a href=\"importsql.php\">Import from cvs database click here</a>";

}else{
?>
<div class="headline_global"><?=translate("adminratesheadline"); ?></div>
<div class="boldred"><?=translate("loginfailed"); ?></div>
<?php
}
require("../inc/php/admin_footer.inc.php");
?>