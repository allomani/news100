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
//----------- photos edit form ----------------

if($action=="photos_edit_file"){

if_admin("photos");

$id = intval($id);
	$qr = db_query("select * from photos_data where id='$id'");
	if(db_num($qr)){
		$data = db_fetch($qr);
print "<form action=index.php method=post>
<center>
<table width=50% class=grid><tr><td align=center>
<input name=action value='photos_edit_file_ok' type=hidden>
<input name=id value='$id' type=hidden>
<input name=cat value='$data[cat]' type=hidden>
<img src='".get_image($data['thumb'])."'><br>
<input type=text size=20 name=name value=\"$data[name]\"><br>
<input type=submit value=' $phrases[edit] '>
</td></tr></table></center>
</form>";               }else{
	print "<center><table width=50% class=grid><tr><td align=center> $phrases[err_wrong_url] </td></tr></table></center>" ;
	}


}
//------------------------------------- photos -----------------------------------
 if($action=="photos" or $action=="photos_add_ok" or $action=="photos_del_file" or $action=="photos_cats" or $action=="photos_del_cat" or $action=="photos_edit_cat_ok" || $action=="photos_edit_file_ok"){

if_admin("photos");

if (!$cat){$cat=0;}

//============================================
 if ($action=="photos_del_cat"){
              if($id){
            $delete_array = get_photos_cats($id);
  foreach($delete_array as $id_del){
     db_query("delete from photos_cats where id='$id_del'");
     db_query("delete from photos_data where cat='$id_del'");
     }

                     }
                }
//=============================================
if ($add_cat){

         mysql_query("insert into photos_cats(name,cat,img) values('$name','$cat','$img')");

        }
 //================================================
 if($action=="photos_edit_cat_ok"){

       mysql_query("update photos_cats set name='$name',img='$img' where id='$id'");
         }
//--------------------------- File Delete Query ------------------------------------
if($action=="photos_del_file"){
 $data = db_qr_fetch("select img,thumb from photos_data where id='$id'");

 if(!file_exists(CWD . "/demo_msg.php")){
 if(file_exists(CWD . "/" . $data['img'])){@unlink(CWD . "/" . $data['img']);}
 if(file_exists(CWD . "/" . $data['thumb'])){@unlink(CWD . "/" . $data['thumb']);}
 }
         db_query("delete from photos_data where id='$id'");
         }
 // ----------------------- File Edit Query ------------
 if($action=="photos_edit_file_ok"){
 db_query("update photos_data set name='$name' where id='$id'");

 	}
//------------------------ File Add Query ----------------------------------
  if($action=="photos_add_ok"){


  $limit =  count($_FILES['photo_file']['name']);
  $err_cnt = 0  ;
for($i=0;$i<=$limit;$i++){

if($_FILES['photo_file']['name'][$i]){

                $fileinfo= pathinfo($_FILES['photo_file']['name'][$i]);
                $imtype = strtolower($fileinfo["extension"]);
    $photos_ext_accept = array('jpg','gif','png');

     if(in_array(strtolower($imtype),$photos_ext_accept)){

     $file_saved =  save_file($_FILES['photo_file']['name'][$i],$_FILES['photo_file']['tmp_name'][$i],"photos",CWD);
    if(is_error($file_saved)){
       $err_msg .= "<b> $phrases[error] : </b> $phrases[the_file]  ".$_FILES['photo_file']['name'][$i]."  : ".get_err_msg($file_saved)." <br>" ;
       }else{
        $thumb_saved =  create_thumb($file_saved,$settings['photos_thumb_width'],$settings['photos_thumb_hieght'],CWD);
      db_query("insert into photos_data (name,img,thumb,cat,date) values('$name[$i]','$file_saved','$thumb_saved','$cat',now())");

               }
     }else{
    $err_msg .= "<b> $phrases[error] : </b> $phrases[the_file]  ".$_FILES['photo_file']['name'][$i]."  : $phrases[this_filetype_not_allowed] <br>" ;

             }
        }

        }

if($err_msg){
print $err_msg ;
        }

         }
//-----------------------------------------------------------------------------


print "<center>
           <p class=title>$phrases[add_cat]</p>
                <table border=0 width=\"70%\"  class=grid style=\"border-collapse: collapse\"><tr>

                <form method=\"POST\" action=\"index.php\" name=sender>

                      <input type=hidden name=\"action\" value='photos_cats'>
                      <input type=hidden name=\"cat\" value='$cat'>
                      <input type=hidden name=\"add_cat\" value=1>

                        <tr>
                                <td width=\"50\">
                <b>$phrases[the_name]</b></td><td >
                <input type=\"text\" name=\"name\" size=\"30\"></td>
                        </tr>
                        <tr>
                                 <tr> <td >
                <b>$phrases[the_image]</b></td>
                                <td>
                                <table><tr><td>
                                <input type=\"text\" name=\"img\" size=\"30\" dir=ltr>  </td><td> <a href=\"javascript:uploader('photos','img');\"><img src='images/file_up.gif' border=0 alt='$phrases[browse_and_upload_photo]'></a>
                                 </td></tr></table>
                                 </td></tr>





                               <tr> <td colspan=2 align=center>
              <input type=\"submit\" value=\"$phrases[add_button]\">
                        </td>
                        </tr>





                </table>
                </div>

</form>\n";

if($cat > 0){
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from photos_cats where id='$dir_data[cat]'");

        $dir_content = "<a href='index.php?action=photos_cats&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
        }

print "<p align=$global_align><img src='images/link.gif'><a href='index.php?action=photos_cats&cat=0'>$phrases[main_page] </a> / $dir_content</p>";
 print "<br><table width=70% class=grid><tr><td>";
       if($cat){
       $qr_title = db_qr_fetch("select name,img from photos_cats where id='$cat'");



       print "<center><img src='".get_image($qr_title['img'])."'><br>$qr_title[name]</center>" ;
            }

       $qr=mysql_query("select * from photos_cats where cat='$cat'")   ;


       if (mysql_num_rows($qr)){
           print "<center><p class=title>  $phrases[cats] </p>
                <div align='center'>
                <table border=\"0\"  width=100% style=\"border-collapse: collapse\"> \n";


         while($data= mysql_fetch_array($qr)){
     print "            <tr>
                <td ><a href='index.php?action=photos_cats&cat=$data[id]'>$data[name]</a></td>
                <td align=left><a href='index.php?action=photos_edit_cat&id=$data[id]&cat=$cat'>$phrases[edit] </a> - <a href='index.php?action=photos_del_cat&id=$data[id]&cat=$cat' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a></td>
        </tr>";

                 }

                print" </td></tr></table>\n";
                }else{
                        print "<center> $phrases[no_subcats]</center>";
                        }
     print "</td></tr></table>";

 //=============================================================================

if($cat){
print "<br><table width=70% class=grid><tr><td align=center>   " ;
print "<a href='index.php?action=photos_add&cat=$cat'>$phrases[click_here_to_add_photos]</a><br>";


$qr = mysql_query("select * from photos_data where cat='$cat'");

if (mysql_num_rows($qr)){
print " <center>
                <table border=0 width=\"100%\"  style=\"border-collapse: collapse\"><tr>";
                $c = 0 ;
while ($data =mysql_fetch_array($qr)){
if($c == 4){
        print "</tr><tr>";
        $c = 0 ;
        }
        $c++;

      print "
       <td align=center>
      <img src='".get_image($data['thumb'])."'><br>$data[name]<br>
           <a href='index.php?action=photos_edit_file&id=$data[id]'>$phrases[photos_edit_comment] </a> - <a href='index.php?action=photos_del_file&id=$data[id]&cat=$cat' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete] </a>

       </td>


      ";

        }
        print "</tr></table></center>";
         }else{
                 print "<center> $phrases[no_files] </center>";
                 }
                 print "</td></tr></table>" ;
                 }
                            }
