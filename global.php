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
$version_number = "1.0" ; 
//-----------------------------
define("GLOBAL_LOADED",true);
//-----------------------------
if (!defined('CWD')){define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));}
//---------------------------------------------
require(CWD . "/config.php") ; 



$actions_list = array('main','browse','news','pages','search','statics','votes','vote_add');
$actions_text = "main,browse,news,pages,search,,statics,votes,vote_add";



//----------------- php5 varialbs support -----------------------------
$ver_str = phpversion();
list($php_major, $php_minor, $php_sub) = explode( ".", $ver_str);
if( intval($php_major) >= 5) {
$reg_long_arrays = ini_get('register_long_arrays');
if( $reg_long_arrays == 0 ) {

$HTTP_POST_VARS   = !empty($HTTP_POST_VARS)   ? $HTTP_POST_VARS   : $_POST;
$HTTP_GET_VARS    = !empty($HTTP_GET_VARS)    ? $HTTP_GET_VARS    : $_GET;
$HTTP_COOKIE_VARS = !empty($HTTP_COOKIE_VARS) ? $HTTP_COOKIE_VARS : $_COOKIE;
$HTTP_SERVER_VARS = !empty($HTTP_SERVER_VARS) ? $HTTP_SERVER_VARS : $_SERVER;
$HTTP_POST_FILES = !empty($HTTP_POST_FILES) ? $HTTP_SERVER_VARS : $_FILES;
$HTTP_ENV_VARS = !empty($HTTP_ENV_VARS) ? $HTTP_SERVER_VARS : $_ENV;

}
}


//--------- extract variabls -----------------------
 if (!empty($HTTP_POST_VARS)) {extract($HTTP_POST_VARS);}
if (!empty($HTTP_GET_VARS)) {extract($HTTP_GET_VARS);}
if (!empty($HTTP_ENV_VARS)) {extract($HTTP_ENV_VARS);}

$_SERVER['QUERY_STRING'] = strip_tags($_SERVER['QUERY_STRING']);
$_SERVER['PHP_SELF'] = strip_tags($_SERVER['PHP_SELF']);

$PHP_SELF = $_SERVER['PHP_SELF'];

define("CUR_FILENAME",$PHP_SELF);

//---------------------- id errors protect -----------------------
 if($id && !is_array($id)){
         if(!is_numeric($id)){
                 die("<script>window.location=\"index.php\"</script>");
                 }
 }

 //---------------------- cat errors protect -----------------------
 if($cat && !is_array($cat)){
         if(!is_numeric($cat)){
                 die("<script>window.location=\"index.php\"</script>");
                 }
 }

//------------------------------------------------------------------------




//---------------------------
$cn = @mysql_connect($db_host,$db_username,$db_password) ;
if(!$cn){
        if(mysql_errno()==1040){
     die("<center> Server Busy  , Please Try again later  </center>");
        }else{
die(mysql_errno()." : connection Error");
                }
                }


@mysql_select_db($db_name) or die("Database Name Error");
//--------------------------------------
include_once(CWD . "/functions_db.php") ;
include_once(CWD . "/theme.php") ;


//---------------- Load Phrases ----------------
$phrases = array();
$qr = db_query("select * from news_phrases");
while($data = db_fetch($qr)){

$phrases["$data[name]"] = $data['value'] ;
        }
//-------------------------------------------------


$actions_checks = array(
"$phrases[main_page]" => 'main' ,
"$phrases[the_news_list]" => 'browse',
"$phrases[browsing_news]" => 'news',
"$phrases[the_pages]" => 'pages',
"$phrases[the_search]" => 'search' ,
"$phrases[the_votes]" => 'votes',
"$phrases[the_statics]" => 'statics'
);


$permissions_checks = array(
"$phrases[cp_selected_news]" => 'new_menu',
"$phrases[the_templates]" => 'templates' ,
"$phrases[the_phrases]" => 'phrases' ,
"$phrases[the_banners]" => 'adv',
"$phrases[the_votes]" => 'votes',
);

//--------------- Get Settings --------------------------
$settings = array();
function load_settings(){
global  $settings ;
$qr = db_query("select * from news_settings");
while($data = db_fetch($qr)){

$settings["$data[name]"] = $data['value'] ;
        }
}

load_settings();


include_once(CWD . "/counter.php");

