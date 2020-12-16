<form action="#SELF" method="get">
<input name="number" type="text" size="20" maxlength="20" />
<input type="submit" />
</form>
<?
if (!empty($_GET['number']))
{
$number = $_GET['number'];

if (substr( $number , -2, 1) % 2 == 0)
	{
	$final = ''.(($number % 10) + 1).'';
	echo $final;
	}
	elseif ((substr( $number , -2, 1)) % 2 != 0)
	{

		if 	((($number % 10) + 1) == 10)
			{
			$final = 20;
			}
			else
			{
			$final = '1'.(($number % 10) + 1).'';
			}
			echo $final;
	}
}	
?>