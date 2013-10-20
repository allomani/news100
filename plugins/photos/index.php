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

if(!defined("CUR_FILENAME")){
        die("You can't access file directly ... ");
}


//------------------------------- photos -------------------
  if($action=="photos"){
  $cat = intval($cat);
  if(!$cat){ $cat=0;}

          $dir_data['cat'] = $cat ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from photos_cats where id='$dir_data[cat]'");


        $dir_content = "<a href='index.php?action=photos&cat=$dir_data[id]'>$dir_data[name]</a> / ". $dir_content  ;

        }
   print "<p align=$global_align><img src='images/link.gif'> <a href='index.php?action=photos&cat=0'>$phrases[photos_album]  </a> / $dir_content " . "<b>$data[name]</b></p>";

  $qr = db_query("select * from photos_cats where cat='$cat'");

    $cats_num = db_num($qr) ;

    if(db_num($qr)){
      open_table();
    print "<center><table width=100%>" ;
    $c=0;
        while($data = db_fetch($qr)){



if ($c==$settings['photos_cells']) {
print "  </tr><TR>" ;
$c = 0 ;
}
    ++$c ;

    if($data['img']){$img_url=$data['img'];}else{$img_url = "images/folder.gif";}
print " <td><center><a href='index.php?action=photos&cat=$data[id]'>
            <img border=0 alt='$phrases[the_name] : $data[name] '
            src='$img_url'>
            <br>$data[name] </a><br>" ;

 print "</center>    </td>";
           }
           print "</tr></table></center>";
           close_table();
         }
    //----------------- pages system ----------------------
    $start = intval($start);
       $page_string= "index.php?action=photos&cat=$cat" ;
       $photos_perpage = intval($settings['photos_perpage']);
  //---------------------------

    $qr = db_query("select * from photos_data where cat='$cat' order by id DESC limit $start,$photos_perpage");
  $page_result = db_qr_fetch("SELECT count(*) as count from photos_data where cat=$cat");

    $data_title = db_qr_fetch("select name from photos_cats where id='$cat'");

      $numrows=$page_result['count'];
$previous_page=$start - $movies_perpage;
$next_page=$start + $photos_perpage;


   $movies_num = db_num($qr) ;

    if(db_num($qr)){
     open_table($data_title['name']);
     print "<script>
     function enlarge_pic(sPicURL) {
msgwindow=window.open( \"enlarge_pic.htm?\"+sPicURL, \"\",\"resizable=1,HEIGHT=10,WIDTH=10\");
}
</script>";
    print "<center><table width=100%>" ;
    $c=0;
        while($data = db_fetch($qr)){



if ($c==$settings['photos_cells']) {
print "  </tr><TR>" ;
$c = 0 ;
}
    ++$c ;
print " <td><center><a href=\"javascript:enlarge_pic('".$data['img']."')\">
            <img border=0 alt='$phrases[add_date] : ".substr($data['date'],0,10)."'
            src='".get_image($data['thumb'])."'>
             </a><br>$data[name]";

 print "</center>    </td>";
           }
           print "</tr></table></center>";
          close_table();
//-------------------- pages system ------------------------
if ($numrows>$photos_perpage){
echo "<p align=center>$phrases[pages] : ";
//----------------------------
if($start >0)
{
$previouspage = $start - $movies_perpage;
echo "<a href=$page_string&start=$previouspage><</a>\n";
}
//------------------------------------------
$pages=intval($numrows/$photos_perpage);
//---------------------------------------
if ($numrows%$photos_perpage)
{
$pages++;
}
//--------------------------------------
for ($i = 1; $i <= $pages; $i++) {

$nextpag = $photos_perpage*($i-1);
//-----------------------------------------

if ($nextpag == $start)
{
echo "<font size=2 face=tahoma><b>$i</b></font>&nbsp;\n";
}
else
{
echo "<a href=$page_string&start=$nextpag>[$i]</a>&nbsp;\n";
}
}
//--------------------------------------------------

if (! ( ($start/$photos_perpage) == ($pages - 1) ) && ($pages != 1) )
{
$nextpag = $start+$photos_perpage;
echo "<a href=$page_string&start=$nextpag>></a>\n";
}
//--------------------------------------------------------------

echo "</p>";
}
//------------ end pages system -------------
            }

if(!$movies_num && !$cats_num){
        open_table();
        print "<center> $phrases[err_no_photos]</center>";
        close_table();
        }


  }
  ?>