$siteurl = "http://$_SERVER[HTTP_HOST]" ; 
$script_path = trim(str_replace(rtrim(str_replace('\\', '/',$_SERVER['DOCUMENT_ROOT']),"/"),"",CWD),"/");
$scripturl = $siteurl . iif($script_path,"/".$script_path,"");
$sitename = $settings['sitename'] ;
$section_name = $settings['section_name'] ;
$upload_types = explode(',',str_replace(" ","",$settings['uploader_types']));


function print_copyrights(){
global $_SERVER,$settings,$global_lang,$copyrights_lang ;

if(!$copyrights_lang){$copyrights_lang = $global_lang;}

if(COPYRIGHTS_TXT_MAIN){
if($copyrights_lang == "arabic"){
print "<p align=center>Ã„Ì⁄ «·ÕﬁÊﬁ „Õ›ÊŸ… ·‹ :
<a target=\"_blank\" href=\"http://$_SERVER[HTTP_HOST]\">$settings[copyrights_sitename]</a> © " . date('Y') . " <br>
»—„Ã… <a target=\"_blank\" href=\"http://allomani.com/\"> «··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </a> © 2008";
}else{
print "<p align=center>Copyright © ". date('Y')." <a target=\"_blank\" href=\"http://$_SERVER[HTTP_HOST]\">$settings[copyrights_sitename]</a> - All rights reserved <br>
Programmed By <a target=\"_blank\" href=\"http://allomani.com/\"> Allomani </a> © 2008";
	}
}
        }

//-------------- read file ------------------
function read_file($filename){
$fn = fopen($filename,"r");
$fdata = fread($fn,filesize($filename));
fclose($fn);
return $fdata ;
}
//---------------------------------------------
function execphp_fix_tag($match)
{
        // replacing WPs strange PHP tag handling with a functioning tag pair
        $output = '<?php'. $match[2]. '?>';
        return $output;
}
//------------------------------------------------------------
function run_php($content)
{

$content = str_replace(array("&#8216;", "&#8217;"), "'",$content);
$content = str_replace(array("&#8221;", "&#8220;"), '"', $content);
$content = str_replace("&Prime;", '"', $content);
$content = str_replace("&prime;", "'", $content);
        // for debugging also group unimportant components with ()
        // to check them with a print_r($matches)
        $pattern = '/'.
                '(?:(?:<)|(\[))[\s]*\?php'. // the opening of the <?php or [?php tag
                '(((([\'\"])([^\\\5]|\\.)*?\5)|(.*?))*)'. // ignore content of PHP quoted strings
                '\?(?(1)\]|>)'. // the closing ? > or ?] tag
                '/is';
      $content = preg_replace_callback($pattern, 'execphp_fix_tag', $content);
        // to be compatible with older PHP4 installations
        // don't use fancy ob_XXX shortcut functions
        ob_start();
        eval(" ?> $content ");
        $output = ob_get_contents();
        ob_end_clean();
        print $output;
}
//----------------------------------------------------------------------
$user_info = array();
function check_login_cookies(){
      global $user_info,$do_open,$HTTP_COOKIE_VARS ;

$user_info['username'] = $HTTP_COOKIE_VARS['news_username'];
$user_info['password'] = $HTTP_COOKIE_VARS['news_password'];
$user_info['id'] = intval($HTTP_COOKIE_VARS['news_id']);



   if($user_info['id']){
   $qr = db_query("select * from news_user where id='$user_info[id]'");
         if(db_num($qr)){
           $data = db_fetch($qr);
           if($data['username'] == $user_info['username'] && md5($data['password']) == $user_info['password']){
                   $user_info['email'] = $data['email'];
           $user_info['groupid'] = $data['group_id'];
                   return true ;
                   }else{
                           return false ;
                           }

                 }else{
                         return false ;
                         }

           }else{
                   return false ;
                   }

        }
        
//--------- iif expression ------------
function iif($expression, $returntrue, $returnfalse = '')
{
    return ($expression ? $returntrue : $returnfalse);
}

 //----------------------------------------------------------
 function if_admin($dep="",$continue=0){
        global $user_info,$phrases ;

        if(!$dep){
        if($user_info['groupid'] != 1){

        if(!$continue){

         die ("<center> $phrases[err_access_denied] </center>");
         }
         return false;
         }else{
                 return true;
                 }
          }else{


           if($user_info['groupid'] != 1){

                  $data=db_qr_fetch("select cp_permisions from news_user where id='$user_info[id]'");
                  $prmx  =  explode(",",$data["cp_permisions"]);
                  if(!in_array($dep,$prmx)){

        if(!$continue){
                           die ("<center> $phrases[err_access_denied] </center>");
                           }
                            return false;
                          }else{
                          return true;
                                  }
                 }else{
                         return true;
                         }
            }
         }

