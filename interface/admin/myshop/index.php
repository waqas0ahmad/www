<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Myshop</title>
</head>
<? unset($newval); $_GET['reftime']= rand(100,10000000);?>
<frameset rows="65,35" frameborder="no" border="0" framespacing="0" >
  <frame src="sale.php?refo=<?=$_GET['reftime']?>" name="sale" scrolling="auto" id="sale" />
  <frame src="ticket.php" name="tic" scrolling="auto" id="tic" />
</frameset>
<noframes><body>
</body>
</noframes></html>
