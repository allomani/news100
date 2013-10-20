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
include "global.php";
print "<html dir=$settings[html_dir]>";
print "<title> $phrases[send2friend] </title>";
print "<LINK href='style.css' type=text/css rel=StyleSheet>";

open_table("$phrases[send2friend]");
if($name_from && $email_from && $email_to){

if(trim($script_path)){$script_path="$script_path/";}

$url = "http://$_SERVER[SERVER_NAME]/".$script_path."news-$id.html"  ;


$data = db_qr_fetch("select title  from news_news where id='$id'");

     $file_title = "$data[title]" ;

$data = get_template("friend_msg");



$data = str_replace("{name_from}",$name_from,$data);
$data = str_replace("{email_from}",$email_from,$data);
$data = str_replace("{name_to}",$name_to,$data);
$data = str_replace("{url}",$url,$data);
$data = str_replace("{title}",$file_title,$data);

send_email($name_from,$email_from,$email_to,"$phrases[send2friend_subject] $name_from",$data,1);


print "<center>  $phrases[send2friend_done] </center>";

}else{
$op =  strip_tags($op);
$id = intval($id);

print "
<form action='send2friend.php' method=post>
<input type=hidden name=id value='$id'>";

       $data = db_qr_fetch("select title from news_news where id='$id'");

     print "<p align=center class=title>$data[title]</p>" ;


print "<table width=100%>
<tr><td >
$phrases[your_name] : </td>
<td><input type=text name=name_from value='$name_from'></td></tr>

<tr><td>
$phrases[your_email] : </td>
<td><input type=text name=email_from value='$email_from' dir=ltr></td></tr>

<tr><td>
$phrases[your_friend_email] : </td>
<td><input type=text name=email_to value='$email_to' dir=ltr></td></tr>
<td><td colspan=2 align=center><input type=submit value='$phrases[send]'></td></tr>
</table></form>";
}
close_table();
?>