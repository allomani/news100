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
$actions_checks["$phrases[the_events]"] = 'browse_events' ;

array_push($actions_list,'browse_events');

$actions_text .= ",browse_events" ;

$permissions_checks["$phrases[the_events]"]  = "events" ;
?>