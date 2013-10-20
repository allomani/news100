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

   $id = intval($id);

       $qr = db_query("select * from news_news where id='$id'");
              if(db_num($qr)){
              $data = db_fetch($qr);




                $img_url = get_image($data['img']) ;
   $template = get_template('browse_news_print');
   $news_date = date("d-m-Y",strtotime($data['date']));
   $template = str_replace(array('{id}','{title}','{img}','{content}','{details}','{writer}','{date}'),array("$data[id]","$data[title]","$img_url","$data[content]","$data[details]","$data[writer]","$news_date"),$template);

       print "$template";



     }else{

     print "<center>$phrases[err_wrong_url]</center>";

             }

