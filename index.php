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
require("global.php");

//----------------- Disable Browsing ------------------
if($settings['enable_browsing']!="1"){
if(check_login_cookies()){
print "<table width=100% dir=rtl><tr><td><font color=red> $phrases[site_closed_for_visitors] </font></td></tr></table>";
}else{
print "<center><table width=50% style=\"border: 1px solid #ccc\"><tr><td> $settings[disable_browsing_msg] </td></tr></table></center>";
die();
}
}
//---------------- set vote expire ------------------------
if($action=="vote_add" && $vote_id){
if(!$settings['votes_expire_hours']){$settings['votes_expire_hours'] = 24 ; }
   if(!$HTTP_COOKIE_VARS['news_vote_added']){
  setcookie('news_vote_added', "1" , time() + ($settings['votes_expire_hours'] * 60 * 60),"/");
  }
        }
//----------------------------------------------------------


site_header();

  if(!$blocks_width){
            $blocks_width = "17%" ;
            }

print "<table border=\"0\" width=\"100%\"  style=\"border-collapse: collapse\">

        <tr>
                <td height=\"13\" width=\"100%\" colspan=\"3\"></td>

        </tr>  <tr>" ;
        //------------------------- Block Pages System ---------------------------
        function get_pg_view(){
                global $pg_view ,$action ;
        if($action=="votes" || $action == "vote_add"){
          $pg_view = "votes" ;
          }elseif(!$action){
           $pg_view = "main" ;
        }else{
        $pg_view = $action ;
        }
        if(!$pg_view){$pg_view = "main" ;}
        }
        //--------------------------------------------------------------------------
           get_pg_view();
           if(!in_array($pg_view,$actions_list)){$pg_view = "main" ;}
       //----------------------- Right Content --------------------------------------------

      $xqr=db_query("select * from news_blocks where pos='r' and active=1 and pages like '%$pg_view%' order by ord");

      if(db_num($xqr)){
        print "<td width='$blocks_width' valign=\"top\">
        <center><table width=100%>" ;

        $adv_c = 1 ;
         while($xdata = db_fetch($xqr)){

        print "<tr>
                <td  width=\"100%\" valign=\"top\">";
                open_block($xdata['title'],$xdata['template']);


                 run_php($xdata['file']);


                close_block($xdata['template']);

                print "</td>
        </tr>";

         //---------------------------------------------------
        $adv_menu_qr = db_query("select * from news_banners where type='menu' and menu_id=$adv_c and menu_pos='r' and pages like '%$pg_view%' order by ord");

        if(db_num($adv_menu_qr)){
                $data = db_fetch($adv_menu_qr) ;
                db_query("update news_banners set views=views+1 where id=$data[id]");
                print "<tr>
                <td  width=\"100%\" valign=\"top\">";
                if($data['c_type']=="code"){
	print $data['content'];
	}else{
                open_block();
             print "<center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a></center>";
                close_block();
                }
                print "</td>
        </tr>";
               }
            ++$adv_c ;
        //----------------------------------------------------
           }
print "</table></center></td>";
}

print "<td  valign=\"top\">";


//---------------------  Banners ----------------------------
$qr = db_query("select * from news_banners where type='header' and pages like '%$pg_view%' order by ord");
while($data = db_fetch($qr)){
db_query("update news_banners set views=views+1 where id=$data[id]");
if($data['c_type']=="code"){
print $data['content'];
	}else{
print "<center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a><br></center>";
}
        }
 print "<br>";

