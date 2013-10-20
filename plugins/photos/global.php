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
$actions_checks["$phrases[photos_dir]"] = 'photos' ;

array_push($actions_list,'photos');

$actions_text .= ",photos" ;

$permissions_checks["$phrases[photos_dir]"]  = "photos" ;


//---------------------------------------------------------------------------------
 function get_photos_cats($id){
 $id = intval($id);

  $cats_arr = array();
   $cats_arr[]=$id;

         $qr1 = db_query("select id from photos_cats where cat=$id");
         while($data1 = db_fetch($qr1)){
          $cats_arr[]=$data1['id'] ;
          $qr2=db_query("select id from photos_cats where cat=$data1[id]");
          while($data2 = db_fetch($qr2)){
           $cats_arr[]=$data2['id'] ;
           $qr3=db_query("select id from photos_cats where cat=$data2[id]");
          while($data3 = db_fetch($qr3)){
           $cats_arr[]=$data3['id'] ;
           $qr4=db_query("select id from photos_cats where cat=$data3[id]");
          while($data4 = db_fetch($qr4)){
           $cats_arr[]=$data4['id'] ;
           $qr5=db_query("select id from photos_cats where cat=$data4[id]");
          while($data5 = db_fetch($qr5)){
           $cats_arr[]=$data5['id'] ;
                  }
                  }
                  }
                  }
          }
          return  $cats_arr ;
         }


?>