//------------------------ Edit Cat Form ----------------------------------------------------
if($action == "photos_edit_cat"){
     if_admin("photos");
               $data = db_qr_fetch("select * from photos_cats where id='$id'");

              print "
                <div align=\"center\">
                <table border=0 width=\"70%\"  style=\"border-collapse: collapse\" class=grid><tr>

                <form method=\"POST\" action=\"index.php\" name=sender>

                      <input type=hidden name=\"id\" value='$id'>
                      <input type=hidden name=\"cat\" value='$cat'>
                      <input type=hidden name=\"action\" value='photos_edit_cat_ok'> ";


                  print "  <tr>
                                <td width=\"50\">
                <b>&#1575;&#1604;&#1575;&#1587;&#1605;</b></td><td>
                <input type=\"text\" name=\"name\" value='$data[name]' size=\"30\"></td>
                        </tr>
                                 <tr>
                                 <tr> <td >
                <b>$phrases[the_image]</b></td>
                                <td>
                                <table><tr><td>
                                <input type=\"text\" name=\"img\" size=\"30\" value='$data[img]' dir=ltr>  </td><td> <a href=\"javascript:uploader('photos','img');\"><img src='images/file_up.gif' border=0 alt='$phrases[browse_and_upload_photo]'></a>
                                 </td></tr></table>
                                 </td></tr>
                        ";




                              print " <tr> <td colspan=2 align=center>
              <input type=\"submit\" value=\"$phrases[edit]\">
                        </td>
                        </tr>





                </table>
                </div>
               ";

                      }
