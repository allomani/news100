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

include_once(CWD . "/global.php") ;
echo "<html dir=$global_dir>\n";
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
<meta http-equiv="Content-Language" content="ar-sa">
<? print "<title>$phrases[uploader_title]</title>\n";?>
<link href="smiletag-admin.css" type=text/css rel=stylesheet>
<center>
<br>
<table width=90% class=grid>
<tr><td align=center>
<?
if (check_login_cookies()) {

if($_FILES['datafile']['name'] && $folder && f_name){
   $upload_folder = $settings['uploader_path']."/$folder" ;


      if(!$upload_folder || !file_exists(CWD ."/$upload_folder")){die ("<br><center>$phrases[err_wrong_uploader_folder]</center>");}

                   $fileinfo= pathinfo($_FILES['datafile']['name']);
                $imtype = strtolower($fileinfo["extension"]);

    if(in_array($imtype,$upload_types) && !strchr($_FILES['datafile']['name'],".php")){

            $filename = strtolower($_FILES['datafile']['name']);
            $filename= str_replace(".$imtype","",$filename);
            $filename= str_replace(" ","_",$filename);

            if(file_exists(CWD . "/$upload_folder/".convert2en($filename).".$imtype")){$filename .= "_".rand(0,9999).rand(0,9999);}
            $filename .= ".$imtype" ;

$saveto_filename = "$upload_folder/".convert2en($filename) ;

move_uploaded_file($_FILES['datafile']['tmp_name'], CWD . "/". $saveto_filename);


if($resize){
	$thumb_saved =  create_thumb($saveto_filename,$settings['uploader_thumb_width'],$settings['uploader_thumb_hieght'],CWD);
 	 @unlink(CWD . "/". $saveto_filename);
 	 $saveto_filename =   $thumb_saved ;
	}

 if($default_uploader_chmod){@chmod(CWD . "/". $saveto_filename,$default_uploader_chmod);}

print "<script>
";

if($frm){
print "opener.document.forms['{$frm}'].elements['" . $f_name . "'].value = \"".$saveto_filename."\"     " ;
        }else{
print "opener.document.forms['sender'].elements['" . $f_name . "'].value = \"".$saveto_filename."\" ";
   }
print "
window.close();

</script>\n";

           }else{
                   print "<center>$phrases[this_filetype_not_allowed]</center>";
                   }
       ?>


<?
}else{

if($settings['uploader']){

$folder = htmlspecialchars($folder);
$f_name = htmlspecialchars($f_name);
$frm = htmlspecialchars($frm);

print "<form action='uploader.php' method=post enctype=\"multipart/form-data\">
<input type=hidden name=folder value='$folder'>
<input type=hidden name=f_name value='$f_name'>
<input type=hidden name=frm value='$frm'>
<b> $phrases[the_file]  : </b><input type=file dir=ltr size=25 name=datafile>";
if($f_name=="img"){
print "<br><input name='resize' type=checkbox value='1'>  $phrases[auto_photos_resize]  <font dir=ltr><i>($settings[uploader_thumb_width] x $settings[uploader_thumb_hieght])</i></font>
          <br><br>";
          }
print "<input type=submit value=' $phrases[upload_file_do] '>
</form>\n ";

$count = count($upload_types);
for ($i=0; $i<$count; $i++) {
$allowed_types .= "$upload_types[$i] &nbsp;";
}

print "<br>
$phrases[allowed_filetypes] :
<font color='#CE0000'>$allowed_types</font>\n";



}else{
        print "<center>  $settings[uploader_msg] </center> " ;
        }
        }
}else{
print "<center>$phrases[please_login_first]</center>";
     }

     ?>
     </td></tr></table>
     <html>