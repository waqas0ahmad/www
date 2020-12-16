<?
function datediff($interval, $date1, $date2) {
   // Function roughly equivalent to the ASP "DateDiff" function
   $seconds = $date2 - $date1;
   
   switch($interval) {
       case "y":
           list($year1, $month1, $day1) = split('-', date('Y-m-d', $date1));
           list($year2, $month2, $day2) = split('-', date('Y-m-d', $date2));
           $time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
           $time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
           $diff = $year2 - $year1;
           if($month1 > $month2) {
               $diff -= 1;
           } elseif($month1 == $month2) {
               if($day1 > $day2) {
                   $diff -= 1;
               } elseif($day1 == $day2) {
                   if($time1 > $time2) {
                       $diff -= 1;
                   }
               }
           }
           break;
       case "m":
           list($year1, $month1, $day1) = split('-', date('Y-m-d', $date1));
           list($year2, $month2, $day2) = split('-', date('Y-m-d', $date2));
           $time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
           $time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
           $diff = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
           if($day1 > $day2) {
               $diff -= 1;
           } elseif($day1 == $day2) {
               if($time1 > $time2) {
                   $diff -= 1;
               }
           }
           break;
       case "w":
           // Only simple seconds calculation needed from here on
           $diff = floor($seconds / 604800);
           break;
       case "d":
           $diff = floor($seconds / 86400);
           break;
       case "h":
           $diff = floor($seconds / 3600);
           break;        
       case "i":
           $diff = floor($seconds / 60);
           break;        
       case "s":
           $diff = $seconds;
           break;        
   }    
   return $diff;
}
function daysinmonth($month, $year)
   {
       if(checkdate($month, 31, $year)) return 31;
       if(checkdate($month, 30, $year)) return 30;
       if(checkdate($month, 29, $year)) return 29;
       if(checkdate($month, 28, $year)) return 28;
       return 0; // error
   }
function sec2hms ($sec, $padHours = false) 
  {

    // holds formatted string
    $hms = "";
    
    // there are 3600 seconds in an hour, so if we
    // divide total seconds by 3600 and throw away
    // the remainder, we've got the number of hours
    $hours = intval(intval($sec) / 3600); 

    // add to $hms, with a leading 0 if asked for
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). 'h:'
          : $hours. 'h:';
     
    // dividing the total seconds by 60 will give us
    // the number of minutes, but we're interested in 
    // minutes past the hour: to get that, we need to 
    // divide by 60 again and keep the remainder
    $minutes = intval(($sec / 60) % 60); 

    // then add to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). 'm:';

    // seconds are simple - just divide the total
    // seconds by 60 and keep the remainder
    $seconds = intval($sec % 60); 

    // add to $hms, again with a leading 0 if needed
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT).'s';

    // done!
    return $hms;
    
  }
?>