//------------------------------- Add Files ---------------------------------------------------
 if($action =="photos_add"){
      if_admin("photos");
if(!$add_limit){
$add_limit = $settings['photos_add_limit'] ;
  }

            $cat = intval($cat);

            if($cat > 0){
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from photos_cats where id='$dir_data[cat]'");

        $dir_content = "<a href='index.php?action=photos_cats&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;
        }
        }

print "<p align=right><img src='images/link.gif'><a href='index.php?action=photos_cats&cat=0'>$phrases[main_page] </a> / $dir_content</p>";

  $add_limit = intval($add_limit);

  print " <center>
  <form method=\"POST\" action=\"index.php\">

      <input type=\"hidden\" name=\"cat\" value='$cat'>
      <input type=hidden name=action value=photos_add>
      <table width=30% class=grid>
      <tr><td align=center> $phrases[fields_count] : <input type=text name=add_limit value='$add_limit' size=3>
      &nbsp;&nbsp;<input type=submit value='$phrases[edit]'></td></tr></table></form>

      <br>";



$cat = intval($cat);

print " <form method=\"POST\" name=\"sender\" action=\"index.php\" enctype=\"multipart/form-data\">\n";
print "<div align=\"center\">\n";
print "<input type=\"hidden\" name=\"action\" value=\"photos_add_ok\">\n";
print " <input type=\"hidden\" name=\"cat\" value=\"$cat\">\n";
print "\n";
print "\n";
print "<table border=\"1\" width=\"90%\" class=grid style=\"border-collapse: collapse\" >\n";
print "        <tr>\n";
print "                <td width=25%>\n";





                           print " <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">

                           <tr><td align=center colspan=3>$phrases[photos_allowed_types] : <b> jpg&nbsp;gif&nbsp;png</b> </td></tr>
                         <tr>  <td><b>#</b></td>
                            <td align=center><b>$phrases[the_file]</b></td><td align=center><b>$phrases[photos_the_comment]</b></td></tr>  ";
                   for ($i=1;$i<=$add_limit;$i++){

                                              print " <tr>



                                <td><b>$i.</b></td>
                                <td> <input type=\"file\" name=\"photo_file[$i]\"  dir=ltr size=80%></td><td>

                                <input type=\"text\" name=\"name[$i]\"   size=\"30\">

                               </td>
                                 </td>";
                                 }
                                 print "</table>";


                print  "</div>
                </td>
        </tr>
</table>

</div>

<p align=\"center\"><input type=\"submit\" value=\"$phrases[add_button]\" name=\"B1\"></p>
        </form>\n";


         }