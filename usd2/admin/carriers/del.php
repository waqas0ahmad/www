<?
			@unlink("/etc/asterisk/sip-register/" . $_VARS['carriername']);
			$iDelSipfriends = $objAsterisk->query("DELETE FROM asterisk.sipfriends WHERE name='".$_VARS['carriername']."' LIMIT 1");
			$iDelTrunks = $objAstcc->query("DELETE FROM ".ASTCC.".trunks WHERE name='".$_VARS['carriername']."' LIMIT 1");
		 	$back=`/usr/sbin/asterisk -rx reload`;	
			$sMessage = translate("admincarrierdeleted");
?>