//---------------------- Send Email Function -------------------
function send_email($from_name,$from_email,$to_email,$subject,$msg,$html=1){

    $from_name = htmlspecialchars($from_name);
    $from_email = htmlspecialchars($from_email);
    $to_email = htmlspecialchars($to_email);
    $subject = htmlspecialchars($subject);
   // $msg=htmlspecialchars($msg);


    $from = "$from_name <$from_email>" ;

    $mailHeader  = 'From: '.$from.' '."\r\n";
    $mailHeader .= "Reply-To: $from_email\r\n";
    $mailHeader .= "Return-Path: $from_email\r\n";

    if($html){
    $mailheader.="MIME-Version: 1.0\r\n";
    $mailHeader .= "Content-Type: text/html; charset=windows-1256"."\r\n";
  }

    $mailHeader .= "X-EWESITE: Allomani\r\n";
    $mailHeader .= "X-Mailer: PHP/".phpversion()."\r\n";
    $mailHeader .= "X-Sender-IP: {$_SERVER['REMOTE_ADDR']}\r\n";


    $mailResult = @mail($to_email,$subject,$msg,$mailHeader);

               if($mailResult){
              return true ;
                }else{
               return false;

               }
        }
 //--------- get image ------------------
function get_image($src){
global $is_admin;
if($is_admin){

 if($src){
              return "../".$src ;
            }else{

    return "../images/no_pic.gif" ;
    }

        }else{

         if($src){
              return $src ;
            }else{

    return "images/no_pic.gif" ;
    }
    }
    }




//---------------------------------- Safe Functions -----------------------
$safe_functions = array(
                        // logical stuff
                        0 => 'and',              // logical and
                        1 => 'or',               // logical or
                        2 => 'xor',              // logical xor

                        'if',
                        'lsn',
                        'snd',
                        'add2fav',
                        'substr',
                        'get_image',
                        'snd_vid',
                        'check_member_login',
                        'print',
                        'vote_song',
                        'echo',
                        'in_array',
                        'is_array',
                        'is_numeric',
                        'isset',
                        'empty',
                        'defined',
                        'array',


                );

//--------------------------------- Check Functions ---------------------------------
function check_safe_functions($condition_value){

  global $safe_functions,$phrases ;
      if (preg_match_all('#([a-z0-9_{}$>-]+)(\s|/\*.*\*/|(\#|//)[^\r\n]*(\r|\n))*\(#si', $condition_value, $matches))
                        {

                                $functions = array();
                                foreach($matches[1] AS $key => $match)
                                {
                                        if (!in_array(strtolower($match), $safe_functions) && function_exists(strtolower($match)))
                                        {
                                                $funcpos = strpos($condition_value, $matches[0]["$key"]);
                                                $functions[] = array(
                                                        'func' => stripslashes($match),
                                                    //    'usage' => substr($condition_value, $funcpos, (strpos($condition_value, ')', $funcpos) - $funcpos + 1)),
                                                );
                                        }
                                }
                                if (!empty($functions))
                                {
                                        unset($safe_functions[0], $safe_functions[1], $safe_functions[2]);



                                        foreach($functions AS $error)
                                        {
                                                $errormsg .= "$phrases[err_function_usage_denied]: <code>" . htmlspecialchars($error['func']) . "</code>
                                                <br>\n";
                                        }

                                        echo "<p dir=rtl>$errormsg</p>";
                                        return false ;
                                }else{
                                         return true ;
                                          }
                        }
                        return true ;
                        }
//---------------------- Compile Safe Tempalte -------------------
function compile_template($template)
{
global $safe_functions ;

       if(check_safe_functions($template)){

      run_php($template);
        }
}
//---------------------- Get Error ---------------------
function get_err_msg($code){
global $settings,$phrases ;

if($code){
switch($code){
        case "err_uploader_not_allowed" : $msg = "$settings[uploader_msg]" ; break ;
        case "err_img_type" : $msg = "$phrases[err_wrong_img_type]" ; break ;
        case "err_file_type" : $msg = "$phrases[this_filetype_not_allowed]" ;break ;
        case "err_file_folder" : $msg = "$phrases[err_wrong_uploader_folder]" ;break ;
        case "err_name_emp" : $msg = "$phrases[please_enter_the_name]" ;break ;
        }
        return $msg  ;
        }
        }
