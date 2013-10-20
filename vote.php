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
include "global.php" ;

$action = strip_tags("news");

$cookie_name = "news_vote_".$action."_".$id."_added";

//---------------- set vote expire ------------------------
if($vote_num && $action && $id){
if(!$settings['vote_file_expire_hours']){$settings['vote_file_expire_hours'] = 24 ; }

   if(!$HTTP_COOKIE_VARS[$cookie_name]){
  setcookie($cookie_name, "1" , time() + ($settings['vote_file_expire_hours'] * 60 * 60),"/");
  }
        }
//----------------------------------------------------------



print "<html dir=$settings[html_dir]>";

print "<LINK href='style.css' type=text/css rel=StyleSheet>";


print "<title> $phrases[vote_news] </title>";
open_table("$phrases[vote_news]");

if($vote_num && $action && $id){

$vote_num = intval($vote_num);
$id = intval($id) ;

 if(!$HTTP_COOKIE_VARS[$cookie_name]){

  db_query("update news_news set votes=votes+$vote_num , votes_total=votes_total+1 where id='$id'");
     print "<center>    $phrases[vote_news_thnx_msg]   </center>";



      }else{
                   print "<center>".str_replace('{vote_expire_hours}',$settings['vote_file_expire_hours'],$phrases['err_vote_expire_hours'])."</center>" ;
                     }
        }else{

                print "
<form action='vote.php' method=post>
<input type=hidden name=id value='$id'>
<input type=hidden name=action value='$action'>
<center>
<table width=50%>
<tr><td width=30%>
$phrases[vote_select] : </td>
<td>
<select name=vote_num>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
</select>
</td>
<td><input type=submit value='$phrases[vote_do]'></td>
</tr>

</table></form>";
}
close_table();