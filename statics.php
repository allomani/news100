<?
/**
 *  Allomani News v1.0
 * 
 * @package Allomani.News
 * @version 1.0
 * @copyright (c) 2006-2013 Allomani , All rights reserved.
 * @author Ali Allomani <info@allomani.com>
 * @link http://allomani.com
 * @license GNU General Public License version 3.0 (GPLv3)
 * 
 */
$year = intval($year);
$month = intval($month);

open_table("√‰Ÿ„… «· ‘€Ì·");
get_info("select * from info_os where count > 0 order by count DESC","name","count");
close_table();

open_table("«·„ ’›Õ« ");
get_info("select * from info_browser where count > 0 order by count DESC","name","count");
close_table();

if (!$year){$year = date("Y");}

open_table("≈Õ’«∆Ì«  «·“Ê«— «·‘Â—Ì… ·⁄«„ $year ");

for ($i=1;$i <= 12;$i++){

$dot = $year;

if($i < 10){$x="0$i";}else{$x=$i;}


$sql = "select * from info_hits where date like '%-$x-$dot' order by date" ;
$qr_stat=mysql_query($sql);
// print "select * from info_hits where date like '%-$x-$dot' order by date"  ;

if (mysql_num_rows($qr_stat)){
$total = 0 ;
while($data_stat=mysql_fetch_array($qr_stat)){
$total = $total + $data_stat['hits'];
}

$rx[$i-1]=$total  ;

}else{
        $rx[$i-1]=0 ;
        }

  }

    for ($i=0;$i <= 11;$i++){
    $total_all = $total_all + $rx[$i];
         }

         if ($total_all !==0){

         print "<br>";

  $l_size = getimagesize("images/leftbar.gif");
    $m_size = getimagesize("images/mainbar.gif");
    $r_size = getimagesize("images/rightbar.gif");


 echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\">";
 for ($i=1;$i <= 12;$i++)  {

    $rs[0] = $rx[$i-1];
    $rs[1] =  substr(100 * $rx[$i-1] / $total_all, 0, 5);
    $title = $i;

    echo "<tr><td>";



   print " $title:</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\">";
    print "<img src=\"images/mainbar.gif\"  height=\"$m_size[1]\" width=". $rs[1] * 2 ."><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$l_size[0]\">
    </td><td>
    $rs[1] % ($rs[0])</td>
    </tr>\n";

}
print "</table>";
 }else{
        print "·« ‰ «∆Ã" ;
        }
  print "<br><center>[ ‰ «∆Ã ⁄«„ : ";
 $yl = date('Y') - 3 ;
  while($yl != date('Y')+1){
      print "<a href='index.php?action=statics&year=$yl'>$yl</a> ";
      $yl++;
      }
  print "]";
close_table();

if (!$month){
        $month =  date("m")."-$year" ;
        }else{
                $month= "$month-$year";
                }

open_table("≈Õ’«∆Ì«  «·“Ê«— «·ÌÊ„Ì… ·‘Â— $month ");
$dot = $month;
get_info("select * from info_hits where date like '%$dot' order by date","date","hits");

print "<br><center>
          [ ‰ «∆Ã ‘Â— :
          <a href='$PHP_SELF?action=statics&year=$year&month=1'>1</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=2'>2</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=3'>3</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=4'>4</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=5'>5</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=6'>6</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=7'>7</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=8'>8</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=9'>9</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=10'>10</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=11'>11</a> -
          <a href='$PHP_SELF?action=statics&year=$year&month=12'>12</a>
          ]";
          close_table();


function get_info($sql,$count_name,$count_data){

global $if_img,$year ;

 $qr_stat=mysql_query($sql);
if (mysql_num_rows($qr_stat)){
while($data_stat=mysql_fetch_array($qr_stat)){
$total = $total + $data_stat[$count_data];
}


         print "<br>";

  $l_size = getimagesize("images/leftbar.gif");
    $m_size = getimagesize("images/mainbar.gif");
    $r_size = getimagesize("images/rightbar.gif");

$qr_stat=mysql_query($sql);
 echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\">";
while($data_stat=mysql_fetch_array($qr_stat)){

    $rs[0] = $data_stat[$count_data];
    $rs[1] =  substr(100 * $data_stat[$count_data] / $total, 0, 5);
    $title = $data_stat[$count_name];

    echo "<tr><td>";
    if ($if_img){
            print "<img src=\"images/flags/$data_stat[code].jpg\" border=\"0\" alt=\"\">";}


   print " $title:</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\">";
    print "<img src=\"images/mainbar.gif\"  height=\"$m_size[1]\" width=". $rs[1] * 2 ."><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$l_size[0]\">
    </td><td>
    $rs[1] % ($rs[0])</td>
    </tr>\n";

}
print "</table>";
}else{
        print "·« ‰ «∆Ã" ;
        }



        }
?>