<?php

function uts($date)
	{
	$date = str_replace(array(' ', ':'), '-', $date);
	$c    = explode('-', $date);
	$c    = array_pad($c, 6, 0);
	array_walk($c, 'intval');
	return mktime($c[3], $c[4], $c[5], $c[1], $c[2], $c[0]);
}

function WD_gpc_extract(&$array, &$target) {
    if (!is_array($array)) {
        return FALSE;
    }
    $is_magic_quotes = get_magic_quotes_gpc();
    foreach ((array)$array AS $key => $value) {
        if (is_array($value)) {
            WD_gpc_extract($value, $target[$key]);
            WD_gpc_extract($value, $array[$key]);
        } else if ($is_magic_quotes) {
            $target[$key] = stripslashes($value);
            $array[$key] = stripslashes($value);
        } else {
            $target[$key] = $value;
            $array[$key] = $value;
        }
    }
    return TRUE;
}

if (!empty($_GET)) {
    WD_gpc_extract($_GET, $GLOBALS);
} // end if

if (!empty($_POST)) {
    WD_gpc_extract($_POST, $GLOBALS);
} // end if

if (!empty($_SERVER)) {
    WD_gpc_extract($_SERVER, $GLOBALS);
} // end if

if (!empty($_COOKIE)) {
    WD_gpc_extract($_COOKIE, $GLOBALS);
} // end if

if (!empty($_FILES)) {
    WD_gpc_extract($_FILES, $GLOBALS);
} // end if

$_VARS = array_merge($_POST,$_GET,$_FILES);


function printFormText($title, $name, $value="", $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%"><input type="text" name="<?=$name?>" value="<?=htmlspecialchars($value)?>" <?=$parameter?>></td>
		</tr>
<?
}

function printFormTextToolTip($title, $name, $value="", $tooltiptext, $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%" onmouseover="return escape('<?=$tooltiptext?>')"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%"><input type="text" name="<?=$name?>" value="<?=htmlspecialchars($value)?>" <?=$parameter?>></td>
		</tr>
<?
}


function printFormPassword($title, $name, $value="", $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%"><input type="password" name="<?=$name?>" value="<?=htmlspecialchars($value)?>" <?=$parameter?>></td>
		</tr>
<?
}

function printFormDate($title, $name, $value="", $parameter="", $onerow=1) {
	if($value>0) 
		$value = strftime("%x %X",$value);
	else 
		$value = "";
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%"><input type="text" name="<?=$name?>" value="<?=$value?>" <?=$parameter?>></td>
		</tr>
<?
}

function printFormTextarea($title, $name, $value="", $rows = 5, $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%"><textarea name="<?=$name?>" class="txt" rows="<?=$rows?>" <?=$parameter?>><?=htmlspecialchars($value)?></textarea></td>
		</tr>
<?
}

function printFormSelect($title, $name, $values, $value=-1, $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%">
				<select name="<?=$name?>" <?=$parameter?>>
					<option value="" selected>Please select..</option> 
          <?
					foreach((array)$values as $key=>$val) {
						echo "<option value=\"".$val."\" ".(($key==$value)?"selected":"").">".$key."</option>";
					}
					?>
				</select>
			</td>
		</tr>
<? 
}

function printFormNumberpoolSelect($title, $name, $values, $value=-1, $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%">
				<select name="<?=$name?>" <?=$parameter?>>
          <?
					foreach((array)$values as $key=>$val) {
						echo "<option value=\"".$val['extnumber']."\" ".(($key==$value)?"selected":"").">".$val['extnumber']."</option>";
					}
					?>
				</select>
			</td>
		</tr>
<? 
}

function printFormNumberpoolSelectToolTip($title, $name, $values, $tooltiptext, $value=-1, $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"  onmouseover="return escape('<?=$tooltiptext?>')"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%">
				<select name="<?=$name?>" <?=$parameter?>>
          <?
					foreach((array)$values as $key=>$val) {
						echo "<option value=\"".$val['extnumber']."\" ".(($key==$value)?"selected":"").">".$val['extnumber']."</option>";
					}
					?>
				</select>
			</td>
		</tr>
<? 
}

function printFormSIPSelect($title, $name, $values, $value=-1, $parameter="", $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%">
				<select name="<?=$name?>" <?=$parameter?>>
					<option value="" selected>Please select..</option> 
          <?
					foreach((array)$values as $key=>$val) {
						echo "<option value=\"".$val['account']."\" ".(($key==$value)?"selected":"").">".$val['account']."</option>";
					}
					?>
				</select>
			</td>
		</tr>
<? 
}


