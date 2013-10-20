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

function get_template($name){


$data = db_qr_fetch("select * from news_templates where name like '$name'");

return $data['content'] ;
}



$theme['header'] = get_template("header") ;
$theme['footer'] = get_template("footer") ;
$theme['table'] = explode("{content}",get_template("table")) ;
$theme['block'] = explode("{content}",get_template("block")) ;

$theme['table_open'] = $theme['table'][0] ;
$theme['table_close'] = $theme['table'][1] ;

$theme['block_open'] = $theme['block'][0] ;
$theme['block_close'] = $theme['block'][1] ;

function site_header(){
global $theme,$sitename,$settings,$action,$id,$op,$cat,$section_name,$screen_res;

//------ News Title ---------------
if($action == "news" && $id){
        $id = intval($id);
$qr = db_query("select title from news_news where id='$id'");
if(db_num($qr)){
$data = db_fetch($qr) ;
$title_sub = " - $data[title]" ;
        }else{
 $title_sub = "" ;
 }
 }
//------ News Cats Title ---------------
if($action == "browse"  && $cat){
$cat = intval($cat);
$qr = db_query("select name from news_cats where id='$cat'");
if(db_num($qr)){
$data = db_fetch($qr) ;
$title_sub = " - $data[name]" ;
        }else{
 $title_sub = "" ;
 }
 }

//-------------------------------------
if($section_name){
$sec_name = " -  $section_name" ;
        }

print "<HTML dir=$settings[html_dir]>
<HEAD>
<title>$sitename".$sec_name.$title_sub."</title>
";
compile_template(get_template('page_head'));
if(COPYRIGHTS_TXT_ADMIN){ 
print "
<META name=\"Developer\" content=\"www.allomani.com\" >";
}
print "
</HEAD>
";

print $theme['header'];

print get_template("js_functions");
}

function site_footer (){
global $theme;
print $theme['footer'];
}


function open_block($table_title="",$template=0){
global $theme;
if(!$template || $template == 0){
      $table_content = $theme['block_open'];
      }else{
      $qr = db_query("select * from news_templates where id='$template'");
     if(db_num($qr)){
    $data = db_fetch($qr);
    $custom_table_open = explode("{content}",$data['content']) ;
     $table_content =   $custom_table_open[0];

              }else{
         $table_content = $theme['block_open'];
                      }
              }

if($table_title){

        $table_content = str_replace("{title}","<center><span class=title>$table_title</span></center>", $table_content);
         $table_content = str_replace("{new_line}","<br>",$table_content);
        }else{
            $table_content = str_replace("{title}","", $table_content);
             $table_content = str_replace("{new_line}","",$table_content);
                 }

print $table_content ;
}

function close_block($template=0){
global $theme;

if(!$template || $template == 0){
      $table_content = $theme['block_close'];
      }else{
      $qr = db_query("select * from news_templates where id='$template'");
     if(db_num($qr)){
    $data = db_fetch($qr);
    $custom_table_close = explode("{content}",$data['content']) ;
     $table_content =   $custom_table_close[1];
              }else{
          $table_content = $theme['block_close'];
                      }
              }

print $table_content;
}


function open_table($table_title="",$template=0){
global $theme;

if(!$template || $template == 0){
      $table_content = $theme['table_open'];
      }else{
      $qr = db_query("select * from news_templates where id='$template'");
     if(db_num($qr)){
    $data = db_fetch($qr);
    $custom_table_open = explode("{content}",$data['content']) ;
     $table_content =   $custom_table_open[0];

              }else{
         $table_content = $theme['table_open'];
                      }
              }
if($table_title){

        $table_content = str_replace("{title}","<center><span class=title>$table_title</span></center>",$table_content);
        $table_content = str_replace("{new_line}","<br>",$table_content);
        }else{
            $table_content = str_replace("{title}","", $table_content);
             $table_content = str_replace("{new_line}","",$table_content);
                }

print $table_content ;
}

function close_table($template=0){
global $theme;

if(!$template || $template == 0){
      $table_content = $theme['table_close'];
      }else{
      $qr = db_query("select * from news_templates where id='$template'");
     if(db_num($qr)){
    $data = db_fetch($qr);
    $custom_table_close = explode("{content}",$data['content']) ;
     $table_content =   $custom_table_close[1];
              }else{
          $table_content = $theme['table_close'];
                      }
              }

print $table_content;
}



?>