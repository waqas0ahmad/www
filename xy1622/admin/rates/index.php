<?
echo'
<br/>
<form action="'.$_SERVER['PHP_SELF'].'" method="post">
<input type="hidden" name="update" value="update" />
<div>
<input type="text" name="pascher" value="580" />
&nbsp;&nbsp;What is low cost destination for you, I use here myself : <strong>580</strong>, it does mean 0.058 &euro; or $<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Take many care about format 1000 is 10 cents and 100 is 1 cents<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
All destinations under this price will have (Purchase price) X (profit for low cost destinations) formula.
</div><br/>

<div>
<input type="text" name="maxprice" value="2900" />
&nbsp;&nbsp;Voip is not without risk and claim, for safety reason you can fix a limit price for your offer<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Take many care about format 1000 is 10 cents and 100 is 1 cents<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
All destinations purchase price over this price will not be relayed my side I use : <strong>2900</strong>, (29 cents) and is OK.<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Just look at your main target destination and fix this price just over (this will solve Premium expensive numbers problems).
</div><br/>

<div>
<select name="multi" style="width:128" >
<option value="2.5">X 2.5</option>
<option value="2.4">X 2.4</option>
<option value="2.3">X 2.3</option>
<option value="2.2">X 2.2</option>
<option value="2.1">X 2.1</option>
<option selected="selected" value="2">X 2</option>
<option value="1.9">X 1.9</option>
<option value="1.8">X 1.8</option>
<option value="1.7">X 1.7</option>
<option value="1.6">X 1.6</option>
<option value="1.5">X 1.5</option>
<option value="1.4">X 1.4</option>
<option value="1.3">X 1.3</option>
<option value="1.2">X 1.2</option>
<option value="1.1">X 1.1</option>
<option value="1">No profit</option>
</select>
&nbsp;&nbsp;Select profit for low cost destinations ( X2 is ok for me )
</div><br/>

<div>
<input type="text" name="ajout" value="200"/>
&nbsp;&nbsp;All destinations over low cost price will have other formula and use only additional cost<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Take many care about format 1000 is 10 cents and 100 is 1 cents<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Just add extra cost here, my side I use : <strong>200</strong>, this does mean I make 2 cents profit / minut and is OK.<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
For callshop or resale use for example <strong>100</strong> to have a correct price.
</div><br/>

<div>
<input type="text" name="promo" value="850"/>
&nbsp;&nbsp;I have harcoded some destinations with a flat manual price, Mobile ( France / Spain )<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Take many care about format 1000 is 10 cents and 100 is 1 cents<br/> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Just add this promotional rate here, my side I use : <strong>850</strong>, this does mean I sale this two destinations this price.
</div><br/>

<input type="submit" name="Syncro" value="Syncro" />
</form>';

$link = mysql_connect($hosto, $dblog, $dbpass);

/////// Variables à ajuster /////

$change = '0.8';     //  change $ vers € exemple 0.8
$routage1='sip.voxbeam.com-:sip.sippath.co.uk-:sip.voxbeam.com-Standard:sip.sippath.co.uk-Eco';   // routage principale
$routage2='sip.sippath.co.uk-Eco:sip.sippath.co.uk-';   // routage secondaire