function printFormCheckbox($title, $name, $value="1", $checked=false, $onerow=1) {
?>
		<tr>
			<th class="txt" width="40%"><?=$title?></th>
		<? if($onerow==0) { ?>
		</tr>
		<tr>
		<? } ?>
			<td width="60%"><input type="checkbox" name="<?=$name?>" value="<?=htmlspecialchars($value)?>" <?=(($checked)?"checked":"")?>></td>
		</tr>
<?
}

# Check E-Mail.
function check_email_mx($email) { 
   	if( (preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $email)) || 
   		(preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/',$email)) ) { 
   		$host = explode('@', $email);
   		if(checkdnsrr($host[1].'.', 'MX') ) return true;
   		if(checkdnsrr($host[1].'.', 'A') ) return true;
   		if(checkdnsrr($host[1].'.', 'CNAME') ) return true;
   	}
   	return false;
}

# Check input of user
function checkrequiredValuescontact($field) {
  $errorcodes=array();
  if(strlen($field['input_webuser'])<2) {
	  $errorcodes['username']=1;
	}
  if(strlen($field['input_webpw'])<2) {
	  $errorcodes['password']=1;
	}
  if(strlen($field['input_webpw2'])<2) {
	  $errorcodes['password']=1;
	}
  if ($field['input_webpw'] <> $field['input_webpw2'])  {
    $errorcodes['missmatch'] = 1;
  }
  if(strlen($field['input_vorname'])<2) {
	  $errorcodes['vorname']=1;
	}
	if(strlen($field['input_nachname'])<2) {
		$errorcodes['nachname']=1;
	}
	return $errorcodes;
}

function checkContactFrm($field) {
  $errorcodes=array();
  if(strlen($field['input_vorname'])<2) {
	  $errorcodes['vorname']=1;
	}
	if(strlen($field['input_nachname'])<2) {
		$errorcodes['nachname']=1;
	}
	if(!check_email_mx($field['input_email'])) {
		$errorcodes['email']=1;
	}
	return $errorcodes;
}

function checkrequiredValuesAdmin($field) {
  $errorcodes=array();
  if(strlen($field['input_webuser'])<2) {
	  $errorcodes['username']=1;
	}
  if(strlen($field['input_webpw'])<2) {
	  $errorcodes['password']=1;
	}
  if(strlen($field['input_webpw2'])<2) {
	  $errorcodes['password']=1;
	}
  if ($field['input_webpw'] <> $field['input_webpw2'])  {
    $errorcodes['missmatch'] = 1;
  }
	return $errorcodes;
}

# Languagechooser
function translate($sKey)
{
	global $dictionary;
    if(!isset($dictionary[$sKey]))
	{
      global $sLanguage;
      if(ERROR_DEBUG) echo "No translation found for '$sKey', language=$sLanguage, file=".getenv("SCRIPT_FILENAME");
      else echo "No translation found for: '$key', language=$language, file=".getenv("SCRIPT_FILENAME");
      return "";
    }
    return $dictionary[$sKey];
}

function set_default(&$arg, $default_value)
{
	if(strlen($arg)>0) return true;
    $arg=$default_value;
    return false;
}

# Send contact form
function requestmail($data)  {
  if($data['input_contact']==1)
  {
      $wish=translate("byemail");
  }
  else{
      $wish=translate("byphone");
  }
      
  $mailnachricht=$data["input_vorname"]. " ". $data["input_nachname"]."\n";
  $mailnachricht.=$data["input_strasse"]. "\n";
  $mailnachricht.=$data["input_land"]. $data["input_plz"]. " ". $data["input_ort"]. "\n\n";
  $mailnachricht.="Phone: ". $data["input_telefon"]. "\n". "Fax: ". $data["input_fax"]."\nE-Mail: ". $data["input_email"]. "\n\n";
  $mailnachricht.="--------------------\n";
  $mailnachricht.="Feedback (VoIP.comdif.com):\n\n";
  $mailnachricht.=$data["input_text"]. "\n";
  $mailnachricht.="--------------------\n\n";
  $mailnachricht.= translate("pleasecontactme") . ": " . $wish."\n\n";
  $mailbetreff= FIRMENNAME . " VoIP.comdif.com Feedback-Form";
  mail(EMAIL, $mailbetreff, $mailnachricht, "From:" . $data['input_email']);      
}

