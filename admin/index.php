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
$is_admin =1 ;

include_once(CWD . "/global.php") ;



//----------- Login Script ----------------------------------------------------------
if ($action == "login" && $username && $password ){
     $result=db_query("select * from news_user where username='$username'");
     if(mysql_num_rows($result)){
     $login_data=db_fetch($result);


       if($login_data['password']==$password){

       setcookie('news_id', $login_data['id'], time() + (60 * 60 * 24 * 30),"/");
       setcookie('news_username', $login_data['username'], time() + (60 * 60 * 24 * 30),"/");
        setcookie('news_password', md5($login_data['password']), time() + (60 * 60 * 24 * 30),"/");

      setcookie('news_group_id', $login_data['group_id'], time() + (60 * 60 * 24 * 30),"/");

     print "<SCRIPT>window.location=\"index.php\";</script>";
      exit();
       }else{
              print "<link href=\"smiletag-admin.css\" type=text/css rel=stylesheet>\n";
              print "<br><center><table width=60% class=grid><tr><td align=center> $phrases[err_wrong_password] </td></tr></table></center>";

              }
            }else{
                 print " <link href=\"smiletag-admin.css\" type=text/css rel=stylesheet>    \n";
                    print "<br><center><table width=60% class=grid><tr><td align=center>  $phrases[err_wrong_username]  </td></tr></table></center>";

                    }
              }elseif($action == "logout"){
                    setcookie('news_id', "", time() + (60 * 60 * 24 * 30),"/");
                    setcookie('news_username', "", time() + (60 * 60 * 24 * 30),"/");
                    setcookie('news_password', "", time() + (60 * 60 * 24 * 30),"/");


                  print "<SCRIPT>window.location=\"index.php\";</script>";

                      }
//-------------------------------------------------------------------------------------------

