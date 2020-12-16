<html>
<head>
  <title>Thanks!</title>
</head>
<body>
  <p>
    We appreciate your business!
    <br>
    <a href="/">Home</a>
  </p>
</body>

</html>

<?php
require_once "./dbadmin.php";
$db = new mysqli($hostconf, $loginconf, $passwordconf, $dbadminconf);
$amount_received =floatval($_GET["amt"]);
$uid = $_GET["uid"];
$exists = $db->query("select * from waqastestdb.stripe_payment where UniqueId = '" . $_GET["sid"] . "' and ifnull(status,0)=1");

if ($exists->num_rows > 0) {
  header("Location: /");
  //do something ... 
} else {
  $db->query("update waqastestdb.stripe_payment set amount_received='" . $amount_received . "',currency='EUR',status='1' where UniqueId = '" . $_GET["sid"] . "';");
  $res = $db->query("select userid from waqastestdb.stripe_payment where UniqueId = '" . $_GET["sid"] . "' limit 1 ; ");
  if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $db->query("update admin.custom set  soldettc=soldettc+" . ($amount_received * 10000) . " where user='" . $row["userid"] . "';");
    $db->query("insert into admin.prepaid(client,date,montant,reason,paid) values('" . $row["userid"] . "',now()," . ($amount_received * 10000) . ",'CB recharge','oui');");
  }
}
?>