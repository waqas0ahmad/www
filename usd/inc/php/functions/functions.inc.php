<?php

/* work with POST and GET */

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
  $mailbetreff= FIRMENNAME . " Comdif.com Feedback";
  mail(EMAIL, $mailbetreff, $mailnachricht, "From:" . $data['input_email']);      
}
?>