function clean($chaine) {
   $accents = array('À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ', '\'', ' ');
   $sans = array('A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','-', '_');
   return str_replace($accents, $sans, $chaine);
}

function grosnul($chaine) {
   $accents = array('À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ', '\'', ' ');
   $sans = array('A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','-', '');
   return str_replace($accents, $sans, $chaine);
}

function Tarif($read) {
$badi = array('À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö',
   'Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï',
   'ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ','a','b','c','d','e','f','g','h',
   'i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B',
   'C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V',
   'W','X','Y','Z','€','$','%','^','/','\\','!','?','£','*','+','-','&','#','(',')',
   '{','}','"','\'','~','[',']','|','`','@','°','¤','¨',' ',',');
$goodi = array('','','','','','','','','','','','','','','','','','','','',
'','','','','','','','','','','','','','','','','','','','',
'','','','','','','','','','','','','','','','','','','','',
'','','','','','','','','','','','','','','','','','','','',
'','','','','','','','','','','','','','','','','','','','',
'','','','','','','','','','','','','','','','','','','','',
'','','','','','','','','','','','','','','.');
   return str_replace($badi, $goodi, $read);
}

function cleany($string) {
    return 
	preg_replace( array('#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'), array('-', ''), urldecode($string) );
}
	
function mysqli_result($result,$row,$field=0)
	{
    if ($result===false) return false;
    if ($row>=mysqli_num_rows($result)) return false;
    if (is_string($field) && !(strpos($field,".")===false))
		{
        $t_field=explode(".",$field);
        $field=-1;
        $t_fields=mysqli_fetch_fields($result);
        for ($id=0;$id<mysqli_num_fields($result);$id++)
			{
            if ($t_fields[$id]->table==$t_field[0] && $t_fields[$id]->name==$t_field[1])
				{
                $field=$id; break;
            	}
        	}
        if ($field==-1) return false;
    	}
	mysqli_data_seek($result,$row);
	$line=mysqli_fetch_array($result);
	return isset($line[$field])?$line[$field]:false;
	}

// Arrondi après la virgule
function arrondi($number, $nextComma, $option)
{
	$number = str_replace(",", ".", $number);
	
	$int  = strtok($number, '.'); // Partie entière
	
	if(strlen($number) == strlen($int)) // Si le nombre est entier sans décimal
	{
		$number .= ".";	// On rajoute un "."
		$nbZeroToAdd = $nextComma;	// Le nombre de zéro à ajouter
	}
	else
	{
		$lengthNumber = strlen($number) - 1; // Longueur du nombre moins le "."

		$restLength = $lengthNumber - strlen($int); // Longueur du reste

		$rest1 = $number * pow(10, $restLength); 
		$rest = $rest1 % pow(10, $restLength);
	}


	if($restLength < $nextComma)
	{
		$nbZeroToAdd = $nextComma - $restLength;	// Nombre de zéro à rajouter

		if( ( ($rest % 10) == 0 ) && ($rest != 0) )	// Si le dernier chiffre du reste est un zéro
		{
			$nbZeroToAdd++;	// On ajoute un zéro
		}

		for($i=0; $i<$nbZeroToAdd; $i++)	// On ajoute le nombre de zéro
		{
			$number .= "0";
		}
	}
	else if($restLength > $nextComma)
	{
		$nbToDel = $restLength - $nextComma;	// Nombre de chiffre à enlever
		$newDec = $rest / pow(10, $nbToDel);

		if(strcmp($option, "sup") == 0)	// Si l'option vaut sup
		{
			$newDec = ceil($newDec);
			//echo "sup".$newDec;
		}
		else if(strcmp($option, "inf") == 0)	// Si l'option vaut inf
		{
			$newDec = floor($newDec);
		}
		else
		{
			$newDec = round($newDec);
		}

		if(intVal($newDec / 10) == 0)
		{
			$newDec = "0".$newDec;
		}
		
		$newDecLength = strlen($newDec);
		
		$newDec = "0.".$newDec;
		
		if($newDecLength > $nextComma)
		{
			$newDec *= 10;
		}
		else if( strlen($newDec) < $nextComma )	// Si le dernier chiffre du reste est un zéro
		{
			$newDec .= "0";
		}
		
		for($i=0; $i<1; $i++)
		{
			$number = arrondi($int + $newDec, $nextComma, $option);
		}
	}

	return $number;
}


?>