//////////////////////////////////////////Voxbeam-premium
if(!empty($_POST['update']) && !empty($_POST['multi']) && !empty($_POST['maxprice']) && !empty($_POST['ajout']))
	{
	$multi = $_POST['multi']; $pascher = $_POST['pascher']; $maxprice = $_POST['maxprice']; $ajout = $_POST['ajout']; $promo = $_POST['promo'];
	$lines = file('http://www.voxbeam.com/rates/premium.csv');
	//$lines= file('dl/premium.csv');
	$z = count($lines); $i = 1 ;
	#########################
	## DEPART DE LA BOUCLE ##
	#########################
	while($i < $z)
		{
		//on sépare les champs en utilisant le " comme séparateur
		$Cut=explode("\"", $lines[$i]);
		//on fait direct la conversion en euro
		$price = ceil($Cut[11] * $change * 10000);
		// On vire les apostrophes des noms de pays
		$comment = str_replace("'","", $Cut[1]);
		// correction de voxbeam parfois écrivent belgium a la place de belgium	
		if(preg_match("/^Belguim Mobile/i", $comment)){str_replace("Belguim","Belgium", $Cut[1]);}
		// si le prix est moins que la variable $maxprice on indique un routage
		if($price < $maxprice)
			{
			$trunks = $routage1;
			}
			else
			// trop cher on n'indique pas de routage donc pas d'appels possibles
			{
			$trunks='';
			// on ecrase le nom original de la destination par un not relayed
			$comment = $Cut[1].' Not Relayed';
			// et on le met a jour dans la DB
			mysql_query("UPDATE ".ASTCC.".routes SET comment='".$comment."' WHERE pattern='".$Cut[5]."'");
			}
		// On test si le nom de route existe
		$test= mysql_fetch_row( mysql_query("SELECT comment FROM ".ASTCC.".routes WHERE pattern='".$Cut[5]."'"));
			// si il existe
			if(!empty( $test[0]))
			{
			// une regle pour les destinations pas chere ou on fait du X2
			if($price < $pascher )
				{
				// quelques exeptions suivant ma politique commerciale France Espagne
				if (preg_match("/^France Mobile/i", $comment))
					{
					$cost = $promo;
					}
					elseif(preg_match("/^Spain Mobile/i", $comment))
					{
					$cost = $promo;
					}
				// le cas général on applique le multiplié
				else
					{
					$cost = (ceil(($price * $multi )/10)*10);
					}
				}
				// Cas des routes cheres on ajoute un cout
				else
				{
				// quelques exeptions suivant ma politique commerciale France Espagne
				if (preg_match("/^France Mobile/i", $comment))
					{
					$cost = $promo;
					}
				elseif(preg_match("/^Spain Mobile/i", $comment))
					{
					$cost = $promo;
					}
				else
					{
					$cost = (ceil(($price + $ajout )/10)*10);
					}
				}
			// affichage sur la page du résultat
			echo $test[0].' - update pattern existante '.$Cut[5].' Purchase: '.( $price / 10000).' Sale: '.( $cost / 10000).'<br/>';
			// on fait finalement la mise a jour dans la db
			mysql_query("UPDATE ".ASTCC.".routes SET trunks='".$trunks."',ek='".$price."',cost='".$cost."' WHERE pattern='".$Cut[5]."'");
			}
			else
			// on traite le cas ici d'un nouveau nom de route avec les mêmes regles
			{
			if($price < $pascher )
			{
				// quelques exeptions suivant ma politique commerciale France Espagne
				if (preg_match("/^France Mobile/i", $comment))
					{
					$cost = $promo;
					}
					elseif(preg_match("/^Spain Mobile/i", $comment))
					{
					$cost = $promo;
					}
				// le cas général on double le prix
				else
					{
					$cost = (ceil(($price * $multi )/10)*10);
					}
				}
				// Cas des routes cheres on ajoute un cout
				else
				{
				// quelques exeptions suivant ma politique commerciale France Espagne
				if (preg_match("/^France Mobile/i", $comment))
					{
					$cost = $promo;
					}
				elseif(preg_match("/^Spain Mobile/i", $comment))
					{
					$cost = $promo;
					}
				else
					{
					$cost = (ceil(($price + $ajout )/10)*10);
					}
				}
			// on affiche ce qu'on fait sur la page
			echo $test[0].' - New pattern '.$Cut[5].' Purchase: '.( $price / 10000).' Sale: '.( $cost / 10000).'<br/>';
			// et on ajoute la route dans la DB
			mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='".$Cut[5]."',comment='".$comment."',trunks='".$trunks."',
			ek='".$price."',cost='".$cost."'");
			}
		$i++;
	}
	##########################
	## LES CAS PARTICULIERS ##
	##########################
	
	// Le routage France de voxbeam est trop compliqué long et pas exact, on efface tout et on recommence :-)
	mysql_query("DELETE from ".ASTCC.".routes WHERE comment LIKE 'France%'");
	
	//on commence par les fixes de 331 à 335
	$i = 1;
	while ($i <= 5)
	{
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='33".$i."',comment='France fixe',trunks='".$routage1."', ek='52',cost='110'");
	$i++;
	}
	// Les mobiles
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='336',comment='France Mobile',trunks='".$routage1."', ek='317',cost='".$promo."'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='337',comment='France Mobile',trunks='".$routage1."', ek='317',cost='".$promo."'");
	// Les mobiles sat
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='33638',comment='France Globalstar',trunks='".$routage1."', ek='2804',cost='3010'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3364000',comment='France Globalstar',trunks='".$routage1."', ek='2804',cost='3010'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3364001',comment='France Globalstar',trunks='".$routage1."', ek='2804',cost='3010'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3364002',comment='France Globalstar',trunks='".$routage1."', ek='2804',cost='3010'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3364003',comment='France Globalstar',trunks='".$routage1."', ek='2804',cost='3010'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3364004',comment='France Globalstar',trunks='".$routage1."', ek='2804',cost='3010'");
	// Les numéros Speciaux normalement gratuits ou tarif local
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3380',comment='France Special',trunks='".$routage2."', ek='52',cost='110'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3381',comment='France Special',trunks='".$routage2."', ek='52',cost='150'");
	// Les Box
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='339',comment='France Box',trunks='".$routage2."', ek='52',cost='150'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3387',comment='France Box',trunks='".$routage2."', ek='52',cost='150'");
	// Les numéros surtaxés
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3382',comment='France Special',trunks='".$routage2."', ek='52',cost='1500'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3383664',comment='France Special',trunks='".$routage2."', ek='52',cost='1500'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3389064',comment='France Special',trunks='".$routage2."', ek='52',cost='1500'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='33884',comment='France Special',trunks='".$routage2."', ek='52',cost='1500'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='33890',comment='France Special',trunks='".$routage2."', ek='52',cost='1500'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3389071',comment='France Special',trunks='".$routage2."', ek='52',cost='1500'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='33891',comment='France Special',trunks='".$routage2."', ek='52',cost='3000'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='33892',comment='France Special',trunks='".$routage2."', ek='52',cost='3400'");
	
	// Le routage Espagne un peu de ménage aussi
	mysql_query("DELETE from ".ASTCC.".routes WHERE comment LIKE 'Spain Premium%'");
	mysql_query("DELETE from ".ASTCC.".routes WHERE comment LIKE 'Spain Special%'");
	mysql_query("DELETE from ".ASTCC.".routes WHERE comment LIKE 'Spain Mobile%'");
	//les mobiles
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='346',comment='Spain Mobile',trunks='".$routage1."', ek='480',cost='".$promo."'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='347',comment='Spain Mobile',trunks='".$routage1."', ek='700',cost='".$promo."'");
	// numéros spéciaux
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='34909',comment='Spain Special',trunks='".$routage2."', ek='70',cost='140'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='34901',comment='Spain Special',trunks='".$routage2."', ek='70',cost='160'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='34902',comment='Spain Special',trunks='".$routage2."', ek='70',cost='160'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='34908',comment='Spain Special',trunks='".$routage2."', ek='70',cost='160'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3470',comment='Spain Special not relayed',trunks='', ek='70',cost='160'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3490',comment='Spain Special not relayed',trunks='', ek='70',cost='160'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3451',comment='Spain Special not relayed',trunks='', ek='70',cost='160'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='3480',comment='Spain Special not relayed',trunks='', ek='70',cost='160'");
	mysql_query("INSERT INTO ".ASTCC.".routes SET pattern='34907',comment='Spain Special not relayed',trunks='', ek='70',cost='160'");
	}
mysql_close($link);

?>