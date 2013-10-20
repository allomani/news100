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
header('Content-type: text/xml');
include "global.php" ;
$siteurl = "http://$_SERVER[HTTP_HOST]" ;
$scripturl = $siteurl . (trim($script_path) ? "/".$script_path : "");
print "<?xml version=\"1.0\" encoding=\"windows-1256\" ?> \n";
?>
<rss version="2.0">
<channel>
<? print "<title>$sitename</title>\n";?>
<description></description>
<?print "<link>http://".$_SERVER['HTTP_HOST']."</link>\n";
print "<copyright>$settings[copyrights_sitename]</copyright>";
?>

<?

$qr = mysql_query("select id,title,date,writer,img,left(details,".$preview_text_limit.") as details from news_news order by id desc limit 100") or die(mysql_error());

while($data = mysql_fetch_array($qr)){

$data_cat = db_qr_fetch("select name from news_cats where id='$data[cat]'");
   print "  <item>
        <title><![CDATA[".$data["title"]."]]></title>
        <description><![CDATA[ <img align=center src=\"".get_image($data['img'])."\"><br><br>
        ".getPreviewText($data["details"]) . "<br><br>" . "<a href=\"".$scripturl."/news-$data[id].html\">$phrases[more] ... </a>" ;

                print "]]></description>
        <link>".htmlentities($scripturl."/news-$data[id].html")."</link>
        <category>$data_cat[name]</category>
     </item>\n";
     }

print "</channel>
</rss>";