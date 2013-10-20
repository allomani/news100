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
include "global.php" ;
header('Content-Type: text/html;charset=windows-1256');
$id = intval($id);
$qr = db_query("select left(details,".$preview_text_limit.") as details from news_news where id='$id'") or die(mysql_error());

$data = db_fetch($qr);


  print (getPreviewText($data["details"])."...");