//-------------------- Save File -----------------------
function save_file($data_name,$data_tempname,$folder,$cwd){
global $settings,$last_save_file_err ;
if($settings['uploader']){

    $upload_folder = $settings['uploader_path']."/$folder" ;



      if($upload_folder && file_exists("$cwd/$upload_folder")){


                $fileinfo= pathinfo($data_name);
                $imtype = strtolower($fileinfo["extension"]);

    if(!strchr($data_name,".php") && !strchr($data_name,".cgi") && !strchr($data_name,".exe")){

            $filename = strtolower($data_name);
            $filename= str_replace(".$imtype","",$filename);
            $filename= str_replace(" ","_",$filename);

            if(file_exists("$cwd/$upload_folder/".$filename.".$imtype")){$filename .= "_".rand(0,9999).rand(0,9999);}
            $filename .= ".$imtype" ;

            move_uploaded_file($data_tempname, "$cwd/$upload_folder/$filename");


return "$upload_folder/$filename" ;


           }else{

                   return   "err_file_type";
                   }
        }else{

                return  "err_file_folder" ;
          }
          }else{

        return "err_uploader_not_allowed" ;
                  }
          }
//---------------------------- Check if Error -----------------------
function is_error($name){
        if(substr($name,0,3) == "err"){
                return true ;
                }else{
                        return false ;
                        }
}
//---------------------------------------------------------------------
include "thumb.class.php" ;
//--------------------------- Create Thumb ----------------------------
function create_thumb($filename , $width , $hieght,$cwd){
   $img_info = getimagesize("$cwd/$filename");

 $thumb=new thumbnail("$cwd/$filename");

 if($img_info[0] > $width){
 $thumb->size_width($width);
 }else{
 $thumb->size_width($img_info[0]);
         }

 if($img_info[1] > $hieght){
$thumb->size_height($hieght);
  }else{
  $thumb->size_height($img_info[1]);
  }


   $fileinfo= pathinfo("$cwd/$filename");
   $imtype = strtolower($fileinfo["extension"]);


$thumb->jpeg_quality(100);                                // [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
$thumb_saveto =  str_replace(".$imtype","","$cwd/".convert2en($filename))."_thumb.".$imtype;

 if(file_exists(str_replace(".$imtype","","$cwd/".convert2en($filename))."_thumb.".$imtype)){
 	$thumb_saveto =  str_replace(".$imtype","","$cwd/".convert2en($filename))."_thumb"."_".rand(0,9999).rand(0,9999).".".$imtype;
 	}



$thumb->save($thumb_saveto);                                // save your thumbnail to file
return  str_replace(CWD."/","",$thumb_saveto) ;
        }

//---------------------------------- Get Cats ----------------------------------
 function get_cats($id){
 $id = intval($id);
  $cats_arr = array();
   $cats_arr[]=$id;

         $qr1 = db_query("select id from news_cats where cat=$id");
         while($data1 = db_fetch($qr1)){
          $cats_arr[]=$data1['id'] ;
          $qr2=db_query("select id from news_cats where cat=$data1[id]");
          while($data2 = db_fetch($qr2)){
           $cats_arr[]=$data2['id'] ;
           $qr3=db_query("select id from news_cats where cat=$data2[id]");
          while($data3 = db_fetch($qr3)){
           $cats_arr[]=$data3['id'] ;
           $qr4=db_query("select id from news_cats where cat=$data3[id]");
          while($data4 = db_fetch($qr4)){
           $cats_arr[]=$data4['id'] ;
           $qr5=db_query("select id from news_cats where cat=$data4[id]");
          while($data5 = db_fetch($qr5)){
           $cats_arr[]=$data5['id'] ;
                  }
                  }
                  }
                  }
          }
          return  $cats_arr ;
         }

