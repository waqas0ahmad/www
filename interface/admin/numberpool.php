<?php
require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1 && $aAdmin[0]['admin_status'] > 0)
{
        # Create object for asterisk
	$objAsterisk = new DB();
	$objAsterisk->connect(ASTERISK);
	
	switch ($_VARS['action'])
	{
	
                ###################
                # Add phonenumber #
                ###################
		case "add":
			if ($_VARS['button'] == "store")
			{
				# Calculates count of numbers to put into db
				$iRange = $_VARS['input_stoprange'] - $_VARS['input_startrange'];
				# Typeconversion, put a 001 into database as 001 and not 1
				$tmp_lendiff=strlen($_VARS['input_startrange'])-strlen($i);
                                # Puts the numbers, one by one, into the database
				for($i = 0; $i <= $iRange; $i++)
				{
					$iSuffix = $_VARS['input_startrange'] + $i;
					$sInsertNumber = strval($_VARS['input_extnumber'] . sprintf("%0" . ($tmp_lendiff) . "d", $iSuffix));
					//$sInsertNumber = $_VARS['input_extnumber'] + $i;
					$iAddNumberpool = $objAsterisk->query("INSERT INTO numberpool SET extnumber='" . $sInsertNumber . "', carrier='" . $_VARS['input_carrier'] . "'");
					# Counts the inserted data sets
					$iCounter++;
				}
				
				# Feedback to user
				$sMessage = translate("adminpoolcount") . " " . $iCounter;
			}
			?>
			
			<div class="boldblack"><?=translate("adminpooltext1"); ?></div><br><br>
			<form name="nummernpool_frm" action="<?=$PHP_SELF;?>" method="POST">
			<input type="hidden" name="action" value="add" />
			<input type="hidden" name="button" value="store" />
			<table class="bigtbl" align="center">
			<?=printFormText(translate("adminpoolheadnumber") ,"input_extnumber","")?>
			<?=printFormText(translate("adminpoolfirstnumber") ,"input_startrange","")?>
			<?=printFormText(translate("adminpoollastnumber") ,"input_stoprange","")?>
			<?=printFormText(translate("adminpoolcarrierinfo") ,"input_carrier","")?>
			<tr><td>&nbsp;</td><td><input type="submit" value="<?=translate("adminpooladdnumber"); ?>"></td></tr>
			</table>
			</form><br />
			
			<?php
			break;
		
                ######################
                # Delete phonenumber #
                ######################
		case "del":
				$iDelNumber = $objAsterisk->query("DELETE FROM asterisk.numberpool WHERE extnumber='" .$_VARS['number'] . "'");
				
				if ($iDelNumber == 1)
				{
					$sMessage = translate("adminpooldelnumberdeleted");
				}
				
			break;
	# Ende switsh
	}
                #######################
                # Overview of numbers #
                #######################
                        ##############
                        # Navigation #
                        ##############
			
			$iRecords_per_page = 20;
			$iOffset_record = $iPage * $iRecords_per_page;
			$iPages_per_pageList = 10;
			
			$sCdrsql = "SELECT * FROM numberpool Order BY extnumber LIMIT ".$iOffset_record.", ".$iRecords_per_page;
			$sCountQuery = "SELECT * FROM numberpool";
			
			# Navigation
			$aPager = $objAsterisk->pager($iPage, $iRecords_per_page, $iPages_per_pageList, $sCdrsql, $sCountQuery);
			
			if($aPager->total_pages!=1)
			{
			  $sHeadline.="<table border='0' cellspacing='0' cellpadding='0' align='center'>";
			  $sHeadline.="<tr>";
			  if($aPager->current_page>3) $sHeadline.="<td><a href=\"numberpool.php?iPage=0\" class='pager'><img src='../imgs/pager/pagerBack2.gif' border='0'></a></td>";
				if($aPager->pageList_preceding) $sHeadline.="<td><a href=\"numberpool.php?iPage=".(($aPager->last_page_in_pageList)-5)."\" class='pager'><img src='../imgs/pager/pagerBack1.gif' border='0'></a></td>";
			  
			  for($i=$aPager->offset_page;$i<$aPager->last_page_in_pageList;$i++)
			  {
				if($iPage==$i)
		{
				  $sHeadline.="<td background='../imgs/pager/pagerCurrent.gif' width='20' height='20' align='center' class='pager'>".($i+1)."</td> ";
				}
				else
				{
				  $sHeadline.="<td background='../imgs/pager/pager.gif' width='20' height='20' align='center'><a href=\"numberpool.php?iPage=$i\" class='pager'>".($i+1)."</a></td> ";
				}
			  }
					
			  if($aPager->pageList_subsequent) $sHeadline.="<td align='center' width='20' height='20'><a href=\"numberpool.php?iPage=".(($aPager->last_page_in_pageList))."\" class='pager'><img src='../imgs/pager/pagerFor1.gif' border='0'></a></td>";
					  
			  if($aPager->total_pages>=10 && $aPager->last_page_in_pageList!=$aPager->total_pages) $sHeadline.="<td align='center' width='20' height='20'><a href=\"numberpool.php?iPage=".($aPager->total_pages-1)."\" class='pager'><img src='../imgs/pager/pagerFor2.gif' border='0'></a></td>";
			  
			  $sHeadline.="</tr>";
			  $sHeadline.="</table>";	
			}
			$aNumbers = $objAsterisk->select($sCdrsql);
			?>
			
			<div class="headline_global"><?=translate("adminpoolheadline"); ?></div>
			<div class="boldblack"><?=translate("adminpoolsubheadline"); ?></div><br><br>
			<div class="boldblack"><?=$sMessage;?></div>
    		<table class="bigtbl" align="center">
      			<tr>
        			<th class="bigtbl_th" colspan="3"><?=translate("adminpoolheadline"); ?></th>
      			</tr>
      			<tr>
        			<th class="bigtbl_th"><?=translate("adminpoolnumber"); ?></th>
					<th class="bigtbl_th"><?=translate("provider"); ?></th>
					<th class="bigtbl_th"><?=translate("action"); ?></th>
				</tr>
				<?php
				for($i = 0; $i < count($aNumbers); $i++)
				{
				?>
				<tr>
        			<td class="bigtbl_td"><?=$aNumbers[$i]['extnumber'];?></td>
					<td class="bigtbl_td"><?=$aNumbers[$i]['carrier'];?></td>
					<td class="bigtbl_td">
						<a class="big_links" href="javascript:if(confirm('<?=translate("adminpooldelnumberconfirm"); ?> <?=$aNumbers[$i]['extnumber'];?>')) document.location.href='<?=$PHP_SELF;?>?action=del&number=<?=$aNumbers[$i]['extnumber'];?>&carr=<?=$aNumbers[$i]['carrier'];?>';">
						<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete" title="Delete" /></a></td>
				</tr>
				<?php
				}
				?>
				
				<tr>
					<td class="gapright" colspan="3"><a class="big_links" href='<?=$PHP_SELF;?>?action=add'><?=translate("adminpooladdnumber"); ?></a></td>
				</tr>
			</table>
			<br />

			<?=$sHeadline;?>
			
			<?php
			
$objAsterisk->closeDb();

}

# User is not logged in:
else
{
?>
	<div class="headline_global"><?=translate("adminpoolheadline"); ?></div><br />
	<div class="boldred"><?=translate("loginfailed"); ?></div><br />
<?php
}

require("../inc/php/admin_footer.inc.php");

?>