if (check_login_cookies()) {


//--------------------------- Backup Job ------------------------------
if($action=="backup_db_do"){
if(!$disable_backup){
if_admin();
require_once 'mysql_db_backup.class.php';
$backup_obj = new MySQL_DB_Backup();
$backup_obj->server = $db_host ;
$backup_obj->port = 3306;
$backup_obj->username = $db_username;
$backup_obj->password = $db_password;
$backup_obj->database = $db_name;
$backup_obj->drop_tables = true;
$backup_obj->create_tables = true;
$backup_obj->struct_only = false;
$backup_obj->locks = true;
$backup_obj->comments = true;
$backup_obj->fname_format = 'm-d-Y-h-i-s';
$backup_obj->null_values = array( '0000-00-00', '00:00:00', '0000-00-00 00:00:00');
if($op=="local"){
$task = MSX_DOWNLOAD;
$backup_obj->backup_dir = 'uploads/';
$filename = "news_".date('m-d-Y_h-i-s').".sql.gz";
}elseif($op=="server"){
$task = MSX_SAVE ;
}
$use_gzip = true;
$result_bk = $backup_obj->Execute($task, $filename, $use_gzip);
    if (!$result_bk)
        {
                 $output = $backup_obj->error;
        }
        else
        {
                $output = "$phrases[process_done]";

        }
        }else{
        $output =  $disable_backup ;
                }
}

//---------------------------------------------------

include CWD."/".$editor_path."/editor_init_functions.php" ;

editor_init();
if($global_lang=="arabic"){
$global_dir = "rtl" ;
print "<html dir=$global_dir>
<META http-equiv=Content-Type content=\"text/html; charset=windows-1256\">
<title>$sitename - ·ÊÕ… «· Õﬂ„ </title>" ;
}else{
$global_dir = "ltr" ;
print "<html>
<META http-equiv=Content-Type content=\"text/html; charset=windows-1252\"> 
<title>$sitename - Control Panel </title>" ;
}
?>
<link href="smiletag-admin.css" type=text/css rel=stylesheet>
<script src='js.js' type="text/javascript" language="javascript"></script>
<?
editor_html_init();

if(file_exists(CWD . "/install/")){
print "<div style=\"border:1px solid;color: #D8000C;background-color: #FFBABA;padding:3px;text-align:center;margin:0;\">Installation folder exists at /install , Please delete it</div>";
}
        
if($license_properties['expire']['value'] && $license_properties['expire']['value'] != "0000-00-00"){
    $remaining_days = floor((strtotime($license_properties['expire']['value']) - time()) / (24*60*60));
    print "<div style=\"border:1px solid;color: #9F6000;background-color: #F9F0B5;padding:3px;text-align:center;margin:0;direction:ltr;\">The license will expire on : {$license_properties['expire']['value']} ($remaining_days days)</div>";
}

?>
<table width=100% height=100%><tr><td width=20% valign=top>
<?
print "$phrases[cp_user_welcome] $user_info[username] <br><br>";

require("admin_menu.php");
?>


</td>
 <td width=1 background='images/dot.gif'></td>
<td valign=top> <br>
<?
//----------------------Start -------------------------------------------------------
if(!$action){
   $data1 = db_qr_fetch("select count(id) as count from news_cats where cat=0");
  $data2 = db_qr_fetch("select count(id) as count from news_cats where cat!=0");
  $data3 = db_qr_fetch("select count(id) as count from news_news");
   $data4 = db_qr_fetch("select count(id) as count from news_user");



  print "<center><table width=50% class=grid><tr><td align=center><b>$phrases[welcome_to_cp] <br><br>";

 if($global_lang=="arabic"){
  print "„—Œ’ ·‹ : $_SERVER[HTTP_HOST]" ;
  if(COPYRIGHTS_TXT_ADMIN){
  	print "   „‰ <a href='http://allomani.com/' target='_blank'>  «··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </a> " ;
  	}

  	print "<br><br>

   ≈’œ«— : $version_number <br><br>";
  }else{
  print "Licensed For : $_SERVER[SERVER_NAME]" ;
  if(COPYRIGHTS_TXT_ADMIN){
  	print "   By  <a href='http://allomani.com/' target='_blank'>Allomani&trade;</a> " ;
  	}

  	print "<br><br>

   Version : $version_number <br><br>";
  	}


  print "$phrases[cp_statics] : </b> <br> $phrases[cp_main_cats_count]: $data1[count] <br>
   $phrases[cp_sub_cats_count] : $data2[count] <br>$phrases[cp_news_count] : $data3[count]<br>$phrases[cp_users_count]  : $data4[count] </font></td></tr></table></center>";



   print "<br><center><table width=50% class=grid><td align=center>";
    print "<b><span dir=$global_dir>$phrases[php_version] : </span></b> <span dir=ltr>".phpversion()." </span><br> ";

    print "<b><span dir=$global_dir>$phrases[mysql_version] :</span> </b><span dir=ltr>" . mysql_get_server_info() ."</span><br>";
  // print "<b><span dir=$global_dir>$phrases[zend_version] :</span> </b><span dir=ltr>" . @zend_loader_version() ."</span><br><br>";


   if(function_exists("gd_info")){
   $gd_info = @gd_info();
   print "<b>  $phrases[gd_library] : </b> <font color=green> $phrases[cp_available] </font><br>
  <b>$phrases[the_version] : </b> <span dir=ltr>".$gd_info['GD Version'] ."</span>";
  }else{
  print "<b>  $phrases[gd_library] : </b> <font color=red> $phrases[cp_not_available] </font><br>
  $phrases[gd_install_required] ";
          }
   print "</td></tr></table>";

  print "<br><center><table width=50% class=grid><td align=center>
  <p><b> $phrases[cp_addons] </b></p>";

   //--------------- Load Admin Plugins --------------------------
$dhx = opendir(CWD ."/plugins");
while ($rdx = readdir($dhx)){
         if($rdx != "." && $rdx != "..") {
                 $cur_fl = CWD ."/plugins/" . $rdx . "/admin.php" ;
        if(file_exists($cur_fl)){
                print $rdx ."<br>" ;
                }
          }

    }
closedir($dhx);
 print "</td></tr></table>";

if($global_lang=="arabic"){
    print "<br><center><table width=50% class=grid><td align=center>
     Ì ’›Õ «·„Êﬁ⁄ Õ«·Ì« $counter[online_users] “«∆—
                                               <br><br>
   √ﬂ»—  Ê«Ãœ ﬂ«‰  $counter[best_visit] ›Ì : <br> $counter[best_visit_time] <br></td></tr></table>";
 }else{
 	    print "<br><center><table width=50% class=grid><td align=center>
     Now Browsing : $counter[online_users] Visitor
                                               <br><br>
   Best Visitors Count : $counter[best_visit] in : <br> $counter[best_visit_time] <br></td></tr></table>";

 	}
   }






// -------------- Blocks ----------------------------------
if ($action == "blocks" or $action=="del_block" or $action=="edit_block_ok" or $action=="add_block"
|| $action=="block_disable" || $action=="block_enable" || $action=="block_order" || $action=="blocks_fix_order"){


if_admin();
if($action=="blocks_fix_order"){

   $qr=db_query("select * from news_blocks where pos='r' order by ord ASC");
    if(db_num($qr)){
    $block_c = 1 ;
    while($data = db_fetch($qr)){
    db_query("update news_blocks set ord='$block_c' where id='$data[id]'");
    ++$block_c;
    }
     }
//-------------------------------
  $qr=db_query("select * from news_blocks where pos='c' order by ord ASC");
    if(db_num($qr)){
    $block_c = 1 ;
    while($data = db_fetch($qr)){
    db_query("update news_blocks set ord='$block_c' where id='$data[id]'");
    ++$block_c;
    }
     }
//-------------------------------
  $qr=db_query("select * from news_blocks where pos='l' order by ord ASC");
    if(db_num($qr)){
    $block_c = 1 ;
    while($data = db_fetch($qr)){
    db_query("update news_blocks set ord='$block_c' where id='$data[id]'");
    ++$block_c;
    }
     }
        }
if($action=="block_order"){
        db_query("update news_blocks set ord=$ord where id = '$idrep'");
        db_query("update news_blocks set ord=$ordrep where id = '$id'");
        }


if($action=="block_disable"){
        db_query("update news_blocks set active=0 where id='$id'");
        }

if($action=="block_enable"){

       db_query("update news_blocks set active=1 where id='$id'");
        }
//---------------------------------------------------------
if($action=="add_block"){
if($pages){
foreach ($pages as $value) {
       $pg_view .=  "$value," ;
     }
       }else{
               $pg_view = '' ;
               }

$pg_view = fix_gpc($pg_view);
$file = fix_gpc($file);

               $title = htmlspecialchars($title);

if($pos != "l" && $pos != "r" && $pos != "c"){$pos = "c";}


 $ord = intval($ord);
         db_query("insert into news_blocks(title,pos,file,ord,active,template,pages)values('$title','$pos','$file','$ord','1','$template','$pg_view')");
        }
//------------------------------------------------------------
    if ($action=="del_block"){
          db_query("delete from news_blocks where id='$id'");
            }
//----------------------------------------------------------------
if ($action=="edit_block_ok"){

if($pages){

foreach ($pages as $value) {
       $pg_view .=  "$value," ;
     }
     //  $pg_view= substr($pg_view,0,strlen($pg_view)-1);
       }else{

               $pg_view = '' ;
               }

$pg_view = fix_gpc($pg_view);
$file = fix_gpc($file);

$title = htmlspecialchars($title);

if($pos != "l" && $pos != "r" && $pos != "c"){$pos = "c";}

 $ord = intval($ord);

                db_query("update news_blocks set title='$title',file='$file',pos='$pos',ord='$ord',template='$template',pages='$pg_view' where id='$id'");

                    }
//------------------------------------------------------------

print "<center><table border=\"0\" width=\"50%\"  cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">
        <tr>
                <td height=\"0\" >


                <form method=\"POST\" action=\"index.php\" name=submit_form>

                      <input type=hidden name=\"action\" value='add_block'>



                        <tr>
                                <td width=\"70\">
                <b>$phrases[the_title]</b></td><td >
                <input type=\"text\" name=\"title\" size=\"29\"></td>
                        </tr>
                       <tr>
                                <td width=\"70\">
                <b>$phrases[the_content]</b></td><td width=\"223\">
                  <textarea name='file' rows=10 cols=29 dir=ltr ></textarea></td>
                        </tr>

                               <tr> <td width=\"50\">
                <b>$phrases[the_position]</b></td>
                                <td width=\"223\">
                <select size=\"1\" name=\"pos\" onchange=\"set_menu_pages(this)\">
                        <option value=\"r\" selected>$phrases[right]</option>
                         <option value=\"c\">$phrases[center]</option>
                        <option value=\"l\">$phrases[left]</option>
                        </select>
                        </td>
                        </tr>
              <tr><td><b>$phrases[the_template]</b></td><td><select name=template><option value='0' selected> $phrases[the_default_template] </option>";
              $qr = db_query("select name,id from news_templates where protected !=1 order by id ");
              while($data = db_fetch($qr)){
                      print "<option value='$data[id]'>$data[name]</option>";
                      }
                      print "</select></td></tr>
                        <tr>
                                <td width=\"50\">
                <b>$phrases[the_order]</b></td><td width=\"223\">
                <input type=\"text\" name=\"ord\" value=\"1\" size=\"2\"></td>
                        </tr>

 <tr><td> <b> $phrases[appearance_places]</b></td><td><table width=100%><tr><td>";


  if(is_array($actions_checks)){


  $c=0;
 for($i=0; $i < count($actions_checks);$i++) {

        $keyvalue = current($actions_checks);

if($c==3){
	print "</td><td>" ;
	$c=0;
	}

print "<input  name=\"pages[$i]\" type=\"checkbox\" value=\"$keyvalue\" checked>".key($actions_checks)."<br>";


$c++ ;

 next($actions_checks);
}
}


          print " </td></tr></table></td></tr><tr><td colspan=2 align=center><input type=\"submit\" value=\"$phrases[add_button]\"></td></tr>


</table>
</form>    </center> <br>\n";


       $qr=db_query("select * from news_blocks order by pos DESC,ord ASC")   ;

       if (db_num($qr)){
           print "<center><table border=\"0\" width=\"80%\" cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">
           <tr><td><b>  $phrases[the_title] </b><td><b> $phrases[the_position] </b></td><td><b> $phrases[the_order] </b></td>
           <td colspan=3 align=center><b>  $phrases[the_options] </b></td></tr>";


         while($data= db_fetch($qr)){
         if($data['pos'] == "r"){
                 $block_color = "#0080C0";
                 }elseif($data['pos'] == "l"){
                   $block_color = "#2C920E";
                   }else{
                   $block_color = "#EA7500";
                           }

     print "           <tr onmouseover=\"set_tr_color(this,'#EFEFEE');\" onmouseout=\"set_tr_color(this,'#FFFFFF');\">
                <td><font color='$block_color'><b>$data[title]</b></font></td>
                <td width=100>";
                if($data['pos']=="r"){print $phrases['right'];}elseif($data['pos']=="l"){ print $phrases['left'] ; }else{ print $phrases['center'] ;}

                print "</td>
                <td width=10>$data[ord]</td>";
                 $ord1 = $data['ord'] - 1 ;
                 $ord3 = $data['ord'] + 1 ;

$data_ord1  = db_qr_fetch("select id,ord from news_blocks where ord=$ord1 and pos='$data[pos]'");
$data_ord2  = db_qr_fetch("select id,ord from news_blocks where ord=$ord3 and pos='$data[pos]'");


               if($data_ord1['id']){
               print "<td width=20 align=center><a href='index.php?action=block_order&ord=$data[ord]&id=$data[id]&ordrep=$ord1&idrep=$data_ord1[id]'><img border=0 src='images/arr_up.gif' alt='$phrases[to_up]'></a></td>";
               }else{
                       print "<td width=20 align=center></td>" ;
                       }

                if($data_ord2['id']){
               print " <td width=20 align=center><a href='index.php?action=block_order&ord=$data[ord]&id=$data[id]&ordrep=$ord3&idrep=$data_ord2[id]'><img border=0 src='images/arr_dwn.gif' alt='$phrases[to_down]'></a></td>
                 ";
                 }else{
                         print "<td width=20 align=center></td>" ;
                         }

                   print "
                <td   align=center>";

                if($data['active']){
                        print "<a href='index.php?action=block_disable&id=$data[id]'>$phrases[disable]</a>" ;
                        }else{
                        print "<a href='index.php?action=block_enable&id=$data[id]'>$phrases[enable]</a>" ;
                        }

                print "- <a href='index.php?action=edit_block&id=$data[id]'>$phrases[edit] </a>
                - <a href='index.php?action=del_block&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a></td>
        </tr>";

                 }

                print" </table>
                <br><form action='index.php' method=post>
                <input type=hidden name=action value='blocks_fix_order'>
                <input type=submit value=' $phrases[cp_blocks_fix_order] '>
                </form><br>";

                }else{
                        print "<br><center><table width=50% class=grid><tr><td align=center>$phrases[cp_no_blocks]</td></tr></table></center>";
                        }

}
//--------------------- Block Edit ---------------------------
if($action == "edit_block"){

  $data=db_qr_fetch("select * from news_blocks where id='$id'");
      $data['file'] = htmlspecialchars($data['file']) ;

 print " <center><table border=\"0\" width=\"60%\"  class=\"grid\" >


                <form method=\"POST\" action=\"index.php\">

                      <input type=hidden name=\"action\" value='edit_block_ok'>
                       <input type=hidden name=\"id\" value='$id'>


                        <tr>
                                <td>
                <b>$phrases[the_title]</b></td><td>
                <input type=\"text\" name=\"title\" value='$data[title]' size=\"29\"></td>
                        </tr>
                       <tr>
                                <td >
                <b>$phrases[the_content]</b></td><td >
                 <textarea name='file' rows=10 cols=50 dir=ltr >$data[file]</textarea></td>
                        </tr>";

                        if($data['pos']=="r"){
                                $option1 = "selected";
                                }elseif($data['pos']=="c"){
                                $option2 = "selected";
                                }else{
                                $option3="selected";
                                }

                              if($data['template']==0){
                                      $def_chk = "selected" ;}else{$def_chk = "" ;}

                             print"  <tr> <td >
                <b>$phrases[the_position]</b></td>
                                <td width=\"223\">
                <select size=\"1\" name=\"pos\">
                        <option value=\"r\" $option1>$phrases[right]</option>
                        <option value=\"c\" $option2>$phrases[center]</option>
                         <option value=\"l\" $option3>$phrases[left]</option>
                        </select>
                        </td>
                        </tr>

                   <tr><td><b>$phrases[the_template] </b></td><td><select name=template><option value='0' $def_chk> $phrases[the_default_template] </option>";
              $qr_template = db_query("select name,id from news_templates where protected !=1 order by id ");
              while($data_template = db_fetch($qr_template)){
              if($data['template'] == $data_template['id']){
                      $chk = "selected" ;
                      }else{
                              $chk = "";
                              }

                      print "<option value='$data_template[id]' $chk>$data_template[name]</option>";
                      }
                      print "</select></td></tr>

                              <tr>
                                <td>
                <b>$phrases[the_order]</b></td><td width='223'>
                <input type='text' name='ord' value='$data[ord]' size='2'></td>
                        </tr>
                        <tr><td> <b> $phrases[appearance_places]</b></td><td><table width=100%><tr><td>";

                         $pages_view = explode(",",$data['pages']);


  if(is_array($actions_checks)){

  $c=0;
 for($i=0; $i < count($actions_checks);$i++) {

        $keyvalue = current($actions_checks);

if($c==3){
	print "</td><td>" ;
	$c=0;
	}

if(in_array($keyvalue,$pages_view)){$chk = "checked" ;}else{$chk = "" ;}

print "<input  name=\"pages[$i]\" type=\"checkbox\" value=\"$keyvalue\" $chk>".key($actions_checks)."<br>";


$c++ ;

 next($actions_checks);
}
}



                          print "</td></tr></table>" ;
           print "</td></tr><tr><td colspan=2 align=center><input type=\"submit\" value=\"$phrases[edit]\"> </td></tr>



</table>
</form>    </center>\n";

        }
 //-------------------------- Votes ------------------------------------------
    if ($action == "votes" ||  $action=="vote_del" ||  $action == "vote_active"  || $action=="vote_add" ){

            if_admin("votes");

 if($action=="vote_add"){
        db_query("insert into news_votes_cats (title) values('$title')");
        }


//------------------------------
 if($action=="vote_del"){
 $id = intval($id);
         db_query("delete from news_votes_cats where id='$id'");
         db_query("delete from news_votes where cat='$id'");
         }

//---------------------------------
if($action == "vote_active"){
db_query("update news_votes_cats set active=0");
db_query("update news_votes_cats set active=1 where id='$id'");
        }

         print "<center><p class=title > $phrases[the_votes] </p>
         <form action=index.php method=post>
         <input type=hidden name=action value='vote_add'>
         <table width=50% class=grid><tr><td>
           <center><p class=title>$phrases[add_new_vote] </p></center>
         </td></tr>
         <td align=center><b>  $phrases[the_title] :  </b><input name=title size=30> <input type=submit value=' $phrases[add_button] '> </td></tr>

         </table></form><br>";

       $qr = db_query("select * from news_votes_cats");
print " <table class=grid width=70%>" ;
while($data = db_fetch($qr)){

     print "<tr><td >$data[title]  &nbsp;&nbsp;&nbsp;";
     if($data['active']){ print "[$phrases[default]]" ;}
     print "</td><td align=left><a href='index.php?action=vote_active&id=$data[id]'> $phrases[set_default] </a> - <a href='index.php?action=vote_edit&cat=$data[id]'>$phrases[edit_and_options]</a> - <a href='index.php?action=vote_del&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a> </td></tr>" ;

     }
    print "</table></center>";
      }
  //----------------------------------------------------------------------------
  if($action=="vote_edit" || $action=="vote2_add" || $action=="vote2_del" || $action=="vote2_edit_ok" ||$action=="vote_edit_ok" ){

   if_admin("votes");

  //--------------------------------
   if($action=="vote_edit_ok"){
      db_query("update news_votes_cats set title='$title' where id='$id'");

         }
  //------------------------------------------
    if ($action=="vote2_add"){
            db_query("insert into news_votes (title,cat) values('$title','$cat')");
            }
  //---------------------------------------
  if($action=="vote2_del"){
          db_query("delete from news_votes where id='$id'");
          }
  //-----------------------------------------
  if($action=="vote2_edit_ok"){
          db_query("update news_votes set title='$title' where id='$id'");
          }
  //---------------------------------------
            $cat = intval($cat);
  $data=db_qr_fetch("select id,title from news_votes_cats where id='$cat'");


   print "<center>
  <form action=index.php mothod=post>
  <input type=hidden name=id value=$data[id]>
  <input type=hidden name=cat value='$cat'>
  <input type=hidden name=action value='vote_edit_ok'>
  <table width=50% class=grid>
  <tr><td align=center>
  $phrases[the_title] : <input type=text value='$data[title]' name=title size=30>
  <input type=submit value=' $phrases[edit]  '></td></tr></table> </form>";

  print "
  <br>
  <form action=index.php method=post>
  <input type=hidden name=action value='vote2_add'>
  <input type=hidden name=cat value='$cat'>
  <table width=50% class=grid><tr><td align=center>
  <p class=title> $phrases[add_options] </p>
  $phrases[the_title] : <input type=text name=title size=30>
  <input type=submit value=' $phrases[add_button] '></td></tr></table><br>
  <table width=50% class=grid>";
  $qr=db_query("select * from news_votes where cat=$cat");
  while($data = db_fetch($qr)){
    print "<tr><td width=70%> $data[title] </td><td> <a href='index.php?action=vote2_edit&id=$data[id]&cat=$cat'> $phrases[edit] </a>
    - <a href='index.php?action=vote2_del&id=$data[id]&cat=$cat' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a> </td>
    </tr>";

          }
       print "</table></center>";
          }
  //------------------------------------------------------
  if($action == "vote2_edit"){

 if_admin("votes");

 $id = intval($id);
  $cat = intval($cat);

  $data = db_qr_fetch("select * from news_votes where id='$id'") ;
  print "<center>
  <form action=index.php mothod=post>
  <input type=hidden name=id value='$id'>
  <input type=hidden name=cat value='$cat'>
  <input type=hidden name=action value='vote2_edit_ok'>
  <table width=50% class=grid>
  <tr><td align=center>
  $phrases[the_title] : <input type=text value='$data[title]' name=title size=30>
  <input type=submit value=' $phrases[edit] '></td></tr></table> </form></center>";
  }

 //--------------------- news add -----------------------
 if($action=="news_add"){

//-------------- dirs header ----------------
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from news_cats where id=$dir_data[cat]");

        $dir_content = "<a href='index.php?action=news&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
  //------------------------------------------
    print "<p align=$global_align><img src='images/link.gif'><a href='index.php?action=news&cat=0'>$phrases[main_page] </a> / $dir_content</p>";


          print "<center><table border=\"0\" width=\"80%\"   cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">
        <tr>
                <td height=\"0\">
                <div align=\"center\">
                <table border=0 width=\"97%\"  style=\"border-collapse: collapse\"><tr>

                <form name=sender method=\"POST\" action=\"index.php\">

                      <input type=hidden name=\"action\" value='add_news'>
                     <input type=hidden name=cat value='$cat'>


                        <tr>
                                <td width=\"100\">
                <b>$phrases[the_title]</b></td><td >
                <input type=\"text\" name=\"title\" size=\"50\"></td>
                        </tr>
                       <tr>
                                <td width=\"100\">
                <b>$phrases[the_writer]</b></td><td width=\"223\">
                <input type=\"text\" name=\"writer\" size=\"50\" value='$user_info[username]'></td>
                        </tr>

                               <tr> <td width=\"100\">
                <b>$phrases[the_image]</b></td>
                                <td>
                                <table><tr><td>
                                <input type=\"text\" name=\"img\" size=\"50\" dir=ltr>  </td><td> <a href=\"javascript:uploader('news','img');\"><img src='images/file_up.gif' border=0 alt='—›⁄ ’Ê—… „‰ «·ÃÂ«“'></a>
                                 </td></tr></table>
                                 </td></tr>


                                          <tr> <td width=\"100\">
                <b>$phrases[the_content]</b></td>
                                <td>";

    editor_print_form("details",600,300,"");

                 print "<br><center><input type=\"submit\" value=\"$phrases[add_button]\"></center>
                        </td>
                        </tr>





                </table>
                </div>
                </td>
        </tr>
</table>
</form>    </center>\n";

}


//------------- if Cat Admin Function ---------
function if_cat_admin($cat,$type="cat"){
 global $user_info,$phrases ;
                       
 if($user_info['groupid'] != 1){
     $prm_data = db_qr_fetch("select permisions from news_user where id='$user_info[id]'");

  if($type=="id"){
  $news_cat = db_qr_fetch("select cat from news_news where id='$cat'");
  $cat = intval($news_cat['cat']);
  }
 
      
  if($cat){

  $cats_permisions = explode(",",$prm_data['permisions']);
  
         if(!in_array($cat,$cats_permisions)){
   die("<center>  $phrases[err_cat_access_denied] </center>");
    }
    }
      }
}
 // ------------------------------- News ----------------------------------------
 if ($action=="cats" ||  $action=="cat_del" || $action=="edit_cat_ok" || $action=="cat_add_ok" || $action == "news" or $action=="del_news" or $action=="edit_news_ok" or $action=="add_news" || $action=="news_move_ok"){

 $cat = intval($cat);

//------------------- news move ------------------------
if($action=="news_move_ok"){
	$qr_to =  db_qr_num("select id from news_cats where id='$cat_to'");

 if($qr_to > 0){
     if(is_array($id)){
    foreach($id as $news_id){
            db_query("update news_news set cat='$cat_to' where id='$news_id'");
    }}

        }else{
       print "$phrases[err_invalid_cat_id]";
        }
        }
//---------------------news cat add -------------------------------
if($action =="cat_add_ok"){
       if_cat_admin($cat);
if($name){
$name=htmlspecialchars($name);
  db_query("insert into news_cats (name,cat) values('$name','$cat')");
  }
        }
//------------------------news cat delete -----------------------------
 if($action=="cat_del"){


      if(is_numeric($id)){
            $delete_array = get_cats($id);
  foreach($delete_array as $id_del){
         if_cat_admin($del_id);
     db_query("delete from news_cats where id='$id_del'");
     db_query("delete from news_news where cat='$id_del'");
     }

                     }

 }
//-----------------------------------------------------------
 if($action=="edit_cat_ok"){
        if_cat_admin($id);
       if($name){
           $name=htmlspecialchars($name);
 db_query("update news_cats set name='$name' where id='$id'");
       }
         }
//-----------------------------------------------------------
 if($action=="add_news"){
     if_cat_admin($cat);
     if($title){
         db_query("insert into news_news(cat,title,writer,details,date,img)values('$cat','$title','$writer','$details',now(),'$img')");
     }
     }
        //--------------------
    if ($action=="del_news"){

    if(!is_array($id)){$id = array("$id");}

    foreach($id as $del_id){
         if_cat_admin($del_id,"id");
          db_query("delete from news_news where id='$del_id'");
          }
            }
            //-----------------------------------------
            if ($action=="edit_news_ok"){
                  if_cat_admin($id,"id");
                if($title){
                db_query("update news_news set cat='$cat',title='$title',writer='$writer',details='$details',img='$img' where id='$id'");
                }

                    }
                    //---------------------------------------------


//-------------- dirs header ----------------
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from news_cats where id=$dir_data[cat]");

        $dir_content = "<a href='index.php?action=news&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
  //------------------------------------------
  
  
  if_cat_admin($cat); 
  
  
    print "<p align=$global_align><img src='images/link.gif'><a href='index.php?action=news&cat=0'>$phrases[main_page] </a> / $dir_content</p>";

 if($cat > 0){

                $data = db_qr_fetch("select * from news_cats where id='$cat'");

               print "<center>

                <table border=0 width=\"40%\"  style=\"border-collapse: collapse\" class=grid><tr>

                <form method=\"POST\" action=\"index.php\">

                      <input type=hidden name=\"id\" value='$cat'>
                         <input type=hidden name=\"cat\" value='$cat'>
                      <input type=hidden name=\"action\" value='edit_cat_ok'> ";


                  print "  <tr>
                                <td width=\"50\">
                <b>$phrases[the_name]</b></td><td width=\"223\">
                <input type=\"text\" name=\"name\" value='$data[name]' size=\"29\"></td>
                        </tr>

                        ";

                              print " <tr>
                                <td colspan=2>
                <center><input type=\"submit\" value=\"$phrases[edit]\">   </td>
                </tr><tr>
                <td colspan=2 align=left><a href=\"index.php?action=cat_del&id=$data[id]&cat=$data[cat]\" onClick=\"return confirm('".$phrases['cp_news_cat_del_confirm']."');\">$phrases[delete] </a></td>


                        </tr>





                </table>

</form>    </center>\n";
 }

 //------------------------ add cat -------------------------
  print "<center><p class=title>$phrases[cats]</p>
   <form method=\"POST\" action=\"index.php\">

   <table width=45% class=grid><tr>
   <td> $phrases[the_name] :
    <input type=hidden name='action' value='cat_add_ok'>
     <input type=hidden name='cat' value='$cat'>
   <input type=text name=name size=30>
    </td>
    <td><input type=submit value='$phrases[add_button]'></td>
    </tr></table>

     </form>

   </center>";





//-------------- cats display ---------------

if($user_info['groupid'] != 1){
$usr_data = db_qr_fetch("select permisions from news_user where id='$user_info[id]'");

if($usr_data['permisions']){
    $qr=db_query("select * from news_cats where (id IN ($usr_data[permisions]) and cat='$cat') order by name ASC");
   
}

     }else{

$qr=db_query("select * from news_cats where cat='$cat' order by name ASC");
      }
      
      
//$qr=db_query("select * from news_cats where cat='$cat' order by name ASC");

if(db_num($qr)){
                 $c =0 ;
  print "<center> <br><br>
  <table width=98% class=grid><tr>";
  while($data = db_fetch($qr)){
    print "<td width=25%><center><a href='index.php?action=news&cat=$data[id]'>$data[name]</a></center></td>";
     ++$c ;
     if($c >= 4){print "</tr><tr>";$c=0;}

          }
          print "</table>";
 }
//---------------------------------------

if($user_info['groupid'] != 1){
$usr_data = db_qr_fetch("select permisions from news_user where id='$user_info[id]'");

if($usr_data['permisions']){
    $qr_cat=db_query("select id,name from news_cats where (id IN ($usr_data[permisions]) and id='$cat') order by name ASC");
   
}

     }else{

$qr_cat=db_query("select id,name from news_cats where id='$cat' order by name ASC");
      }

   if(db_num($qr_cat)){
  $data_cat = db_fetch($qr_cat);

print "
   <p align=center class=title>[$data_cat[name]]</p>

  <center> <br>[ <a href='index.php?action=news_add&cat=$cat'>$phrases[cp_news_add]</a> ] </center>";




       $qr=db_query("select * from news_news where cat='$cat' order by id DESC")   ;

       if (db_num($qr)){
           print "<br><center>
           <form action=index.php method=post  name=submit_form>
           <table border=0 width=\"98%\"   cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">
           <input type=hidden name=cat value='$cat'>" ;
          $c = 1;


         while($data= db_fetch($qr)){
     print "            <tr id=news_tr_$c onmouseover=\"set_tr_color(this,'#EFEFEE');\" onmouseout=\"set_tr_color(this,'#FFFFFF');\">
                <td width=2>
          <input name='id[$c]' type='checkbox' value='$data[id]' onclick=\"set_checked_color('news_tr_$c',this)\">
          </td>
          <td>$data[title]</td>
                <td>$data[date]</td>
                <td align=left><a href='index.php?action=edit_news&id=$data[id]'>$phrases[edit] </a> - <a href='index.php?action=del_news&id=$data[id]&cat=$cat' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a></td>
        </tr>";

$c++;
                 }

               print "<tr><td width=2><img src='images/arrow_rtl.gif'></td>
          <td width=100% colspan=5>
          <table><tr><td>

          <a href='#' onclick=\"CheckAll(); return false;\">$phrases[cp_check_all] </a> -
          <a href='#' onclick=\"UncheckAll(); return false;\">$phrases[cp_uncheck_all]</a>
          &nbsp;&nbsp;  ";

          print "<select name=action>
          <option value='news_move'>$phrases[move]</option>
        <option value='del_news'>$phrases[delete]</option>
          </select></td>

         <td><input type=submit value=' $phrases[do_button] ' onClick=\"return confirm('".$phrases['are_you_sure']."');\"></td></tr></table>
          </td></tr></form> ";
                }else{
                        print "<br><center><table width=80% class=grid><tr><td align=center>$phrases[cp_no_news]</td></tr></table></center>";
                        }

                        }



}
//----------------------------------------
if($action == "edit_news"){

    if_cat_admin($id,"id");

  $qr=db_query("select * from news_news where id='$id'");
   if(db_num($qr)){
           $data = db_fetch($qr);

           //-------------- dirs header ----------------
$dir_data['cat'] = $data['cat'] ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from news_cats where id=$dir_data[cat]");

        $dir_content = "<a href='index.php?action=news&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
  //------------------------------------------
    print "<p align=$global_align><img src='images/link.gif'><a href='index.php?action=news&cat=0'>$phrases[main_page] </a> / $dir_content</p>";


      print " <center>
                <table border=0 width=\"80%\"  style=\"border-collapse: collapse\" class=grid><tr>

                <form method=\"POST\" action=\"index.php\" name=sender>

                    <input type=hidden name=\"action\" value='edit_news_ok'>
                       <input type=hidden name=\"id\" value='$id'>
                       <input type=hidden name=\"cat\" value='$data[cat]'>


                        <tr>
                                <td width=\"100\">
                <b>$phrases[the_title]</b></td><td >
                <input type=\"text\" name=\"title\" size=\"50\" value='$data[title]'></td>
                        </tr>
                       <tr>
                                <td width=\"100\">
                <b>$phrases[the_writer]</b></td><td width=\"223\">
                <input type=\"text\" name=\"writer\" size=\"50\" value='$data[writer]'></td>
                        </tr>

                               <tr> <td width=\"100\">
                <b>$phrases[the_image]</b></td>
                                <td>


                            <table><tr><td>
                                 <input type=\"text\" name=\"img\" size=\"50\" dir=ltr value='$data[img]'>   </td>

                                <td> <a href=\"javascript:uploader('news','img');\"><img src='images/file_up.gif' border=0 alt='$phrases[browse_and_upload_photo]'></a>
                                 </td></tr></table>

                                 </td></tr>


                                    <tr> <td width=\"50\">
                <b>$phrases[the_content]</b></td>
                                <td>";

      editor_print_form("details",600,300,$data['details']);
                        print "</td>
                        </tr>
                 <tr><td colspan=2 align=center>  <input type=\"submit\" value=\"$phrases[edit]\">  </td></tr>




                </table>

</form>    </center>\n";
   }else{
           print "<center>$phrases[err_wrong_url]</center>";
           }
        }


//----------------- news Move -------
if($action == "news_move"){
if_admin();

 if(is_array($id)){

 print "<form action=index.php method=post name=sender>
 <input type=hidden name=action value='news_move_ok'>
 <input type=hidden name=cat value='$cat'>
 <center><table width=60% class=grid><tr><td colspan=2><b> $phrases[move_from] : </b>";

//-----------------------------------------
$data_from['cat'] = $cat ;
while($data_from['cat']>0){
   $data_from = db_qr_fetch("select name,id,cat from news_cats where id='$data_from[cat]'");

        $data_from_txt = "$data_from[name] / ". $data_from_txt  ;

        }
   print "$data_from_txt";
//------------------------------------------

 print "</td></tr>";
 $c = 1 ;
foreach($id as $news_id){
$data_news=db_qr_fetch("select title from news_news where id='$news_id'");
  print "<input type=hidden name=id[] value='$news_id'>";
        print "<tr><td width=2><b>$c</b></td><td>$data_news[title]</td></tr>"  ;
        ++$c;
        }
 print "<tr><td colspan=2><b>$phrases[move_to_cat_number] : </b><input type=text size=4 name=cat_to>
 <a href=\"javascript:cats_list()\">
  <img src='images/list.gif' alt='$phrases[the_cats_list]' border=0></a>
  </td></tr>
 <tr><td colspan=2 align=center><input type=submit value=' $phrases[move_news_button] '></td></tr>
 </table>";
        }else{
                print "<center><table width=50% class=grid><tr><td align=center>$phrases[please_select_news_first]</td></tr></table></center>";
                }
        }
// ------------------------------- pages ----------------------------------------
 if ($action == "pages" or $action=="del_pages" or $action=="edit_pages_ok" or $action=="add_pages" || $action=="page_enable" || $action=="page_disable"){

 if_admin("pages");

if($action=="page_enable"){
        db_query("update news_pages set active=1 where id='$id'");
        }

if($action=="page_disable"){
        db_query("update news_pages set active=0 where id='$id'");
        }

if($action=="add_pages"){
         db_query("insert into news_pages(title,content,active)values('$title','$content','1')");
        }
        //==========================================
    if ($action=="del_pages"){
          db_query("delete from news_pages where id='$id'");
            }
            //==============================================
            if ($action=="edit_pages_ok"){
                db_query("update news_pages set title='$title',content='$content' where id='$id'");

                    }




       $qr=db_query("select * from news_pages order by id DESC")   ;
          print "<center>[ <a href='index.php?action=pages_add'> «÷«›… ’›Õ… </a> ] <br><br>
          <table border=0 width=\"70%\"   cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">";
       if (db_num($qr)){



         while($data= db_fetch($qr)){
     print "            <tr>
                <td >$data[title]</td>
                <td align=center> <a target=_blank href='../index.php?action=pages&id=$data[id]'>$phrases[cp_view_page]</a> </td>
                <td align=left>" ;

                if($data['active']){
                        print "<a href='index.php?action=page_disable&id=$data[id]'>$phrases[disable]</a>" ;
                        }else{
                        print "<a href='index.php?action=page_enable&id=$data[id]'>$phrases[enable]</a>" ;
                        }

                print " - <a href='index.php?action=edit_pages&id=$data[id]'>$phrases[edit] </a> - <a href='index.php?action=del_pages&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a></td>
        </tr>";

                 }


                }else{
                        print "<tr><td width=100%><center> $phrases[cp_no_pages] </center></td></tr>";
                        }
                      print" </table>\n";
}

//-------------------- edit pages ----------------------------
if($action == "edit_pages"){

$qr = db_query("select * from news_pages where id='$id'") ;
if(db_num($qr)){
  $data=db_fetch($qr);

      print " <center><table  width=\"70%\"  style=\"border-collapse: collapse\"  class=grid>

                <form method=\"POST\" action=\"index.php\">

                    <input type=hidden name=\"action\" value='edit_pages_ok'>
                       <input type=hidden name=\"id\" value='$id'>



                        <tr>
                                <td width=\"70\">
                <b>$phrases[the_title]</b></td><td >
                <input type=\"text\" name=\"title\" size=\"29\" value='$data[title]'></td>
                        </tr>


                             <tr> <td width=\"50\">
                <b>$phrases[the_content]</b></td>
                                <td>";
                                  if($use_editor_for_pages){
                     editor_print_form("content",600,300,"$data[content]");
                }else{
                print "<textarea cols=60 rows=10 name='content' dir=ltr>$data[content]</textarea>"; 
                }
                

                 print "<input type=\"submit\" value=\"$phrases[edit]\">
                        </td>
                        </tr>






</table>
</form>    </center>\n";
         }else{
         print "<center><table width=50% class=grid><tr><td align=center>$phrases[err_wrong_url]</td></tr></table></center>";
         }
        }
//-------- pages add ----------
if($action=="pages_add"){
    print "<center><table border=\"0\" width=\"80%\"   cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">

                <form method=\"POST\" action=\"index.php\">

                      <input type=hidden name=\"action\" value='add_pages'>



                        <tr>
                                <td width=\"70\">
                <b>$phrases[the_title]</b></td><td >
                <input type=\"text\" name=\"title\" size=\"50\"></td>
                        </tr>



                             <tr> <td width=\"50\">
                <b>$phrases[the_content]</b></td>
                                <td>";
                                  if($use_editor_for_pages){
                               editor_print_form("content",600,300,"");
                }else{
                print "<textarea cols=60 rows=10 name='content' dir=ltr></textarea>"; 
                }
                 
                 print "</td></tr><tr><td align=center colspan=2>
                 <input type=\"submit\" value=\"$phrases[add_button]\">
                        </td>
                        </tr>



                </table>

</form>    </center>\n";
}
//-------------------- Permisions------------------------
if($action=="permisions"){

    if_admin();
 $id = intval($id);

$qrs = db_query("select id from news_user where id='$id'");
if(db_num($qrs)){
    print " <form method=post action=index.php>
           <input type=hidden value='$id' name='user_id'>
               <input type=hidden value='permisions_edit' name='action'>";

$qr =db_query("select * from news_cats order by name");
         print "<center><span class=title>$phrases[permissions_manage]</span><br><br>
           <table cellpadding=\"0\" border=0 cellspacing=\"0\" width=\"80%\" class=\"grid\">

        <tr><td>
        <center> $phrases[news_cats_permissions] </center> <br>";
           $i=0;
           $data2 = db_qr_fetch("select permisions from news_user where id='$id'");
   $user_permisions = explode(",",$data2['permisions']);

   while($data = db_fetch($qr)){
           ++$i ;
           if(in_array($data['id'],$user_permisions)){$chk = "checked" ;}else{$chk = "" ;}


          print "<input name=\"cat[$i]\" type=\"checkbox\" value=\"$data[id]\" $chk>$data[name]<br>     \n";
           }
           print "</td></tr>
           </table><br>";

     //------------------------------------------------------------------------------


     //------------------------------------------------------------------------------

     $data =db_qr_fetch("select * from news_user where id='$id'");





     print "<table cellpadding=\"0\" border=0 cellspacing=\"0\" width=\"80%\" class=\"grid\">
     <tr> <td colspan=5 align=center>$phrases[cp_sections_permissions]</td></tr>
            <tr><td><table width=100%><tr>";

            $prms = explode(",",$data['cp_permisions']);


  if(is_array($permissions_checks)){

  $c=0;
 for($i=0; $i < count($permissions_checks);$i++) {

        $keyvalue = current($permissions_checks);

if($c==4){
	print "</tr><tr>" ;
	$c=0;
	}

if(in_array($keyvalue,$prms)){$chk = "checked" ;}else{$chk = "" ;}

print "<td width=25%><input  name=\"cp_permisions[$i]\" type=\"checkbox\" value=\"$keyvalue\" $chk>".key($permissions_checks)."</td>";


$c++ ;

 next($permissions_checks);
}
  }
print "</tr></table></td>

            </tr></table>";

          print "<center> <br><input type=submit value='$phrases[edit]'></form>" ;
 }else{
 	print "<center> $phrases[err_wrong_url]</center>";
 	}
        }
//---------------------------- Users ------------------------------------------
if ($action == "users" || $action=="edituserok" || $action=="adduserok" || $action=="deluser" || $action=="permisions_edit"){


if($action=="permisions_edit"){

if_admin();

if($cp_permisions){
foreach ($cp_permisions as $value) {
       $perms .=  "$value," ;
     }
       }else{
               $perms = '' ;
               }

 db_query("update news_user set cp_permisions='$perms' where id='$user_id'");


if($cat){
foreach ($cat as $value) {
       $prms .=  "$value," ;
     }
       $prms= substr($prms,0,strlen($prms)-1);
     db_query("update news_user set permisions='$prms' where id='$user_id'") ;
    }else{
    db_query("update news_user set permisions='' where id='$user_id'") ;
            }


           }

        //---------------------------------------------
        if ($action=="deluser" && $id){
        if($user_info['groupid']==1 ){
db_query("delete from news_user where id='$id'");
}else{
        die("$phrases[err_access_denied]");
        }
        }
        //---------------------------------------------
        if ($action == "adduserok"){
        if($user_info['groupid']==1){
                if($username && $password){
                if(db_qr_num("select username from news_user where username='$username'")){
                        print "<center> $phrases[cp_err_username_exists] </center>";
                        }else{
        db_query("insert into news_user (username,password,email,group_id) values ('$username','$password','$email','$group_id')");
        }
        }else{
                print "<center>  $phrases[cp_plz_enter_usr_pwd] </center>";
                }
                }else{
                          die("$phrases[err_access_denied]");
        }
        }
        //------------------------------------------------------------------------------
        if ($action == "edituserok"){
                if ($password){
                $ifeditpassword = ", password='$password'" ;
                }

        if ($user_info['groupid'] == 1){
        db_query("update news_user set username='$username'  , email='$email' ,group_id='$group_id' $ifeditpassword where id='$id'");
        }else{
         if($user_info['id'] == $id){
        db_query("update news_user set username='$username'  , email='$email' ,group_id='$group_id' $ifeditpassword where id='$id'");

                 }else{
                  die("$phrases[err_access_denied]");
                         }
                }
        if (mysql_affected_rows()){
                print "<center> $phrases[cp_edit_user_success] </center>";
        }
        }

        if ($user_info['groupid'] == 1){

//--------------------- Add User Form -------------------------------------------------------

print "   <br>
   <center>

<FORM METHOD=\"post\" ACTION=\"index.php\">

 <TABLE width=\"40%\" class=grid>
    <TR>
   <td colspan=2 align=center><span class=title> $phrases[cp_add_user] </span></td></tr>
   <tr>
<INPUT TYPE=\"hidden\" NAME=\"action\"  value=\"adduserok\" >

   <TD width=\"150\"><font color=\"#006699\"><b>$phrases[cp_username]: </b></font> </TD>
   <TD ><INPUT TYPE=\"text\" NAME=\"username\" size=\"32\"  </TD>
  </TR>
    <TR>
   <TD width=\"150\"><font color=\"#006699\"><b>$phrases[cp_password] : </b></font> </TD>
   <TD ><INPUT TYPE=\"password\" NAME=\"password\" size=\"32\" > </TD>
  </TR>
   <TR>
   <TD width=\"150\"><font color=\"#006699\"><b>$phrases[cp_email] : </b></font> </TD>
   <TD ><INPUT TYPE=\"text\" NAME=\"email\" size=\"32\" > </TD>
  </TR>

   <TR>
   <TD width=\"150\"><font color=\"#006699\"><b>$phrases[cp_user_group]: </b></font> </TD>
   <TD >\n";


print "  <p><select size=\"1\" name=group_id>\n
        <option value='1' > $phrases[cp_user_admin] </option>
  <option value='2' > $phrases[cp_user_mod]</option>" ;


 print "  </select>";


  print " </TD>
  </TR>


  <TR>
   <TD COLSPAN=\"2\" >
   <p align=\"center\"><INPUT TYPE=\"submit\" name=\"useraddbutton\" VALUE=\"$phrases[add_button]\"></TD>
  </TR>
 </TABLE>
</FORM>
</center><br><br>\n";


//----------------------------------------------------
     print "<center>$phrases[the_users]</center>";
       $result=db_query("select * from news_user order by id asc");


  print " <center> <table cellpadding=\"0\" border=0 cellspacing=\"0\" width=\"80%\" class=\"grid\">

        <tr>
             <td height=\"18\" width=\"134\" valign=\"top\" align=\"center\">$phrases[cp_username]</td>
                <td height=\"18\" width=\"240\" valign=\"top\">
                <p align=\"center\">$phrases[cp_email]</td>
                <td height=\"18\" width=\"105\" valign=\"top\">
                <p align=\"center\">$phrases[cp_user_group]</td>
                <td height=\"18\" width=\"193\" valign=\"top\" colspan=2>
                <p align=\"center\">$phrases[the_options]</td>
        </tr>";

      while($data = db_fetch($result)){


        if ($data['group_id']==1){$groupname="$phrases[cp_user_admin]";
             $permision_link="";
      }elseif($data['group_id']==2){$groupname="$phrases[cp_user_mod]";
       $permision_link="<a href='index.php?action=permisions&id=$data[id]'>$phrases[permissions_manage]</a>";

      }


        print "<tr>
                <td  width=\"134\" >
                <p align=\"center\">$data[username]</p></td>
                <td  width=\"240\" >
                <p align=\"center\">$data[email]</p></td>
                <td  width=\"105\"><p align=\"center\">$groupname</p></td>
                 <td  width=\"105\"><p align=\"center\">$permision_link</p></td>
                <td  width=\"193\"><p align=\"center\">
                 <a href='index.php?action=edituser&id=$data[id]'> $phrases[edit] </a> ";
        if ($data['id'] !="1"){
                print "- <a href='index.php?action=deluser&id=$data[id]' onClick=\"return confirm('".$phrases['are_you_sure']."');\"> $phrases[delete] </a>";
        }
                print " </p>
                </td>
        </tr>";
          }

print "</table></center>\n";




        }else{

                print "<br><center><table widht=70% class=grid><tr><td align=center>
                $phrases[edit_personal_acc_only] <br>
                <a href='index.php?action=edituser'> $phrases[click_here_to_edit_ur_account] </a>
                </td></tr></table></center>";
        }
        }
//-------------------------------------------------------------------------------

        if ($action=="edituser"){
       $id = intval($id);

if($user_info['groupid']!=1){
        $id=$user_info['id'];

}

$qr=db_query("select * from news_user where id='$id'") ;
if (db_num($qr)){

$data = db_fetch($qr) ;

print "<center>
<FORM METHOD=\"post\" ACTION=\"index.php\">

 <TABLE width=70% class=grid>
    <TR>

    <INPUT TYPE=\"hidden\" NAME=\"id\" \" value=\"$data[id]\" >
<INPUT TYPE=\"hidden\" NAME=\"action\"  value=\"edituserok\" >

   <TD width=\"100\"><font color=\"#006699\"><b>$phrases[cp_username] : </b></font> </TD>
   <TD width=\"614\"><INPUT TYPE=\"text\" NAME=\"username\" size=\"32\" value=\"$data[username]\" > </TD>
  </TR>
    <TR>
   <TD width=\"100\"><font color=\"#006699\"><b>$phrases[cp_password] : </b></font> </TD>
   <TD width=\"614\"><INPUT TYPE=\"password\" NAME=\"password\" size=\"32\"> * $phrases[leave_blank_for_no_change] </TD>
  </TR>
   <TR>
   <TD width=\"100\"><font color=\"#006699\"><b>$phrases[cp_email] : </b></font> </TD>
   <TD width=\"614\"><INPUT TYPE=\"text\" NAME=\"email\" size=\"32\" value=\"$data[email]\" > </TD>
  </TR>\n";

  if($user_info['groupid'] != 1){
          print "<input type='hidden' name='group_id' value='2'>";
  }else {
   print "<TR>
   <TD width=\"100\"><font color=\"#006699\"><b>$phrases[cp_user_group]: </b></font> </TD>
   <TD width=\"614\">\n";


if ($data['group_id'] == 1){$ifselected1 = "selected" ; }else{$ifselected2 = "selected";}

print "  <p><select size=\"1\" name=group_id>\n
        <option value='1' $ifselected1> $phrases[cp_user_admin] </option>
  <option value='2' $ifselected2>$phrases[cp_user_mod] </option>" ;


 print "  </select>";
  }

   print "</TD>
  </TR>


  <TR>
   <TD COLSPAN=\"2\" width=\"685\">
   <p align=\"center\"><INPUT TYPE=\"submit\" name=\"usereditbutton\" VALUE=\"$phrases[edit]\"></TD>
  </TR>
 </TABLE>
</FORM>
</center>\n";


}else{
	print "<center> $phrases[err_wrong_url]</center>" ;
	}
}






  //----------------  Banners -------------------------------------
   if($action == "banners" || $action =="adv2" || $action =="adv2_edit_ok" || $action =="adv2_del" || $action =="adv2_add_ok"){

   if_admin("adv");


    if($action =="adv2_add_ok"){
    if($pages){
foreach ($pages as $value) {
       $pg_view .=  "$value," ;
     }
       }else{
               $pg_view = '' ;
               }

      db_query("insert into  news_banners (title,url,img,ord,type,date,menu_id,menu_pos,pages,content,c_type) values ('$title','$url','$img','$ord','$type',now(),'$menu_id','$menu_pos','$pg_view','$content','$c_type')");

          }

  if($action =="adv2_edit_ok"){

 if($pages){
foreach ($pages as $value) {
       $pg_view .=  "$value," ;
     }
       }else{
               $pg_view = '' ;
               }
      db_query("update news_banners set title='$title',url='$url',img='$img',ord='$ord',type='$type',menu_id='$menu_id',menu_pos='$menu_pos',pages='$pg_view',content='$content',c_type='$c_type' where id='$id'");

          }

          if($action =="adv2_del"){

      db_query("delete from news_banners where id='$id'");

          }

            print " <script src='js.js' type=\"text/javascript\" language=\"javascript\"></script>

              <center><table  width=\"70%\" class=grid>


                <form method=\"POST\" action=\"index.php\">
                 <input type='hidden' value='adv2_add_ok' name='action'>
              <tr>
                   <td >
                      $phrases[the_name]<td >
                <input type=\"text\" name=\"title\" size=\"38\"></td>
        </tr>

           <tr>
                   <td >
                   $phrases[the_content_type]    <td >
               <input name=\"c_type\" type=\"radio\" value=\"img\" checked onClick=\"show_banner_img();\" > $phrases[bnr_ctype_img] <br>
               <input name=\"c_type\" type=\"radio\" value=\"code\" onClick=\"show_banner_code();\"> $phrases[bnr_ctype_code]
                </td>
        </tr>

         <tr id=banners_url_area>
                <td >$phrases[the_url]</td>
                <td >
                <input type=\"text\" name=\"url\"  dir=ltr value='http://' size=\"38\"></td>
        </tr>
        <tr id=banners_img_area>
                <td >$phrases[the_image]</td>
                <td >
                <input type=\"text\" name=\"img\" dir=ltr  size=\"38\"></td>
        </tr>

<tr id=banners_code_area style=\"display: none; text-decoration: none\"> <td>$phrases[the_code] </td>
<td>
<textarea dir=ltr rows=\"8\" name=\"content\" cols=\"50\"></textarea>
</td></tr>

        <tr>
                <td >$phrases[bnr_appearance_places]</td>
                <td ><select name=\"type\" size=\"1\" onChange=\"show_adv_options(this)\">
             ";
                print "
                <option value=\"header\" selected>$phrases[bnr_header]</option>
                <option value=\"footer\">$phrases[bnr_footer]</option>

                   <option value=\"open\" >$phrases[bnr_open]</option>
                 <option value=\"close\" >$phrases[bnr_close]</option>
                 <option value=\"menu\" >$phrases[bnr_menu]</option>

                </select></td>

                </tr>
        <tr>
                <td>
                 <div id=add_after_menu style=\"display: none; text-decoration: none\">
                 $phrases[add_after_menu_number] : </div></td>
                <td>
               <div id=add_after_menu2 style=\"display: none; text-decoration: none\">
                <input type=\"text\"  name=\"menu_id\" value=0 size=\"4\">&nbsp;  $phrases[bnr_menu_pos]&nbsp;
                <select name=\"menu_pos\" size=\"1\">

                <option value=\"r\" >$phrases[the_right]</option>
                <option value=\"c\" >$phrases[the_center]</option>
                 <option value=\"l\" >$phrases[the_left]</option>

                </select> </div> </td>

                </tr>

                <tr>
                <td height=\"43\" width=\"131\">$phrases[the_order]</td>
                <td height=\"43\" width=\"308\"><input type=\"text\" name=\"ord\" value='0' size=\"4\"></td>
                </tr>
                <tr><td>$phrases[bnr_appearance_pages]</td><td>

                <table width=100%><tr><td>";


  if(is_array($actions_checks)){


  $c=0;
 for($i=0; $i < count($actions_checks);$i++) {

        $keyvalue = current($actions_checks);

if($c==3){
	print "</td><td>" ;
	$c=0;
	}

print "<input  name=\"pages[$i]\" type=\"checkbox\" value=\"$keyvalue\" checked>".key($actions_checks)."<br>";


$c++ ;

 next($actions_checks);
}
}
       print"</tr></table> <tr>
                <td colspan=\"2\" align=center>

                <input type=\"submit\" value=\"$phrases[add_button]\"></td>
        </tr>
</table>
        </form></center><br>";

 $qr= db_query("select * from news_banners order by type , ord");
    print "
  <center>
  <table width=70% class=grid>

  <tr>
  <td></td>
  <td><b>$phrases[the_title]</b></td>

  <td><b>$phrases[the_order]</b></td>
  <td><b>$phrases[bnr_appearance_places]</b></td>
  <td><b>$phrases[bnr_the_menu]</b></td>
  <td><b>$phrases[bnr_appearance_count]</b></td>
   <td><b>$phrases[bnr_the_visits]</b></td>

  <td></td>
  <td></td>
  </tr>
  ";
  while($data=db_fetch($qr)){

  print "<tr>";
  if($data['c_type']=="code"){
  	print "<td><img src='images/code_icon.gif' alt='$phrases[bnr_ctype_code]'></td>";
  	}else{
  		print "<td><img src='images/image_icon.gif' alt='$phrases[bnr_ctype_img]'></td>";
  		}

  print "<td>$data[title]</td>

   <td>$data[ord]</td>
   <td>$data[type]</td>
   <td> ";
   if($data['type'] == "menu"){
   print str_replace("r","$phrases[right]",str_replace("l","$phrases[left]",str_replace("c","$phrases[center]",$data['menu_pos'])));
   }else{
           print "-" ;
           }
           print "</td>
     <td>$data[views]</td>
       <td>$data[clicks]</td>
    <td><a href='index.php?action=adv2_edit&id=$data[id]'>$phrases[edit]</a></td>
    <td><a href='index.php?action=adv2_del&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a></td>
  </tr>" ;

      }
       print "</table></center>\n";
          }

   //----------------------------------------------------------
   if ($action == "adv2_edit"){
    if_admin("adv");

$id = intval($id);

        $data=db_qr_fetch("select * from news_banners where id='$id'");

          print " <script src='js.js' type=\"text/javascript\" language=\"javascript\"></script>


           <center><table width=\"70%\" class=grid>
        <tr>

                <form name=sender method=\"POST\" action=\"index.php\">
                 <input type='hidden' value='adv2_edit_ok' name='action'>
                  <input type='hidden' value='$id' name='id'>

                         <td height=\"13\" width=\"131\">
                       $phrases[the_name]<td height=\"13\" width=\"308\">
                <input type=\"text\" name=\"title\" value='$data[title]' size=\"38\"></td>
        </tr>";

        if($data['c_type']=="code"){$chk2 = "checked";$chk1="";}else{$chk1="checked";$chk2="";}

         print "<tr>
                   <td >
                      $phrases[the_content_type] <td >
               <input name=\"c_type\" type=\"radio\" value=\"img\" $chk1 onClick=\"show_banner_img();\" > $phrases[bnr_ctype_img]  <br>
               <input name=\"c_type\" type=\"radio\" value=\"code\" $chk2 onClick=\"show_banner_code();\"> $phrases[bnr_ctype_code]
                </td>
        </tr>";
        if($data['c_type']=="code"){
         print "<tr id=banners_url_area style=\"display: none; text-decoration: none\">";
         }else{
          print "<tr id=banners_url_area>";
         	}
                print "<td >$phrases[the_url]</td>
                <td >
                <input type=\"text\" name=\"url\"  dir=ltr value='$data[url]' size=\"38\"></td>
        </tr>";
        if($data['c_type']=="code"){
        print "<tr id=banners_img_area style=\"display: none; text-decoration: none\">";
        }else{
        	 print "<tr id=banners_img_area>";
        }
                print "<td >$phrases[the_image]</td>
                <td >
                <input type=\"text\" name=\"img\" dir=ltr  value='$data[img]' size=\"38\"></td>
        </tr>";
if($data['c_type']=="code"){
print "<tr id=banners_code_area>";
}else{
print "<tr id=banners_code_area style=\"display: none; text-decoration: none\">";
	}
print " <td>$phrases[the_code] </td>
<td>
<textarea dir=ltr rows=\"8\" name=\"content\" cols=\"50\">$data[content]</textarea>
</td></tr>



        <tr>
                <td height=\"45\" width=\"131\">$phrases[bnr_appearance_places]</td>
                <td height=\"45\" width=\"308\"><select name=\"type\" size=\"1\" onclick=\"show_adv_options(this)\">
             ";
             if($data['type']=="header"){
                     $opt1 = "selected" ; }elseif($data['type']=="footer"){
                             $opt2="selected" ; }elseif($data['type']=="open"){ $opt3="selected" ;}
                             elseif($data['type']=="close"){ $opt4="selected" ;}else{$opt5="selected" ; }

                print "
                <option value=\"header\" $opt1>$phrases[bnr_header]</option>
                <option value=\"footer\" $opt2>$phrases[bnr_footer]</option>
                   <option value=\"open\" $opt3>$phrases[bnr_open]</option>
                 <option value=\"close\" $opt4>$phrases[bnr_close]</option>
                 <option value=\"menu\" $opt5>$phrases[bnr_menu]</option>

                </select></td>\n";

       print " </tr>
        <tr>
                <td>";
                if($data['type']=="menu"){print "<div id=add_after_menu>";}else{
                	print "<div id=add_after_menu style=\"display: none; text-decoration: none\">";
                	}
               print " $phrases[add_after_menu_number]  </div></td>
                <td>";
                if($data['type']=="menu"){ print "<div id=add_after_menu2>";}else{
                print "<div id=add_after_menu2 style=\"display: none; text-decoration: none\">";
                	}
                print "<input type=\"text\" value='$data[menu_id]' name=\"menu_id\" value='0' size=\"4\">  $phrases[bnr_menu_pos]
                <select name=\"menu_pos\" size=\"1\">
             ";

             if($data['menu_pos']=="r"){$opt11 = "selected" ; }elseif($data['menu_pos']=="c"){$opt21="selected" ; }else{ $opt31="selected" ;}

                print "
                <option value=\"r\" $opt11>$phrases[right]</option>
                <option value=\"c\" $opt21>$phrases[center]</option>
                 <option value=\"l\" $opt31>$phrases[left]</option>

                </select></td>

                </tr>

                <tr>
                <td height=\"43\" width=\"131\">$phrases[the_order]</td>
                <td height=\"43\" width=\"308\"><input type=\"text\" value='$data[ord]' name=\"ord\" value='0' size=\"4\"></td>
                </tr>
                <tr><td>  $phrases[bnr_appearance_pages]</td><td><table width=100%><tr><td>";

                         $pages_view = explode(",",$data['pages']);


  if(is_array($actions_checks)){

  $c=0;
 for($i=0; $i < count($actions_checks);$i++) {

        $keyvalue = current($actions_checks);

if($c==3){
	print "</td><td>" ;
	$c=0;
	}

if(in_array($keyvalue,$pages_view)){$chk = "checked" ;}else{$chk = "" ;}

print "<input  name=\"pages[$i]\" type=\"checkbox\" value=\"$keyvalue\" $chk>".key($actions_checks)."<br>";


$c++ ;

 next($actions_checks);
}
}



                          print "</tr></table>
        <tr>
                <td height=\"21\" colspan=\"2\">
                <p align=\"center\">
                <input type=\"submit\" value=\"$phrases[edit]\" name=\"B1\"></td>
        </tr>
</table>
        </form></center>\n
             ";

           }

//--------------------- Templates ----------------------------------

  if($action =="templates" || $action =="template_edit_ok" || $action=="template_del" || $action =="template_add_ok"){

 if_admin("templates");

  if($action =="template_edit_ok"){
   $title = htmlspecialchars($title);


      db_query("update news_templates set title='".db_clean_string($title,"code")."',content='".db_clean_string($content,"code")."' where id='$id'");
          }

          if($action =="template_add_ok"){
              $title = htmlspecialchars($title);
               $name = htmlspecialchars($name);

                //  $content = htmlspecialchars($content);
      db_query("insert into  news_templates (name,title,content) values('".db_clean_string($name,"code")."','".db_clean_string($title,"code")."','".db_clean_string($content,"code")."')");
          }

  if($action=="template_del"){
      db_query("delete from news_templates where id='$id' and protected=0");
      db_query("update news_blocks set template=0 where template='$id'");
          }

          print "<center>
  <p class=title>  $phrases[the_templates] </p>
  <table width=80% class=grid>
  <tr><td colspan=3 align=center><a href='index.php?action=template_add'> $phrases[cp_add_new_template] </a></td></tr>
  <tr><td width=5></td><td align=center><b> $phrases[the_name] </b></td><td align=center><b> $phrases[the_description] </b></td><td></td></tr>" ;

  $qr = mysql_query("select * from news_templates order by id asc");


    while($data=mysql_fetch_array($qr)){
    print "<tr><td width=5>";
    if($data['type']=="html"){
    	print "<img src='images/html_icon.gif' alt='html code'>";
    	}elseif($data['type']=="php"){
    		print "<img src='images/php_icon.gif' alt='php code'>";
    		}
    print "</td><td align=center>$data[name]</td><td align=center>$data[title]</td>
    <td align=center> <a href='index.php?action=template_edit&id=$data[id]'> $phrases[edit] </a>";
    if($data['protected']==0){
            print " - <a href='index.php?action=template_del&id=$data[id]' onclick=\"return confirm('$phrases[are_you_sure]');\">$phrases[delete]</a>";
            }
            print "</td></tr>";

     }
      print "</table>";

          }
//--------------------- edit Template --------------------------
          if($action=="template_edit"){
                  if_admin("templates");
      $qr = mysql_query("select * from news_templates where id='$id'");
      if(db_num($qr)){
      $data = db_fetch($qr);
    $data['content'] = htmlspecialchars($data['content']);
print "
  <center>
          <span class=title>$phrases[cp_edit_templates] - $data[name] </span>  <br><br>
  <form method=\"POST\" action=\"index.php\">
  <input type='hidden' name='action' value='template_edit_ok'>
  <input type='hidden' name='id' value='$data[id]'>
  <table width=80% class=grid><tr>
  <td> <b> $phrases[the_name] : </b></td><td>$data[name]</td></tr>
  <tr>
  <td> <b> $phrases[the_description] : </b></td><td><input type=text size=30 name=title value='$data[title]'></td></tr>
   <tr><td colspan=2 align=center>
<textarea dir=ltr rows=\"20\" name=\"content\" cols=\"70\">$data[content]</textarea></td></tr>
        <tr><td colspan=2 align=center>
        <input type=\"submit\" value=\"$phrases[edit]\" name=\"B1\"></td></tr>
        </table>
</form></center>\n";
}else{
        print "<center>  $phrases[err_wrong_url] </center>";
        }
 }

// ------------- Add Template ------------------------
  if($action=="template_add"){
                  if_admin("templates");

print "
  <center>
          <span class=title>$phrases[cp_add_new_template]</span>  <br><br>
  <form method=\"POST\" action=\"index.php\">
  <input type='hidden' name='action' value='template_add_ok'>
  <input type='hidden' name='id' value='$data[id]'>
  <table width=80% class=grid><tr>
  <td> <b>$phrases[the_name] : </b></td><td><input type=text size=30 name=name></td></tr>
  <tr>
  <td> <b> $phrases[the_description] : </b></td><td><input type=text size=30 name=title></td></tr>
   <tr><td colspan=2 align=center>
<textarea dir=ltr rows=\"20\" name=\"content\" cols=\"70\"></textarea></td></tr>
        <tr><td colspan=2 align=center>
        <input type=\"submit\" value=\"$phrases[add_button]\" name=\"B1\"></td></tr>
        </table>
</form></center>\n";

 }
 //----------------------- Settings --------------------------------
 if($action == "settings" || $action=="settings_edit"){
 if_admin();

 if($action=="settings_edit"){

  if(is_array($stng)){
 for($i=0;$i<count($stng);$i++) {

        $keyvalue = current($stng);

        db_query("update news_settings set value='$keyvalue' where name='".key($stng)."'");

 next($stng);
}
}

         }

 load_settings();

 print "<center>
 <p align=center class=title>  $phrases[the_settings] </p>
 <form action=index.php method=post>
 <input type=hidden name=action value='settings_edit'>
 <table width=70% class=grid>
 <tr><td>  $phrases[cp_the_sitename] : </td><td><input type=text name=stng[sitename] size=30 value='$settings[sitename]'></td></tr>
 <tr><td>  $phrases[cp_the_section_name] : </td><td><input type=text name=stng[section_name] size=30 value='$settings[section_name]'></td></tr>
  <tr><td>  $phrases[cp_copyrights_sitename] : </td><td><input type=text name=stng[copyrights_sitename] size=30 value='$settings[copyrights_sitename]'></td></tr>
 <tr><td> $phrases[cp_the_page_dir] : </td><td><select name=stng[html_dir]>" ;
 if($settings['html_dir'] == "rtl"){$chk1 = "selected" ; $chk2=""; }else{ $chk2 = "selected" ; $chk1="";}
 print "<option value='rtl' $chk1>$phrases[right_to_left]</option>
 <option value='ltr' $chk2>$phrases[left_to_right]</option>
 </select>
 </td></tr>
  <tr><td>  $phrases[cp_header_keywords] : </td><td><input type=text name=stng[header_keywords] size=30 value='$settings[header_keywords]'></td></tr>
  </table>
   <br>
   <table width=70% class=grid>
  <tr><td>  $phrases[cp_enable_browsing]</td><td><select name=stng[enable_browsing]>";
  if($settings['enable_browsing']=="1"){$chk1="selected";$chk2="";}else{$chk1="";$chk2="selected";}
  print "<option value='1' $chk1>$phrases[cp_opened]</option>
  <option value='0' $chk2>$phrases[cp_closed]</option>
  </select></td></tr>
  <tr><td>$phrases[cp_browsing_closing_msg]</td><td><textarea cols=30 rows=5 name=stng[disable_browsing_msg]>$settings[disable_browsing_msg]</textarea>
  </td></tr>
   </table>
   <br>
  <table width=70% class=grid>
  <tr><td> $phrases[cp_statics_system] </td><td><select name=stng[statics_system_enable]>";
  if($settings['statics_system_enable']=="1"){$chk1="selected";$chk2="";}else{$chk1="";$chk2="selected";}
  print "<option value='1' $chk1>$phrases[enabled]</option>
  <option value='0' $chk2>$phrases[disabled]</option>
  </select></td></tr>
  <tr><td>$phrases[cp_count_online_visitors] </td><td><select name=stng[online_visitors_enable]>";
  if($settings['online_visitors_enable']=="1"){$chk1="selected";$chk2="";}else{$chk1="";$chk2="selected";}
  print "<option value='1' $chk1>$phrases[enabled]</option>
  <option value='0' $chk2>$phrases[disabled]</option>
  </select></td></tr>
  </table>
  <br>
  <table width=70% class=grid>

  <tr><td>  $phrases[cp_add_news_fields_count] : </td><td><input type=text name=stng[news_add_limit] size=5 value='$settings[news_add_limit]'></td></tr>
  <tr><td>  $phrases[cp_news_perpage] : </td><td><input type=text name=stng[news_perpage] size=5 value='$settings[news_perpage]'></td></tr>
   <tr><td>  $phrases[cp_news_cells] : </td><td><input type=text name=stng[news_cells] size=5 value='$settings[news_cells]'></td></tr>
 <tr><td>  $phrases[news_votes_time_limit] : </td><td><input type=text name=stng[vote_file_expire_hours] size=5 value='$settings[vote_file_expire_hours]'> $phrases[hour] </td></tr>


<tr><td>  $phrases[votes_time_limit] : </td><td><input type=text name=stng[votes_expire_hours] size=5 value='$settings[votes_expire_hours]'> $phrases[hour] </td></tr>
<tr><td>  $phrases[cp_search_min_letters] : </td><td><input type=text name=stng[search_min_letters] size=5 value='$settings[search_min_letters]'>  </td></tr>

<tr><td> $phrases[uploader_thumb_width] : </td><td><input type=text name=stng[uploader_thumb_width] size=5 value='$settings[uploader_thumb_width]'> $phrases[pixel] </td></tr>
<tr><td>  $phrases[uploader_thumb_hieght]  : </td><td><input type=text name=stng[uploader_thumb_hieght] size=5 value='$settings[uploader_thumb_hieght]'> $phrases[pixel] </td></tr>

  ";

   //--------------- Load Settings Plugins --------------------------
$dhx = opendir(CWD ."/plugins");
while ($rdx = readdir($dhx)){
         if($rdx != "." && $rdx != "..") {
                 $cur_fl = CWD ."/plugins/" . $rdx . "/settings.php" ;
        if(file_exists($cur_fl)){
        print "<tr><td colspan=2 height=1 background='images/dot.gif'></td></tr>";

                include $cur_fl ;


                }
          }

    }
closedir($dhx);
//----------------------------------------------------------------

  print "</table>
  <br>
  <table width=70% class=grid>
  <tr><td>  $phrases[cp_uploader_system] : </td><td><select name=stng[uploader]>" ;
 if($settings['uploader']){$chk1 = "selected" ; $chk2=""; }else{ $chk2 = "selected" ; $chk1="";}
 print "<option value=1 $chk1>$phrases[enabled]</option>
 <option value=0 $chk2>$phrases[disabled]</option>
 </select>
 </td></tr>
 <tr><td> $phrases[cp_uploader_disable_msg]  : </td><td><input type=text name=stng[uploader_msg] size=30 value='$settings[uploader_msg]'></td></tr>
 <tr><td>  $phrases[cp_uploader_path] : </td><td><input dir=ltr type=text name=stng[uploader_path] size=30 value='$settings[uploader_path]'></td></tr>
 <tr><td>  $phrases[cp_uploader_allowed_types] : </td><td><input dir=ltr type=text name=stng[uploader_types] size=30 value='$settings[uploader_types]'></td></tr>


 <tr><td colspan=2 align=center><input type=submit value=' $phrases[edit] '></td></tr>
 </table></center>" ;

         }


//------------------- DATABASE BACKUP --------------------------
if($action=="backup_db_do"){
print "<br><center> <table width=50% class=grid><tr><td align=center>  $output </td></tr></table>";
}

  if($action=="backup_db"){

   if_admin();
      print "<br><center>
      <p align=center class=title> $phrases[cp_db_backup] </p>

      <form action=index.php method=post>
      <input type=hidden name=action value='backup_db_do'>
      <table width=50% class=grid><tr><td>
      <input type=\"radio\" name=op value='local' checked onclick=\"document.getElementById('backup_server').style.display = 'none';\"> $phrases[db_backup_saveto_pc]
      <br><input type=\"radio\" name=op value='server' onclick=\"document.getElementById('backup_server').style.display = 'inline';\" > $phrases[db_backup_saveto_server]
      </td></tr>
      <tr><td>
      <div id=backup_server style=\"display: none; text-decoration: none\">
      <b> $phrases[the_file_path] : &nbsp; </b> <input type=text name=filename dir=ltr size=40 value='admin/backup/news_".date("d-m-Y-h-i-s").".sql.gz'>
      </div>
     </td></tr><tr> <td align=center>
      <input type=submit value=' $phrases[cp_db_backup_do] '>
      </form></td></tr></table></center>";

          }


 // ----------------- Repair Database -----------------------

if($action=="db_info"){

if(!$disable_repair){
print "<script language=\"JavaScript\">\n";
print "function checkAll(form){\n";
print "  for (var i = 0; i < form.elements.length; i++){\n";
print "    eval(\"form.elements[\" + i + \"].checked = form.elements[0].checked\");\n";
print "  }\n";
print "}\n";
print "</script>\n";

		$tables = db_query("SHOW TABLE STATUS");
		print "<form name=\"form1\" method=\"post\" action=\"index.php\"/>
		<input type=hidden name=action value='repair_db_ok'>
		<center><table width=\"80%\"  class=grid>";
		print "<tr><td colspan=\"5\"> <font size=4><b>$phrases[the_database]</b></font> </td></tr>
		<tr><td>
		<input type=\"checkbox\" name=\"check_all\" checked=\"checked\" onClick=\"checkAll(this.form)\"/></td>
		";
		print "<td><b>$phrases[the_table]</b></td><td><b>$phrases[the_size]</b></td>
		<td><b>$phrases[the_status]</b></td>
			</tr>";
		while($table = db_fetch($tables))
		{
			$size = round($table['Data_length']/1024, 2);
			$status = db_qr_fetch("ANALYZE TABLE `$table[Name]`");
			print "<tr>
			<td  width=\"5%\"><input type=\"checkbox\" name=\"check[]\" value=\"$table[Name]\" checked=\"checked\" /></td>
			<td width=\"50%\">$table[Name]</td>
			<td width=\"10%\" align=left dir=ltr>$size KB</td>
			<td>$status[Msg_text]</td>
			</tr>";
		}

		print "</table><br> <center><input type=\"submit\" name=\"submit\" value=\"$phrases[db_repair_tables_do]\" /></center> <br>
		</form>";
		}else{
			print  "<center> $disable_repair </center>" ;
			}
	}
//------------------------------------------------
	if($action=="repair_db_ok"){

	if(!$disable_repair){
		if(!$check){
			print "<center><table width=50% class=grid><tr><td align=center> $phrases[pleas_select_tables_to_rapair] </td></tr></table></center>";
	}else{
		$tables = $_POST['check'];
		print "<center><table width=\"60%\"  class=grid>";

		foreach($tables as $table)
		{
			$query = db_query("REPAIR TABLE `". $table . "`");
			$que = db_fetch($query);
			print "<tr><td width=\"20%\">";
			print "$phrases[cp_repairing_table] " . $que['Table'] . " , <font color=green><b>$phrases[done]</b></font>";
			print "</td></tr>";
		}

		print "</table></center>";

		}

		}else{
			print  "<center> $disable_repair </center>" ;
			}
	}
//---------------------------------- Statics ---------------------
if($action=="statics"){
        if_admin();


                if($op){
     print "<center><table width=50% class=grid>
<tr><td><ul>";
  foreach($op as $opx){
 //---------------------
 if($opx=="statics_rest"){
        db_query("delete from info_hits");
        db_query("update info_browser set count=0");
        db_query("update info_os set count=0");
        db_query("update info_best_visitors  set v_count=0");
        print "<li>$phrases[visitors_statics_rest_done]</li>" ;
                }
  if($opx=="news_views"){

        db_query("update news_news set views=0");

        print "<li>$phrases[news_statics_rest_done]</li>" ;
                }


    if($opx=="news_votes"){

        db_query("update news_news set votes=0");
        db_query("update news_news set votes_total=0");

        print "<li>$phrases[news_votes_rest_done]</li>" ;
                }
 //---------------------
          }
          print "</ul></td></tr></table>";
          }
$data_frstdate = db_qr_fetch("select * from info_hits order by date asc limit 1");
 if(!$data_frstdate['date']){$data_frstdate['date']= "$phrases[cp_not_available]"; }
 $qr_total=db_query("select hits from info_hits");
 $total_hits = 0 ;
 while($data_total = db_fetch($qr_total)){
 $total_hits += $data_total['hits'];
         }

print "<center><p class=title> $phrases[cp_visitors_statics] </p>
<table width=50% class=grid>
<tr><td><b>$phrases[cp_counters_start_date] </b></td><td>$data_frstdate[date]
</td></tr>
<tr><td><b> $phrases[cp_total_visits] </b></td><td>$total_hits
</td></tr>
</table>
<br>
 <p class=title> $phrases[cp_rest_counters] </p>
<form action='index.php' method=post onSubmit=\"return confirm('$phrases[are_you_sure]');\">
<input type=hidden name=action value='statics'>
<table width=50% class=grid><tr><td>
<input type='checkbox' value='statics_rest'  name='op[]' >$phrases[cp_visitors_statics]   <br>
<input type='checkbox' value='news_views'  name='op[]' >$phrases[cp_news_view_statics]  <br>
<input type='checkbox' value='news_votes'  name='op[]' >$phrases[cp_news_votes_statics]   <br>

<br>


</td></tr><tr><td align=center>
<input type=submit value=' $phrases[cp_rest_counters_do] '>
</table></center>
</form>";
        }
//------------------------------------- Selected News  Menu ------------------------------
if($action=="new_menu" || $action=="new_menu_add" || $action=="new_menu_del"){
       if_admin("new_menu");


if($action=="new_menu_add"){
	$news_id = intval($news_id);
$data_ex = db_qr_fetch("select count(id) as count from news_news where id='$news_id'");
if($data_ex['count']){
        db_query("insert into news_new_menu (news_id) values ('$news_id')");
        }else{
        print "<br><center>  $phrases[err_wrong_news_id] </center><br>";
                }
        }
if($action=="new_menu_del"){
 db_query("delete from news_new_menu where id='$id'");
  }

  print "<center>
  <form action=index.php method=post>
  <input type=hidden name=action value='new_menu_add'>
  <table width=80% class=grid><tr>
  <td align=center>
  <b>$phrases[cp_news_id] : </b><input type=text name=news_id size=5>
  <input type=submit value='$phrases[add_button]'></td></tr></table></form>
              <br>
          <table width=80% class=grid>";
$qr=db_query("select * from news_new_menu order by id DESC");
while($data = db_fetch($qr)){

        $qr2=db_query("select title from news_news where id='$data[news_id]'");
         if(db_num($qr2)){
                 $data2 = db_fetch($qr2);
        print "<tr><td width=70%>$data2[title]</td>
      <td><a href=\"index.php?action=new_menu_del&id=$data[id]\" onClick=\"return confirm('$phrases[are_you_sure]');\">$phrases[delete]</a></td>
       </tr>
       ";
        }else{
        db_query("delete from news_new_menu where id='$data[id]'");
                }
        }
        print "</table></center>";
        }
//------------------------------ Phrases -------------------------------------
if($action=="phrases" || $action=="phrases_update"){

if_admin("phrases");

$cat = intval($cat);

if($action=="phrases_update"){
        $i = 0;
        foreach($phrases_ids  as $id){
        db_query("update news_phrases set value='$phrases_values[$i]' where id='$phrases_ids[$i]'");

        ++$i;
                }
                }

if($group){
  $group = htmlspecialchars($group);
$cat_data = db_qr_fetch("select name from news_phrases_cats where id='$group'");

print "<p align=$global_align><img src='images/link.gif'><a href='index.php?action=phrases'>$phrases[the_phrases] </a> / $cat_data[name]</p>";


         $qr = db_query("select * from news_phrases where cat='$group'");
        if (db_num($qr)){

        print "<form action=index.php method=post>
        <input type=hidden name=action value='phrases_update'>
        <input type=hidden name=group value='$group'>
        <center><table width=60% class=grid>";

        $i = 0;
        while($data=db_fetch($qr)){
         print "<tr onmouseover=\"set_tr_color(this,'#EFEFEE');\" onmouseout=\"set_tr_color(this,'#FFFFFF');\"><td>$data[name]</td><td>
         <input type=hidden name=phrases_ids[$i] value='$data[id]'>
         <input type=text name=phrases_values[$i] value='$data[value]' size=30>
         </td></tr> ";
         ++$i;
                }
                print "<tr><td colspan=2 align=center><input type=submit value=' $phrases[edit] '></td></tr>
                </table></form></center>";
                }else{
                	 print "<center><table width=60% class=grid><tr><td align=center> $phrases[cp_no_phrases] </td></tr></table></center>";
                	 }

}else{
print "<p class=title align=center> $phrases[the_phrases] </p><br>  ";
	$qr = db_query("select * from news_phrases_cats order by id asc");
	 print "<center><table width=60% class=grid>";
	while($data =db_fetch($qr)){
	print "<tr><td><a href='index.php?action=phrases&group=$data[id]'>$data[name]</a></td></tr>";
	}
	print "</table></center>";
}
                }
//-----------------------------------------------------------------------------


//--------------- Load Admin Plugins --------------------------
$dhx = opendir(CWD ."/plugins");
while ($rdx = readdir($dhx)){
         if($rdx != "." && $rdx != "..") {
                 $cur_fl = CWD ."/plugins/" . $rdx . "/admin.php" ;
        if(file_exists($cur_fl)){
                include $cur_fl ;
                }
          }

    }
closedir($dhx);
//------------------------------------------------
?>
</td></tr></table>
<?

}else{

if($global_lang=="arabic"){
$global_dir = "rtl" ;
print "<html dir=$global_dir>
<META http-equiv=Content-Type content=\"text/html; charset=windows-1256\">
<title>$sitename - ·ÊÕ… «· Õﬂ„ </title>" ;
}else{
$global_dir = "ltr" ;
print "<html dir=$global_dir>
<META http-equiv=Content-Type content=\"text/html; charset=windows-1252\"> 
<title>$sitename - Control Panel </title>" ;
}


print "<link href=\"smiletag-admin.css\" type=text/css rel=stylesheet>
<center>
<br>
<table width=60% class=grid><tr><td align=center>

<form action=\"index.php\" method=\"post\"\">
                 <table><tr><td><img src='images/users.gif'></td><td>

                <table dir=$global_dir cellpadding=\"0\" cellspacing=\"3\" border=\"0\">
                <tr>
                        <td class=\"smallfont\">$phrases[cp_username]</td>
                        <td><input type=\"text\" class=\"button\" name=\"username\"  size=\"10\" tabindex=\"1\" ></td>
                        <td class=\"smallfont\" colspan=\"2\" nowrap=\"nowrap\"></td>
                </tr>
                <tr>
                        <td class=\"smallfont\">$phrases[cp_password]</td>
                        <td><input type=\"password\"  name=\"password\" size=\"10\" tabindex=\"2\" /></td>
                        <td>
                        <input type=\"submit\" class=\"button\" value=\"$phrases[login_do]\" tabindex=\"4\" accesskey=\"s\" /></td>
                </tr>

</td>
</tr>
                </table>
                <input type=\"hidden\" name=\"s\" value=\"\" />
                <input type=\"hidden\" name=\"action\" value=\"login\" />
                </td></tr></table>
                </form> </td></tr></table>
                </center>\n";


if(COPYRIGHTS_TXT_ADMIN_LOGIN){
if($global_lang=="arabic"){
	print "<br>
                <center>
<table width=60% class=grid><tr><td align=center>
  Ã„Ì⁄ ÕﬁÊﬁ «·»—„Ã… „Õ›ÊŸ… <a href='http://allomani.com' target='_blank'> ··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </a>  © 2008
</td></tr></table></center>";
}else{
print "<br>
                <center>
<table width=60% class=grid><tr><td align=center>
  Copyright © 2008 <a href='http://allomani.com' target='_blank'>Allomani&trade;</a>  - All Programming rights reserved
</td></tr></table></center>";
}
}

if(file_exists("demo_msg.php")){
include_once("demo_msg.php");
}
}
?>