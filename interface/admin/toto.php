<?

// Arrondi apr�s la virgule
function arrondi($number, $nextComma, $option)
{
	$number = str_replace(",", ".", $number);
	
	$int  = strtok($number, '.'); // Partie enti�re
	
	if(strlen($number) == strlen($int)) // Si le nombre est entier sans d�cimal
	{
		$number .= ".";	// On rajoute un "."
		$nbZeroToAdd = $nextComma;	// Le nombre de z�ro � ajouter
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
		$nbZeroToAdd = $nextComma - $restLength;	// Nombre de z�ro � rajouter

		if( ( ($rest % 10) == 0 ) && ($rest != 0) )	// Si le dernier chiffre du reste est un z�ro
		{
			$nbZeroToAdd++;	// On ajoute un z�ro
		}

		for($i=0; $i<$nbZeroToAdd; $i++)	// On ajoute le nombre de z�ro
		{
			$number .= "0";
		}
	}
	else if($restLength > $nextComma)
	{
		$nbToDel = $restLength - $nextComma;	// Nombre de chiffre � enlever
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
		else if( strlen($newDec) < $nextComma )	// Si le dernier chiffre du reste est un z�ro
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



if(!empty($_GET['bb']))
{
echo arrondi($_GET['bb'],2,'sup');
}
?>
<form method="GET" action"toto.php">
<input type="text" name="bb" />
<input type="submit" />
</form>


