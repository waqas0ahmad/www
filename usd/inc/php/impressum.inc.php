<div class="headline_global"><?=translate("impressum"); ?></div>
<center>
</span>
<span class="schwarz"><?=translate("ownerofsystem"); ?></span>
<p class="schwarz"><span class="schwarz"><?=FIRMENNAME;?></span><br>
<?=FIRMENSTRASSE;?><br>
<?=PLZ;?> <?=ORT;?></p>
<p class="schwarzfett"><?=LAND;?></p>
<p class="schwarz"><?=translate("phoneno"); ?>: <?=TELEFON;?><br>
Telefax: <?=FAX;?></p>
<p><span class="schwarz">E-Mail: </span><a href="mailto:<?=EMAIL;?>" class="big_links"><?=EMAIL;?></a><span class="schwarz"></span></p>
<p class="schwarz"><?=translate("ownerperson"); ?>:<br> <?=VORNAME;?> <?=NACHNAME;?></p>

<?php
# If you have no "Umsatzsteuernummer", we don't show this at all
if (UMSATZSTEUERNR <> "") {
?>
<p class="schwarz"><?=translate("ownertaxnumber"); ?> <?=UMSATZSTEUERNR;?></p>
<?php
}
// Give them some blah blah of being not responsible
?>
<p class="schwarz"><?=translate("ownerresponsible"); ?><br> <?=VORNAME;?> <?=NACHNAME;?></p>
<p class="schwarz"><span class="schwarzfett"><?=translate("ownertext1"); ?>:</span><br>
<?=translate("ownertext2"); ?>
</p>
<p class="schwarz"><span class="schwarzfett"><?=translate("ownertext3"); ?></span><br>
<?=translate("ownertext4"); ?>
</p>
<p class="schwarz"><?=translate("ownertext5"); ?> <?=LINK;?> <?=translate("ownertext6"); ?> </p>
<br>
<p class="schwarz">Author of VoIPonCD &copy; 2005-2008 Rolf Winterscheidt, rowi.net it-services (<a href="http://www.voiponcd.de">http://www.voiponcd.de</a>)</p> 
</center>
