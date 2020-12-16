<?
require('header.php');

echo'<table align="center" border="0"><tr>
	<td>';
//	include ("calendar.php");
echo'<td width="50%" >';

echo'<form action="'.$_SERVER['PHP_SELF'].'" method="post">
	<select name="per">
		<option value=""></option>
			<option value="day">Current day</option>
				<option value="day">Current day</option>
					<option value="yest">Yesterday</option>
						</select> Select date<br/>

<select name="desti">
	<option value=""></option>
		<option value="France">France</option>
			<option value="France mobil">France mobile</option>
				<option value="Morocco">Morocco</option>
					<option value="Morocco mobil">Morocco mobile</option>
						<option value="Tunisia">Tunisia</option>
							<option value="Tunisia mobil">Tunisia mobile</option>
								<option value="Algeria">Algeria</option>
									<option value="Algeria mobil">Algeria mobiles</option>
										<option value="Spain">Spain</option>
											<option value="Spain - Mobil">Spain - Mobile</option>
</select> Selectionnez une destination
<br /><input type="text" name="destit" /> Ou entrez un extrait de nom
<input type="submit" /></form>
<td><tr>
<a href="lnk.php">filtre</a>
</td></tr></table>';


if(!empty($_POST['desti']) || !empty($_POST['destit']))
	{
	if(!empty($_POST['desti']) && !empty($_POST['destit'])){ echo'Utilisez soit le select soit le champ texte'; exit;}
	if(empty($_POST['desti']) && !empty($_POST['destit'])){ $_POST['desti'] = $_POST['destit'];}	

// if current month or day is requested
if(!empty($_POST["per"]))
	{
	if( $_POST["per"] == month )
		{
		$curd = date("Y-m");
		echo'<div align="center" style="background-color:#58ACFA;width:700;"><strong>Month: '.$curd.'</strong></div><br>';
		}
	elseif( $_POST["per"] == day )
		{
		$curd = date("Y-m-d");
		echo'<div align="center" style="background-color:#58ACFA;width:700;"><strong>Day: '.$curd.'</strong></div><br>';
		}
	elseif( $_POST["per"] == yest )
		{
		$curd = date("Y-m-d", time()-86400);
		echo'<div align="center" style="background-color:#58ACFA;width:700;"><strong>Day: '.$curd.'</strong></div><br>';
		}
	
	$where = "datecall LIKE '".$curd."%'";
	}



	$data = mysqli_fetch_array(mysqli_query($ladmin,"SELECT SUM(opcost) AS opcost, SUM(normalcost) AS normalcost, SUM(billseconds) AS time 
	FROM admin.cdrs WHERE ".$where." AND comment LIKE '".$_POST['desti']."%' "));
	$count = mysqli_fetch_row(mysqli_query($ladmin,"SELECT COUNT(*) FROM admin.cdrs WHERE ".$where." AND comment LIKE '".$_POST['desti']."%' "));
	$countgr = mysqli_fetch_row(mysqli_query($ladmin,"SELECT COUNT(*) FROM admin.cdrs WHERE billseconds <= '14' AND ".$where." AND comment LIKE '".$_POST['desti']."%' "));
	
	$reste1=((($data['time']/60)*10) % 10); $reste2=((($data['time']/60)*100) % 10); $reste= ''.$reste1.''.$reste2.'';
	$secondes= round((($reste / 100) * 60 ),0);
	if(($count[0]) == 0)
		{
		$durbrut = 0;
		}
	else
		{
		$durbrut= (($data['time'])/($count[0]));
		}
	$du1=((($durbrut/60)*10) % 10); 
	$du2=((($durbrut/60)*100) % 10); 
	$du= ''.$du1.''.$du2.'';
	$dusec= round((($du / 100) * 60 ),0);
	echo '<br/><strong>Destination: '.$_POST['desti'].'</strong><br />';
	echo 'Facturé: '.($data['opcost'] /10000).' &euro;';
	echo'<br/>Normalement facturable: '.($data['normalcost'] / 10000).' &euro;';
	echo '<br/>Offert inferieur au pallier : '.round((($data['normalcost'] / 10000)-($data['opcost'] /10000)),2).' &euro;';
	echo'<br/>Nombre appels: '.$count[0].'';
	echo'<br/>Minutes: '.round(($data['time']/60),0).':'.$secondes;
	echo'<br/>Durée moyenne: '.round(($durbrut/60),0).':'.$dusec;
	if(($count[0]) == 0)
		{
		echo'<br/>Facturation moyenne par appel: 0 &euro;';
		}
	else
		{
		echo'<br/>Facturation moyenne par appel: '.round((($data['opcost'] /10000) / ($count[0])),2).' &euro;';
		}
	echo'<br/>Nombre appels non facturés inférieurs au pallier: '.$countgr[0].'';
	echo'<br/>Nombre appels facturés : '.( $count[0] - $countgr[0]).'';
	if(($count[0]) == 0)
		{
		echo'<br/>Pourcentage facturés: 0 %';
		}
	else
		{
		echo'<br/>Pourcentage facturés: '.round(((($count[0] - $countgr[0])/ $count[0])*100),1).' %';
		}
	}
	
require('footer.php');
?>