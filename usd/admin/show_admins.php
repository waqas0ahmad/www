<?php

require ("../inc/php/admin_header.inc.php");

if($angemeldet == 1 && $aAdmin[0]['admin_status'] > 0)
{

  $objAstcc = new DB();
  $objAstcc->connect(ASTCC);
  
  # Get count of admins
  $iAdmins = count($aAdmins);
  
	switch ($_VARS['action']) {
	
		###########################
		# Creat new admin account #
		###########################
		case "add":     
			# Check if all necessary fields are filled out
  			$reval = checkrequiredValuescontact($_VARS);
  
  			# Save data into database
  			if ($_VARS['button'] == "send" AND sizeof($reval) == 0)
  			{
    				# Encrypt password
  				$input_md5webpw = md5($_VARS['input_webpw']);
    
				# Be sure there is an adminstatus
				if ($_VARS['input_adminstatus'] == '') { $_VARS['input_adminstatus']=0; };

  				# Save new user into database
    				$sInputSQL = "INSERT INTO ".ASTCC.".webadmins SET admin_username='".$_VARS['input_webuser']."', 
					admin_password='$input_md5webpw', 
					admin_status='".$_VARS['input_adminstatus']."', admin_vorname='".$_VARS['input_vorname']."', 
					admin_nachname='".$_VARS['input_nachname']."',
					admin_firma='".$_VARS['input_firma']."', admin_strasse='".$_VARS['input_strasse']."', 
					admin_adresszusatz='".$_VARS['input_adresszusatz']."',
					admin_hausnr='".$_VARS['input_hausnr']."', admin_plz='".$_VARS['input_plz']."', 
					admin_ort='".$_VARS['input_ort']."', admin_gebdat='".$_VARS['input_gebdat']."',
					admin_email='".$_VARS['input_email']."', admin_telefon='".$_VARS['input_telefon']."', 
					admin_ip='".$REMOTE_ADDR."', lastlogin=NOW(), created=NOW()";
    			$iAddCustomer = $objAstcc->query($sInputSQL);
  				$sMessage = $_VARS['input_vorname'] . " " . $_VARS['input_nachname'] . " " . translate("admineditisinserted");				
			}
			?>			
			
			<div class="headline_global"><?=translate("admineditheadline"); ?></div>
			<div class="bigboldblack"><?=translate("admineditnewadmin"); ?></div>
			<div class="boldlightgreen"><?=$sMessage;?></div>
			
			<?php
			if($_VARS['button'] == "send" AND sizeof($reval) > 0)
  			{
			?>
			
  				<div class='messages'><?=translate("thereareerrors"); ?>:<br /><br />
			
			<?php
    			foreach ($reval as $v => $key)
    			{
      				echo "<p>&raquo;&nbsp;" . $errormessages[$v] . "</p>";
    			}
			}
			?>
			
				</div>
				<br />
				<form action="<?php echo $PHP_SELF; ?>" method="post">
				<table class="accounttbl" border="0" cellpadding="0" cellspacing="0" align="center">
				<?=printFormText(translate("webuser") . " <sup>*</sup>","input_webuser",$_VARS['input_webuser'])?>  
				<?=printFormPassword(translate("admincustformtext2") . " <sup>*</sup>","input_webpw","")?>
				<?=printFormPassword(translate("admincustformtext3") . " <sup>*</sup>","input_webpw2","")?>
				<?=printFormSelect(translate("adminstatus") ,"input_adminstatus", array("Administrator" => 0, 
				"Superadministrator" => 1 ),$_VARS['input_adminstatus']);?>
				  <?=printFormText(translate("firstname") . " <sup>*</sup>","input_vorname",$_VARS['input_vorname'])?>
				  <?=printFormText(translate("lastname") . " <sup>*</sup>","input_nachname",$_VARS['input_nachname'])?>
				  <?=printFormText(translate("emailaddress")  ,"input_email",$_VARS['input_email'])?>
				  <?=printFormText(translate("phoneno")  ,"input_telefon",$_VARS['input_telefon'])?>
  				  <tr><td>&nbsp;</td><td><input type=submit value='<?=translate("admineditaddadmin"); ?>'></td></tr>
				</table>
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="button" value="send">
				</form>
			
			<?php
			break;
	
		###################
		# Delete an admin #
		###################
		case "del":
			# Delete admin from table webadmins
			$aDelAdmin = $objAstcc -> query("DELETE FROM ".ASTCC.".webadmins WHERE admin_id='" . $_VARS['id'] ."'");
			
			############## 
			# Navigation #
			##############
			
			$iRecords_per_page = 20;
			$iOffset_record = $iPage * $iRecords_per_page;
			$iPages_per_pageList = 10;
			$sCdrsql = "SELECT * FROM ".ASTCC.".webadmins LIMIT ".$iOffset_record.", ".$iRecords_per_page;
			$sCountQuery = "SELECT * FROM webadmins";
			
			$aPager = $objAstcc->pager($iPage, $iRecords_per_page, $iPages_per_pageList, $sCdrsql, $sCountQuery);
			
			if($aPager->total_pages!=1)
			{
			  $sHeadline.="<table border='0' cellspacing='0' cellpadding='0' align='center'>";
			  $sHeadline.="<tr>";
			  if($aPager->current_page>3) $sHeadline.="<td><a href=\"show_admins.php?iPage=0\" class='pager'><img src='../imgs/pager/pagerBack2.gif' border='0'></a></td>";
				if($aPager->pageList_preceding) $sHeadline.="<td><a href=\"show_admins.php?iPage=".(($aPager->last_page_in_pageList)-20)."\" class='pager'><img src='../imgs/pager/pagerBack1.gif' border='0'></a></td>";
			  
			  for($i=$aPager->offset_page;$i<$aPager->last_page_in_pageList;$i++)
			  {
				if($iPage==$i)
				{
				  $sHeadline.="<td background='../imgs/pager/pagerCurrent.gif' width='20' height='20' align='center' class='pager'>".($i+1)."</td> ";
				}
				else
				{
				  $sHeadline.="<td background='../imgs/pager/pager.gif' width='20' height='20' align='center'>
				  <a href=\"show_admins.php?iPage=$i&title=" . translate("admineditheadline") . "\" class='pager'>".($i+1)."</a></td> ";
				}
			  }
					
			  if($aPager->pageList_subsequent) $sHeadline.="<td align='center' width='20' height='20'><a href=\"show_admins.php?iPage=".(($aPager->last_page_in_pageList))."\" class='pager'><img src='../imgs/pager/pagerFor1.gif' border='0'></a></td>";
					  
			  if($aPager->total_pages>=10 && $aPager->last_page_in_pageList!=$aPager->total_pages) $sHeadline.="<td align='center' width='20' height='20'><a href=\"show_admins.php?iPage=".($aPager->total_pages-1)."\" class='pager'><img src='../imgs/pager/pagerFor2.gif' border='0'></a></td>";
			  
			  $sHeadline.="</tr>";
			  $sHeadline.="</table>";	
			}
			$aAdmins = $objAstcc->select($sCdrsql);
			?>

			<div class="headline_global"><?=translate("admineditheadline"); ?></div>
			<div class='boldlightgreen'><?=translate("admineditdelsuccess"); ?></div>
			<table class="bigtbl" align="center">
  				<tr>
					<th class="bigtbl_th" colspan="15"><?=translate("admineditadmins"); ?></th>
  				</tr>
  				<tr>
					<th class="bigtbl_th"><?=translate("admineditadminid"); ?></th>
					<th class="bigtbl_th"><?=translate("firstname"); ?></th>
					<th class="bigtbl_th"><?=translate("lastname"); ?></th>
					<th class="bigtbl_th"><?=translate("companyname"); ?></th>
					<th class="bigtbl_th"><?=translate("username"); ?></th>
					<th class="bigtbl_th"><?=translate("admineditlastlogin"); ?></th>
					<th class="bigtbl_th"><?=translate("admineditlastip"); ?></th>
					<th class="bigtbl_th">&nbsp;</th>
				</tr>

				<?php 
    			# Show User by User.
				for($i = 0; $i < count($aAdmins); $i++)
				{
				?>
  
  				<tr id="tr_<?=$i;?>" onmouseout="showRow(<?=$i;?>,0)" onmousemove="showRow(<?=$i;?>,1);">
    				<td class="bigtbl_td"><b><?=$aAdmins[$i]['admin_id'];?></b></td>
    				<td class="bigtbl_td"><?=$aAdmins[$i]['admin_vorname'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_nachname'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_firma'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_username'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['lastlogin'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_ip'];?></td>
					<td class="bigtbl_td">
						<a class="big_links" href="<?=$PHP_SELF;?>?action=edit&id=<?=$aAdmins[$i]['admin_id'];?>">
						<img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" /></a>&nbsp;
						<a class="big_links" href="javascript:if(confirm('<?=translate("admincustconfirmdelete"); ?> <?=$aAdmins[$i]['admin_id'];?>')) document.location.href='<?=$PHP_SELF;?>?action=del&id=<?=$aAdmins[$i]['admin_id'];?>';">
						<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete" title="Delete" /></a></td>
				</tr>

				<?php
				}
				?>
				
				<tr>
					<td class="gapright" colspan="8"><a class="big_links" href="<?=$PHP_SELF;?>?action=add"><?=translate("admineditnewadmin"); ?></a></td>
				</tr>
			</table><br />
			<?=$sHeadline;?>
			<?php
			break;
		
		#########################
		# Show deatils and edit #
		#########################
		case "edit":
			# Check form if necessary fields are filled out 
  			$reval = checkrequiredValuesAdmin($_VARS);
  
  			# Save form to database
  			if ($_VARS['button'] == "send" AND sizeof($reval) == 0)
  			{
				# Encrypt password
				$input_md5webpw = md5($_VARS['input_webpw']);
				if (strlen($_VARS['input_webpw']) > 1)
				{
					# Save changed admin data to db
					$sInputSQL = "UPDATE ".ASTCC.".webadmins SET admin_username='".$_VARS['input_webuser']."', 
					admin_password='$input_md5webpw', admin_status='".$_VARS['input_adminstatus']."', 
					admin_vorname='".$_VARS['input_vorname']."', admin_nachname='".$_VARS['input_nachname']."', 
					admin_firma='".$_VARS['input_firma']."', admin_strasse='".$_VARS['input_strasse']."', 
					admin_adresszusatz='".$_VARS['input_adresszusatz']."', admin_hausnr='".$_VARS['input_hausnr']."', 
					admin_plz='".$_VARS['input_plz']."', admin_ort='".$_VARS['input_ort']."', 
					admin_gebdat='".$_VARS['input_gebdat']."', admin_email='".$_VARS['input_email']."', 
					admin_telefon='".$_VARS['input_telefon']."', admin_ip='".$REMOTE_ADDR."', lastlogin=NOW(), 
					created=NOW() WHERE admin_id='" . $_VARS['id'] . "' LIMIT 1";
						
						$iAddCustomer = $objAstcc->query($sInputSQL);
				}
				else
				{	
					# Save changed admin data to db
					$sInputSQL = "UPDATE ".ASTCC.".webadmins SET admin_username='".$_VARS['input_webuser']."',
						admin_status='".$_VARS['input_adminstatus']."', admin_vorname='".$_VARS['input_vorname']."', admin_nachname='".$_VARS['input_nachname']."',
						admin_firma='".$_VARS['input_firma']."', admin_strasse='".$_VARS['input_strasse']."', admin_adresszusatz='".$_VARS['input_adresszusatz']."',
						admin_hausnr='".$_VARS['input_hausnr']."', admin_plz='".$_VARS['input_plz']."', admin_ort='".$_VARS['input_ort']."', admin_gebdat='".$_VARS['input_gebdat']."',
						admin_email='".$_VARS['input_email']."', admin_telefon='".$_VARS['input_telefon']."', admin_ip='".$REMOTE_ADDR."', lastlogin=NOW(), created=NOW() WHERE admin_id='" . $_VARS['id'] . "' LIMIT 1";
						
						$iAddCustomer = $objAstcc->query($sInputSQL);
				}
  				$sMessage = $_VARS['input_vorname'] . " " . $_VARS['input_nachname'] . " ". translate("admineditdatachanged");				
			}
			
			# Gets data for admin from db
			$aSelectedAdmin = $objAstcc->select("SELECT * FROM webadmins WHERE admin_id='" . $_VARS['id'] . "'");
			?>			
			
			<div class="headline_global"><?=translate("admineditheadline"); ?></div>
			<div class="bigboldblack"><?=translate("admineditdetailsedit"); ?></div>
			<div class="boldlightgreen"><?=$sMessage;?></div>
			
			<?php
			if($_VARS['button'] == "send" AND sizeof($reval) > 0)
  			{
			?>
			
  				<div class='messages'><?=translate("thereareerrors"); ?>:<br /><br />
			
			<?php
    			foreach ($reval as $v => $key)
    			{
      				echo "<p>&raquo;&nbsp;" . $errormessages[$v] . "</p>";
    			}
			}
			?>
			
				</div>
				<br />
				<form action="<?php echo $PHP_SELF; ?>" method="post">
				<table class="accounttbl" border="0" cellpadding="0" cellspacing="0" align="center">
				  <?=printFormText(translate("webuser") . " <sup>*</sup>","input_webuser",$aSelectedAdmin[0]['admin_username'])?>  
				  <?=printFormPassword(translate("admincustformtext2") . " <sup>*</sup>","input_webpw","")?>
				  <?=printFormPassword(translate("admincustformtext3") . " <sup>*</sup>","input_webpw2","")?>
				  <tr>
				  	<th class="txt"><?=translate("adminstatus"); ?> </th>
					<td width="60%">
						<select name="input_adminstatus">
							<?php
							$aTypes = array("Administrator" => 0, "Hauptadministrator" => 1 );
							foreach($aTypes as $key=>$val)
							{
								echo "<option value=\"".$val."\" ".(($val == $aSelectedAdmin[0]['admin_status'])?"selected":"").">".$key."</option>";
							}
							?>
						</select>
					</td>
				  </tr>
				  <?=printFormText(translate("firstname") . " <sup>*</sup>","input_vorname",$aSelectedAdmin[0]['admin_vorname'])?>
				  <?=printFormText(translate("lastname") . " <sup>*</sup>","input_nachname",$aSelectedAdmin[0]['admin_nachname'])?>
				  <?=printFormText(translate("emailaddress") ,"input_email",$aSelectedAdmin[0]['admin_email'])?>
				  <?=printFormText(translate("phoneno") ,"input_telefon",$aSelectedAdmin[0]['admin_telefon'])?>
  				  <tr><td>&nbsp;</td><td><input type=submit value='<?=translate("admineditsavechanges"); ?>'></td></tr>
				</table>
				<input type="hidden" name="id" value='<?=$aSelectedAdmin[0]['admin_id'];?>'>
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="button" value="send"> 
				</form>
			
			<?php
			break;
		
		###################
		# Overview admins #
		###################
		default:
			############## 
			# Navigation #
			##############
			
			$iRecords_per_page = 20;
			$iOffset_record = $iPage * $iRecords_per_page;
			$iPages_per_pageList = 10;
			$sCdrsql = "SELECT * FROM ".ASTCC.".webadmins LIMIT ".$iOffset_record.", ".$iRecords_per_page;
			$sCountQuery = "SELECT * FROM webadmins";
			
			$aPager = $objAstcc->pager($iPage, $iRecords_per_page, $iPages_per_pageList, $sCdrsql, $sCountQuery);
			
			if($aPager->total_pages!=1)
			{
			  $sHeadline.="<table border='0' cellspacing='0' cellpadding='0' align='center'>";
			  $sHeadline.="<tr>";
			  if($aPager->current_page>3) $sHeadline.="<td><a href=\"show_admins.php?iPage=0\" class='pager'><img src='../imgs/pager/pagerBack2.gif' border='0'></a></td>";
				if($aPager->pageList_preceding) $sHeadline.="<td><a href=\"show_admins.php?iPage=".(($aPager->last_page_in_pageList)-20)."\" class='pager'><img src='../imgs/pager/pagerBack1.gif' border='0'></a></td>";
			  
			  for($i=$aPager->offset_page;$i<$aPager->last_page_in_pageList;$i++)
			  {
				if($iPage==$i)
				{
				  $sHeadline.="<td background='../imgs/pager/pagerCurrent.gif' width='20' height='20' align='center' class='pager'>".($i+1)."</td> ";
				}
				else
				{
				  $sHeadline.="<td background='../imgs/pager/pager.gif' width='20' height='20' align='center'><a href=\"show_admins.php?iPage=$i\" class='pager'>".($i+1)."</a></td> ";
				}
			  }
					
			  if($aPager->pageList_subsequent) $sHeadline.="<td align='center' width='20' height='20'><a href=\"show_admins.php?iPage=".(($aPager->last_page_in_pageList))."\" class='pager'><img src='../imgs/pager/pagerFor1.gif' border='0'></a></td>";
					  
			  if($aPager->total_pages>=10 && $aPager->last_page_in_pageList!=$aPager->total_pages) $sHeadline.="<td align='center' width='20' height='20'><a href=\"show_admins.php?iPage=".($aPager->total_pages-1)."\" class='pager'><img src='../imgs/pager/pagerFor2.gif' border='0'></a></td>";
			  
			  $sHeadline.="</tr>";
			  $sHeadline.="</table>";	
			}
			$aAdmins = $objAstcc->select($sCdrsql);
			?>
			
			<div class="headline_global"><?=translate("admineditheadline"); ?></div>
			<table class="bigtbl" align="center">
  				<tr>
					<th class="bigtbl_th" colspan="8"><?=translate("admineditadmins"); ?></th>
  				</tr>
  				<tr>
					<th class="bigtbl_th"><?=translate("admineditadminid"); ?></th>
					<th class="bigtbl_th"><?=translate("firstname"); ?></th>
					<th class="bigtbl_th"><?=translate("lastname"); ?></th>
					<th class="bigtbl_th"><?=translate("companyname"); ?></th>
					<th class="bigtbl_th"><?=translate("username"); ?></th>
					<th class="bigtbl_th"><?=translate("admineditlastlogin"); ?></th>
					<th class="bigtbl_th"><?=translate("admineditlastip"); ?></th>
					<th class="bigtbl_th">&nbsp;</th>
				</tr>

				<?php 
    				# Show admins one by one	
				for($i = 0; $i < count($aAdmins); $i++)
				{
				?>
  
  				<tr id="tr_<?=$i;?>" onmouseout="showRow(<?=$i;?>,0)" onmousemove="showRow(<?=$i;?>,1);">
    				<td class="bigtbl_td"><b><?=$aAdmins[$i]['admin_id'];?></b></td>
    				<td class="bigtbl_td"><?=$aAdmins[$i]['admin_vorname'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_nachname'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_firma'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_username'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['lastlogin'];?></td>
					<td class="bigtbl_td"><?=$aAdmins[$i]['admin_ip'];?></td>
					<td class="bigtbl_td">
					<a class="big_links" href="<?=$PHP_SELF;?>?action=edit&id=<?=$aAdmins[$i]['admin_id'];?>">
					<img src="../imgs/gimmics/info.gif" width="12" height="12" border="0" valign="absmiddle" alt="Info/Edit" title="Info/Edit" />
					</a>&nbsp;<a class="big_links" href="javascript:if(confirm('<?=translate("admincustconfirmdelete"); ?> 
					<?=$aAdmins[$i]['admin_id'];?>')) document.location.href='<?=$PHP_SELF;?>?action=del&id=<?=$aAdmins[$i]['admin_id'];?>';"> 
					<img src="../imgs/gimmics/del.gif" width="12" height="12" border="0" valign="absmiddle" alt="Delete" title="Delete" /></a>
					</td></tr>

				<?php
				}
				?>
				
				<tr>
					<td class="gapright" colspan="8"><a class="big_links" href="<?=$PHP_SELF;?>?action=add"><?=translate("admineditnewadmin"); ?></a></td>
				</tr>
			</table><br />
			<?=$sHeadline;?>
		
		<?php
		# End switch
		}

}
else
{
?>
<div class="headline_global"><?=translate("admineditheadline"); ?></div>
<div class="boldred"><?=translate("loginfailed"); ?></div>
<?php
}

require("../inc/php/admin_footer.inc.php");

?>