//-------------------------- CENTER CONTENT ---------------------------------------------



    get_pg_view();
         if(!in_array($pg_view,$actions_list)){$pg_view = "none" ;}


    $data= db_qr_fetch("select * from news_banners where type='open' and pages like '%$pg_view%'");

    if ($data['url']){
    	 db_query("update news_banners set views=views+1 where id='$data[id]'");
   print "<script>
        msgwindow=window.open(\"$data[url]\",\"displaywindow\",\"toolbar=yes,scrollbars=yes,resizable=yes,width=650,height=300,top=200,left=200\")
        </script>\n";
            }

            $data= db_qr_fetch("select * from news_banners where type='close' and pages like '%$pg_view%'");

    if ($data['url']){
    	 db_query("update news_banners set views=views+1 where id='$data[id]'");
   print "<script>
   function pop_close(){
        msgwindow=window.open(\"$data[url]\",\"displaywindow\",\"toolbar=yes,scrollbars=yes,resizable=yes,width=650,height=300,top=200,left=200\")
        }
        </script>\n";


            }


         get_pg_view();
         if(!in_array($pg_view,$actions_list)){$pg_view = "none" ;}

 $yqr=db_query("select * from news_blocks where pos='c' and active=1 and pages like '%$pg_view%' order by ord");
  $adv_c = 1 ;
         while($ydata = db_fetch($yqr)){


                open_table($ydata['title'],$ydata['template']);


           run_php($ydata['file']);


                close_table($ydata['template']);



                       //---------------------------------------------------

        $adv_menu_qr = db_query("select * from news_banners where type='menu' and menu_id=$adv_c and menu_pos='c' and pages like '%$pg_view%' order by ord");
        if(db_num($adv_menu_qr)){
                $data = db_fetch($adv_menu_qr) ;
                db_query("update news_banners set views=views+1 where id=$data[id]");
            if($data['c_type']=="code"){
	print $data['content'];
	}else{
             print "<center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a></center><br>";
            }
               }
            ++$adv_c ;
        //----------------------------------------------------
                    }




 // ------------------------- Statics ------------------------------------------------
 if($action=="statics"){
        include("statics.php");
        }
  //-------------------------------------- Browse -------------------------------
 if($action=="browse"){

      $cat = intval($cat);


           //-------------- dirs header ---------------- 
$dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from news_cats where id=$dir_data[cat]");

        $dir_content = "<a href='browse_$dir_data[id].html'>$dir_data[name]</a> &nbsp; <img src='images/arrw.gif'> ". $dir_content  ;
        }     
  //------------------------------------------
    print "<p align=$global_align><img src='images/album.gif'><a class=path_link href='browse_0.html'>$phrases[the_news] </a> &nbsp; <img src='images/arrw.gif'> $dir_content</p>";



     //----------------- list cats ------------------

                    $qr = db_query("select * from news_cats where cat='$cat' order by id DESC");


    if(db_num($qr)){
       open_table();
    print "<center><table width=100%>" ;
    $c=0;
        while($data = db_fetch($qr)){



if ($c==$settings['news_cells']) {
print "  </tr><TR>" ;
$c = 0 ;
}

$tmplt = str_replace("{name}",$data['name'],get_template('browse_cats'));
$tmplt = str_replace("{id}",$data['id'],$tmplt);

print " <td>$tmplt</td>";

        ++$c ;
             }
           print "</tr></table></center>";
            close_table();
            }else{

                  $no_cats = true ;
                    }

    //--------------------------------------------
           $qr = db_query("select left(date,7) as date from news_news where cat='$cat' group by left(date,7)");
          if(db_num($qr) > 1){
          open_table();
          print "
           $phrases[the_date] : <select name=date onChange=\"location.href = 'browse_". $cat . "_"."' + this.options[this.selectedIndex].value + '_0.html'\">
           <option value='0'> $phrases[the_all] </option>";
          while($data = db_fetch($qr)){
          if($date == $data['date']){$chk="selected" ;}else{$chk="";}

                  print "<option value='$data[date]' $chk>$data[date]</option>";
                  }

                  close_table();
                  }


      //----------------- start pages system ----------------------
   $start = intval($start);

    if($date){
       $page_string= "browse_"."$cat"."_$date" ;
       }else{
       $page_string= "browse_$cat" ;
               }
        //--------------------------------------------------------------


          $news_perpage = $settings['news_perpage'];

          if($date){
        $qr = db_query("select id,title,date,writer,img,details from news_news where cat='$cat' and date like '$date%' order by id DESC limit $start,$news_perpage");
          
         //   $qr = db_query("select id,title,date,writer,img,left(details,".$preview_text_limit.") as details from news_news where cat='$cat' and date like '$date%' order by id DESC limit $start,$news_perpage");
            $page_result = db_qr_fetch("SELECT count(*) as count from news_news where cat='$cat' and date like '$date%'");
            }else{
     $qr = db_query("select id,title,date,writer,img,details from news_news where cat='$cat' order by id DESC limit $start,$news_perpage");
        
         //    $qr = db_query("select id,title,date,writer,img,left(details,".$preview_text_limit.") as details from news_news where cat='$cat' order by id DESC limit $start,$news_perpage");
            $page_result = db_qr_fetch("SELECT count(*) as count from news_news where cat='$cat'");
            }

 $numrows=$page_result['count'];
$previous_page=$start - $news_perpage;
$next_page=$start + $news_perpage;

            if(db_num($qr)){



            while ($data = db_fetch($qr)){
             open_table();
                $img_url = get_image($data['img']) ;
   $template = get_template('browse_news');
   $news_date = date("d-m-Y",strtotime($data['date']));
   $template = str_replace(array('{id}','{title}','{img}','{content}','{writer}','{date}'),array("$data[id]","$data[title]","$img_url",getPreviewText("$data[details]"),"$data[writer]","$news_date"),$template);

       print "$template";
close_table();
                    }

                    }else{
                    if($no_cats){
                     open_table();
                            print "<center> $phrases[err_no_news] </center>";
                              close_table();
                              }
                            }

//-------------------- pages system ------------------------
if ($numrows>$news_perpage){
echo "<p align=center>$phrases[pages] : ";
if($start >0){
$previouspage = $start - $news_perpage;
echo "<a href=$page_string"."_$previouspage.html><</a>\n";}
$pages=intval($numrows/$news_perpage);
if ($numrows%$news_perpage){$pages++;}
for ($i = 1; $i <= $pages; $i++) {
$nextpag = $news_perpage*($i-1);
if ($nextpag == $start){
echo "<font size=2 face=tahoma><b>$i</b></font>&nbsp;\n";
}else{
echo "<a href=$page_string"."_$nextpag.html>[$i]</a>&nbsp;\n";}
}
if (! ( ($start/$news_perpage) == ($pages - 1) ) && ($pages != 1) )
{$nextpag = $start+$news_perpage;
echo "<a href=$page_string"."_$nextpag.html>></a>\n";}
echo "</p>";}
//------------ end pages system -------------

//--------------------------------------------------------------//





}
//-------------------- show news ---------------
if($action=="news"){


         $id = intval($id);

       $qr = db_query("select * from news_news where id='$id'");
              if(db_num($qr)){
              $data = db_fetch($qr);


              db_query("update news_news set views=views+1 where id='$id'");

              $hdr = db_qr_fetch("select * from news_cats where id='$data[cat]'");

   print "<p> <img src='images/album.gif' border=0> <a class=path_link href='browse.html'>$phrases[the_news]</a> &nbsp; <img src='images/arrw.gif'>&nbsp;<a href='browse_$data[cat].html'>$hdr[name]</a> &nbsp; <img src='images/arrw.gif'>&nbsp;$data[title]<br><br>";


      open_table($data['title']);


                $img_url = get_image($data['img']) ;
   $template = get_template('browse_news_inside');
   $news_date = date("d-m-Y",strtotime($data['date']));
   $template = str_replace(array('{id}','{title}','{img}','{content}','{details}','{writer}','{date}'),array("$data[id]","$data[title]","$img_url","$data[content]","$data[details]","$data[writer]","$news_date"),$template);

       print "$template";



     close_table();
     }else{
     open_table();
     print "<center>$phrases[err_wrong_url]</center>";
     close_table();
             }
}

  //-------------------------------------------------------------------
  if($action=="contactus"){
          open_table("$phrases[contact_us]");
         print get_template("contactus");
          close_table();
          }
 // --------------------------- Votes ---------------------------------
  if($action =="votes" || $action == "vote_add"){
          if ($action=="vote_add")
          {
            if(!$HTTP_COOKIE_VARS['news_vote_added']){
                  db_query("update news_votes set cnt=cnt+1 where id='$vote_id'");
                  }else{
                          open_table();

                          print "<center>".str_replace('{vote_expire_hours}',$settings['votes_expire_hours'],$phrases['err_vote_expire_hours'])."</center>" ;
                      close_table();
                      }

          }

          $data_title = mysql_fetch_array(mysql_query("select * from news_votes_cats  where active=1"));
          open_table("$data_title[title]");


          $sql = "select * from news_votes where cat=$data_title[id]" ;
          $qr_stat=db_query($sql);


if (mysql_num_rows($qr_stat)){
while($data_stat=db_fetch($qr_stat)){
$total = $total + $data_stat['cnt'];
}

    if($total){
         print "<br>";

  $l_size = getimagesize("images/leftbar.gif");
    $m_size = getimagesize("images/mainbar.gif");
    $r_size = getimagesize("images/rightbar.gif");

$qr_stat=db_query($sql);
 echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\" dir=$global_dir>";
while($data_stat=mysql_fetch_array($qr_stat)){

    $rs[0] = $data_stat['cnt'];
    $rs[1] =  substr(100 * $data_stat['cnt'] / $total, 0, 5);
    $title = $data_stat['title'];

    echo "<tr><td>";


   print " $title:</td><td dir=ltr><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\">";
    print "<img src=\"images/mainbar.gif\"  height=\"$m_size[1]\" width=". $rs[1] * 2 ."><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$l_size[0]\">
    </td><td>
    $rs[1] % ($rs[0])</td>
    </tr>\n";

}
print "</table>";
}else{
        print "<center> $phrases[no_results] </center>";
        }
}

close_table();


  }
 //------------------------------- Search -------------------------------------

 if($action=="search"){
         $keyword = trim($keyword);
         
        if(strlen($keyword) >= $settings['search_min_letters']){
            
            $keyword = htmlspecialchars($keyword);
            
       print "<p align=center class=title>$phrases[search_results]</p>";


        $qr=db_query("select id,title,date,writer,img,left(details,".$preview_text_limit.") as details from news_news where title like '%".db_clean_string($keyword,"code")."%' or  details  like '%".db_clean_string($keyword,"code")."%' order by title ASC");
       $cnt = db_num($qr) ;

 if($cnt>0){

     while($data = db_fetch($qr)){


  open_table();
                $img_url = get_image($data['img']) ;
   $template = get_template('browse_news');
   $news_date = date("d-m-Y",strtotime($data['date']));
   $template = str_replace(array('{id}','{title}','{img}','{content}','{writer}','{date}'),array("$data[id]","$data[title]","$img_url",str_replace($keyword,"<font color=red>$keyword</font>",getPreviewText("$data[details]")),"$data[writer]","$news_date"),$template);

       print "$template";
close_table();

    }



      }else{
                print "<center>  $phrases[no_results] </center>";
                }


//-----------------------------------------------------

         }else{
         open_table();
         $phrases['type_search_keyword'] = str_replace('{letters}',$settings['search_min_letters'],$phrases['type_search_keyword']);
                 print "<center>  $phrases[type_search_keyword] </center>";
                 close_table();
                 }

         }
 //---------------------------- Pages -------------------------------------
 if($action=="pages"){
        $qr = db_query("select * from news_pages where active=1 and id='$id'");
         if(db_num($qr)){
         $data = db_fetch($qr);
         open_table("$data[title]");
                  run_php($data['content']);
                  close_table();
                  }else{
                  open_table();
                          print "<center>  $phrases[err_no_page] </center>";
                          close_table();
                          }
             }
//--------------------- Copyrights ----------------------------------
 if($action=="copyrights"){
 	global $global_lang;

     open_table();
if($global_lang=="arabic"){
     print "<center>
     „—Œ’ ·‹ : $_SERVER[HTTP_HOST]   „‰ <a href='http://allomani.com/' target='_blank'>  «··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ… </a> <br><br>

   Ã„Ì⁄ ÕﬁÊﬁ «·»—„Ã… „Õ›ÊŸ…
                        <a target=\"_blank\" href=\"http://allomani.com/\">
                       ··Ê„«‰Ì ··Œœ„«  «·»—„ÃÌ…
                        © 2008";
  }else{
       print "<center>
     Licensed for : $_SERVER[HTTP_HOST]   by <a href='http://allomani.com/' target='_blank'>Allomani&trade; Programming Services </a> <br><br>

   <p align=center>
Programmed By <a target=\"_blank\" href=\"http://allomani.com/\"> Allomani&trade; Programming Services </a> © 2008";
  	}
     close_table();
         }


//--------------- Load Index Plugins --------------------------
$dhx = opendir(CWD ."/plugins");
while ($rdx = readdir($dhx)){
         if($rdx != "." && $rdx != "..") {
                 $cur_fl = CWD ."/plugins/" . $rdx . "/index.php" ;
        if(file_exists($cur_fl)){
                include $cur_fl ;
                }
          }

    }
closedir($dhx);


//---------------------  Banners ------------------------------------------------------
$qr = db_query("select * from news_banners where type='footer' and pages like '%$pg_view%' order by ord");
while($data = db_fetch($qr)){
db_query("update news_banners set views=views+1 where id='$data[id]'");

if($data['c_type']=="code"){
	print $data['content'];
	}else{
print "<center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a><br></center>";
}
        }
 print "<br>";


//---------------------------END OF CENTER CONTENT--------------------------------------
print "</td>" ;
get_pg_view();
 if(!in_array($pg_view,$actions_list)){$pg_view = "main" ;}

 $zqr=db_query("select * from news_blocks where pos='l' and active=1 and pages like '%$pg_view%' order by ord");

  if(db_num($zqr)){
print "<td width='$blocks_width' valign=\"top\">";

print "<center><table width=100%>";


             $adv_c= 1 ;
         while($zdata = db_fetch($zqr)){
        print "<tr>
                <td  width=\"100%\" valign=\"top\">";
                open_block($zdata['title'],$zdata['template']);

                run_php($zdata['file']);

                close_block($zdata['template']);

                print "</td>
        </tr>";

              //---------------------------------------------------

        $adv_menu_qr = db_query("select * from news_banners where type='menu' and menu_id=$adv_c and menu_pos='l' and pages like '%$pg_view%' order by ord");
        if(db_num($adv_menu_qr)){
                $data = db_fetch($adv_menu_qr) ;
                db_query("update news_banners set views=views+1 where id=$data[id]");
                print "<tr>
                <td  width=\"100%\" valign=\"top\">";
                if($data['c_type']=="code"){
	print $data['content'];
	}else{
                open_block();
             print "<center><a href='banner.php?id=$data[id]' target=_blank><img src='$data[img]' border=0 alt='$data[title]'></a></center>";
               close_block();
               }
                print "</td>
        </tr>";
               }
            ++$adv_c ;
        //----------------------------------------------------
           }

print "</table></center></td>" ;
}
print "</tr></table>\n";


print_copyrights();

site_footer();