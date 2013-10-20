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
function fix_gpc($value){
if(get_magic_quotes_gpc()==0)
{
	return addslashes($value);
	}else{
	return $value ;
	}
}

 //----------- Clean String ----------
 function db_clean_string($str,$type="text",$op="write",$is_gpc=true){

 if(get_magic_quotes_gpc() && $is_gpc){ $str = stripslashes($str);}

if($type=="num"){
return intval($str);
}elseif($type=="text"){

if($op=="write"){
return db_escape_string(htmlspecialchars($str));
}else{
return db_escape_string($str);
}
}elseif($type=="code"){
return db_escape_string($str);
}
 }
  //----------- escape String -----------
 function db_escape_string($str){

 if(function_exists('mysql_real_escape_string')){
     return mysql_real_escape_string($str);
     }else{
     return mysql_escape_string($str);
     }
 }
 
 //----------- query ------------------
   function db_query($sql){
   	global $show_mysql_errors ;
   if(strpos(strtolower($sql),"union")){
      die("<script>window.location=\"index.php\"</script>");
      }

      $qr  = mysql_query($sql);
      $err =  mysql_error() ;

      if($err && $show_mysql_errors){
      	 	print  "<p align=left><b> MySQL Error: </b> $err </p>";
      }else{
         return $qr ;
      }
           }

 //---------------- fetch -------------------
    function db_fetch($qr){
    global $show_mysql_errors ;

         $fetch = mysql_fetch_array($qr);

     $err =  mysql_error() ;

      if($err && $show_mysql_errors){
       	print  "<p align=left><b> MySQL Error: </b> $err </p>";
      }else{
            return $fetch;
            }
            }

 //------------------ Query + fetch ----------------------
    function db_qr_fetch($sql){
    global $show_mysql_errors ;

          if(strpos(strtolower($sql),"union")){
      die("<script>window.location=\"index.php\"</script>");
      }

     $qr =  mysql_query($sql);
      $err =  mysql_error() ;

      if($err && $show_mysql_errors){
      	print  "<p align=left><b> MySQL Error: </b> $err </p>";
      }else{
            return mysql_fetch_array($qr);
            }
            }

// ------------------------ num -----------------------
      function db_num($sql){
    
            return mysql_num_rows($sql);
            }

// ------------------- query + num --------------------
             function db_qr_num($sql){
                if(strpos(strtolower($sql),"union")){
      die("<script>window.location=\"index.php\"</script>");
      }
      
       $qr =  mysql_query($sql);
      $err =  mysql_error() ;

      if($err && $show_mysql_errors){
          print  "<p align=left><b> MySQL Error: </b> $err </p>";
      }else{
            return mysql_num_rows($qr);
      }
            }