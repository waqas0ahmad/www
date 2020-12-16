<?php
# Check if this script is not started via browser!
if ($REMOTE_ADDR <> "") { 
    echo "Denied from browser!";
    exit;
}

# Cron started from /etc/crontab entry every hour
$back=`logger -t VoIPonCDcron started.`;

# Get all the variables
require("systemconfig.inc.php");
require("constants.inc.php");

# Daily CDR Mails
 if (strstr(CDRMAIL, "@") && (date(H) == "00")) {
    $cdrlink=mysql_connect(HOST, DBUSER, DBPASSWORD) or die("Could not connect to database for cron\n");
    $cdryesterday=date("Y-m-d", time()-86400);
    $cdrresult=mysql_query("select * from asterisk.cdr where calldate > '$cdryesterday'") or die ("Select error in cron");
    $fcdr=fopen("/tmp/cdrmail.csv", "w");
    fputs($fcdr, "id;calldate;clid;src;dst;duration;billsec;disposition;accountcode\r\n");
    while(@extract(mysql_fetch_array($cdrresult))) {
        fputs($fcdr, "$id;$calldate;$clid;$src;$dst;$duration;$billsec;$disposition;$accountcode\r\n");
    }
    mysql_close($cdrlink);
    fclose($fcdr);
    $cdrmail=CDRMAIL;
    $back=`uuencode /tmp/cdrmail.csv cdrmail.csv | mail -s "daily CDRs" $cdrmail`;
    unlink("/tmp/cdrmail.csv");
}
?>