//--------------------- preview Text ------------------------------------
function getPreviewText($text) {
             global $preview_text_limit ;
             require_once(CWD . '/class.html2text.php');
           //  $h2t =& new html2text($text);
           $h2t = new html2text($text);
             $plain_text = $h2t->get_text();
             return substr(trim($plain_text),0,$preview_text_limit);  
             
}

    /*     function getPreviewText($text) {
         	global $preview_text_limit ;
    // Strip all tags
    $desc = strip_tags(html_entity_decode($text), "<a><em>");
    $charlen = 0; $crs = 0;
    if(strlen_HTML($desc) == 0)
        $preview = substr($desc, 0, $preview_text_limit);
    else
    {
        $i = 0;
        while($charlen < 80)
        {
            $crs = strpos($desc, " ", $crs)+1;
            $lastopen = strrpos(substr($desc, 0, $crs), "<");
            $lastclose = strrpos(substr($desc, 0, $crs), ">");
            if($lastclose > $lastopen)
            {
                // we are not in a tag
                $preview = substr($desc, 0, $crs);
                $charlen = strlen_noHTML($preview);
            }
            $i++;
        }
    }
    return $preview  ;

}
*/

/**
 * return length of a string regardeless of html tags in it
 *
 * @param string $html
 * @return string
 */
function strlen_noHtml($string){
    $crs = 0;
    $charlen = 0;
    $len = strlen($string);
    while($crs < $len)
    {
        $offset = $crs;
        $crs = strpos($string, "<", $offset);
        if($crs === false)
        {
           $crs = $len;
           $charlen += $crs - $offset;
        }
        else
        {
            $charlen += $crs - $offset;
            $crs = strpos($string, ">", $crs)+1;
        }
    }
    return $charlen;
}

/**
 * return length of a string regarding html tags in it
 *
 * @param string $html
 * @return string
 */
function strlen_Html($string){
    $crs = 0;
    $charlen = 0;
    $len = strlen($string);
    while($crs < $len)
    {
        $scrs = strpos($string, "<", $crs);
        if($scrs === false)
        {
           $crs = $len;
        }
        else
        {
            $crs = strpos($string, ">", $scrs)+1;
            if($crs === false)
                $crs = $len;
            $charlen += $crs - $scrs;
        }
    }
    return $charlen;
}


//------------- convert ar 2 en ------------------

function convert2en($filename){
$filename= str_replace("'","",$filename);
$filename= str_replace(" ","_",$filename);
$filename= str_replace("«","a",$filename);
$filename= str_replace("√","a",$filename);
$filename= str_replace("≈","i",$filename);
$filename= str_replace("»","b",$filename);
$filename= str_replace(" ","t",$filename);
$filename= str_replace("À","th",$filename);
$filename= str_replace("Ã","g",$filename);
$filename= str_replace("Õ","7",$filename);
$filename= str_replace("Œ","k",$filename);
$filename= str_replace("œ","d",$filename);
$filename= str_replace("–","d",$filename);
$filename= str_replace("—","r",$filename);
$filename= str_replace("“","z",$filename);
$filename= str_replace("”","s",$filename);
$filename= str_replace("‘","sh",$filename);
$filename= str_replace("’","s",$filename);
$filename= str_replace("÷","5",$filename);
$filename= str_replace("⁄","3",$filename);
$filename= str_replace("€","k",$filename);
$filename= str_replace("›","f",$filename);
$filename= str_replace("ﬁ","k",$filename);
$filename= str_replace("ﬂ","k",$filename);
$filename= str_replace("·","l",$filename);
$filename= str_replace("‰","n",$filename);
$filename= str_replace("Â","h",$filename);
$filename= str_replace("Ì","y",$filename);
$filename= str_replace("ÿ","6",$filename);
$filename= str_replace("Ÿ","d",$filename);
$filename= str_replace("Ê","w",$filename);
$filename= str_replace("ƒ","o",$filename);
$filename= str_replace("∆","i",$filename);
$filename= str_replace("·«","la",$filename);
$filename= str_replace("·√","la",$filename);
$filename= str_replace("Ï","a",$filename);
$filename= str_replace("…","t",$filename);
$filename= str_replace("„","m",$filename);


return $filename ;

}

   //--------------- Load Global Plugins --------------------------
$dhx = opendir(CWD ."/plugins");
while ($rdx = readdir($dhx)){
         if($rdx != "." && $rdx != "..") {
                 $cur_fl = CWD ."/plugins/" . $rdx . "/global.php" ;
        if(file_exists($cur_fl)){
                include $cur_fl ;

                }
          }

    }
closedir($dhx);



// ------------- lang dir -------------
if($global_lang=="arabic"){
$global_dir = "rtl" ;
$global_align = "right" ;
}else{
$global_dir = "ltr" ;
$global_align = "left" ;
}
