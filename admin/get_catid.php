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
chdir('./../');
define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));
define('IS_ADMIN', 1);
include_once(CWD . "/global.php") ;

if (check_login_cookies()) {

if($global_lang=="arabic"){
$global_dir = "rtl" ;
print "<html dir=$global_dir>
<META http-equiv=Content-Type content=\"text/html; charset=windows-1256\">" ;
}else{
$global_dir = "ltr" ;
print "<html>
<META http-equiv=Content-Type content=\"text/html; charset=windows-1252\"> " ;
}
print "
<title>$phrases[cats_list]</title>
<LINK href='smiletag-admin.css' type=text/css rel=StyleSheet>";

$cat=intval($cat);
if(!$cat){$cat=0;}


$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from news_cats where id=$dir_data[cat]");

        $dir_content = "<a href='get_catid.php?cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
  //------------------------------------------
    print "<br><p align=right><img src='images/link.gif'><a href='get_catid.php?cat=0'>$phrases[main_page] </a> / $dir_content</p>";

    $qr = db_query("select * from news_cats where cat='$cat' order by id");


if(db_num($qr)){
 print "<center>
            <table width=90% class=grid><tr><td>";

         while($data = db_fetch($qr)){
      print "<li><a href='get_catid.php?cat=$data[id]'>$data[name]</a></li>
     ";
         }
    print "</td></tr></table></center>";

    }else{
            print "<center>
            <table width=70% class=grid><tr><td align=center>$phrases[no_subcats]</td></tr></table></center>";
            }

if($cat > 0){
print "<center><br><table width=80% class=grid><tr><td align=center>
<input type=submit value='$phrases[select_this_cat]' onClick=\"opener.sender.elements['cat_to'].value='$cat';window.close();\"></td></tr></table></center>";
}

}

