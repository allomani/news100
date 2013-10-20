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
print "<table width=100%>\n";

print "<tr><td width=24><img src='images/home.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php'>$phrases[main_page] </a></td></tr>\n";

print "<tr><td width=24><img src='images/news.gif' width=24></td><td bgcolor=#F4F4F4><a href='index.php?action=news'>$phrases[cp_manage_news]</a></td></tr>\n";

if(if_admin("new_menu",true)){
print "<tr><td width=24><img src='images/news.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php?action=new_menu'>$phrases[cp_selected_news]</a></td></tr>\n";
}

if(if_admin("blocks",true)){
print "<tr><td width=24><img src='images/blocks.gif' width=24></td><td bgcolor=#F4F4F4><a href='index.php?action=blocks'>$phrases[the_blocks]</a></td></tr>\n";
}

if(if_admin("votes",true)){
print "<tr><td width=24><img src='images/votes.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php?action=votes'>$phrases[the_votes]</a></td></tr>\n";
}

if(if_admin("",true)){
print "<tr><td width=24><img src='images/pages.gif' width=24></td><td bgcolor=#F4F4F4><a href='index.php?action=pages'>$phrases[the_pages]</a></td></tr>\n";
}

if(if_admin("adv",true)){
print "<tr><td width=24><img src='images/adv.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php?action=banners'>$phrases[the_banners]</a></td></tr>\n";
}

if(if_admin("",true)){
print "<tr><td width=24><img src='images/statics.gif' width=24></td><td bgcolor=#F4F4F4><a href='index.php?action=statics'>$phrases[the_statics_and_counters]</a></td></tr>\n";
}

if(if_admin("templates",true)){
print "<tr><td width=24><img src='images/templates.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php?action=templates'>$phrases[the_templates]</a></td></tr>\n";
}

if(if_admin("phrases",true)){
print "<tr><td width=24><img src='images/phrases.gif' width=24></td><td bgcolor=#F4F4F4><a href='index.php?action=phrases'>$phrases[the_phrases]</a></td></tr>\n";
}


//--------------- Load Menu Plugins --------------------------
$dhx = opendir(CWD ."/plugins");
while ($rdx = readdir($dhx)){
         if($rdx != "." && $rdx != "..") {
                 $cur_fl = CWD ."/plugins/" . $rdx . "/menu.php" ;
        if(file_exists($cur_fl)){
                include $cur_fl ;
                }
          }

    }
closedir($dhx);


if(if_admin("",true)){
print "<tr><td width=24><img src='images/stng.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php?action=settings'>$phrases[the_settings]</a></td></tr>\n";
}

if(if_admin("",true)){
print "<tr><td width=24><img src='images/db_info.gif' width=24></td><td bgcolor=#F4F4F4><a href='index.php?action=db_info'>$phrases[the_database]</a></td></tr>\n";
print "<tr><td width=24><img src='images/db_backup.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php?action=backup_db'>$phrases[backup]</a></td></tr>\n";
}

print "<tr><td width=24><img src='images/users2.gif' width=24></td><td bgcolor=#F4F4F4><a href='index.php?action=users'>$phrases[users_and_permissions]</a></td></tr>\n";

print "<tr><td width=24><img src='images/user_off.gif' width=24></td><td bgcolor=#FFFFFF><a href='index.php?action=logout'>$phrases[logout]</a></td></tr>\n";

print "</table>\n";
