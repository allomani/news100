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
print "<?xml version=\"1.0\" encoding=\"windows-1256\" ?> \n";
$siteurl = "http://$_SERVER[HTTP_HOST]" ;
$scripturl = $siteurl . (trim($script_path) ? "/".$script_path : "");
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?

//---------- cats -------------
$qr=db_query("select id from news_cats order by id desc");
while($data = db_fetch($qr)){
print "<url>
<loc>$scripturl/browse_$data[id].html</loc>
<changefreq>daily</changefreq>
<priority>0.50</priority>
</url>";    
}
//---------- News  -------------
$qr=db_query("select id from news_news order by id desc");
while($data = db_fetch($qr)){
print "<url>
<loc>$scripturl/news-$data[id].html</loc>
<changefreq>daily</changefreq>
<priority>0.50</priority>
</url>";    
}

           

print "</urlset>";

