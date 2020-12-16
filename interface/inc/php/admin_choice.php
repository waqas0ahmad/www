<?
echo'
				<table align="center"><tr>
				<td width="100"></td>';
				?>
				<td><form><img src="../imgs/gimmics/flag_fr.png" width="12" height="9" border="0" />
				<input name="button" type="button"  class="butlink1" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=FR'"
				value="Francais">
				</form></td>
				<td><form>
				<img src="../imgs/gimmics/flag_us.png" width="12" height="9" border="0" />
				<input name="button2" type="button"  class="butlink1" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=EN'" 
				value="English">
          		</form></td>
          		<td><form>
            	<img src="../imgs/gimmics/flag_es.jpg" width="12" height="9" border="0" />
            	<input name="button2" type="button"  class="butlink1" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=ES'" 
				value="Espanol">
          		</form></td>
          		<td><form>
            	<img src="../imgs/gimmics/flag_pt.jpg" width="12" height="9" border="0" />
            	<input name="button2" type="button"  class="butlink1" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=PT'" 
				value="Portuges">
          		</form></td>
          		<td><form>
            	<img src="../imgs/gimmics/flag_ro.jpg" width="12" height="9" border="0" />
            	<input name="button2" type="button"  class="butlink1" OnClick="window.location.href='<? $PHP_SELF; ?>?action=lang&lang=RO'" 
				value="Romana">
          		</form></td>
          		<td width="100">
				<?php
					     if ($angemeldet == 1)
    {
			if(!@include ("admin_login_frm.inc.php") )
			{ echo'<b class="boldred">'.translate("includeloginboxfailed").'</b>'; }
			} 
				?>
				</td></tr></table>
				
        		<table width="200" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
            	<td width="174" ><?php
          if ($angemeldet == 1)
          {
            echo '<div><font size="5">'. $NomSociete .'</font></div><div><p style="color:red;"><font size="5">'.$Amountcredit.' EUR</font></p></div></br>';
          }else{
            echo'<div class="boldred">'.translate("loginfailed").'</div>';
			
          }
		  
echo'
			</td>
			
			</tr>
			
			</table>';