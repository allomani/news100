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
if($action=="events" || $action=="events_add_ok" || $action=="events_edit_ok" || $action=="events_del"){

if_admin("events");

if($action=="events_add_ok"){
	db_query("insert into events_data (name,content,day,month,year,typeid) values('$name','$content','$day','$month','$year','$typeid')");
	}

if($action=="events_edit_ok"){
	db_query("update events_data set name='$name',content='$content',day='$day',month='$month',year='$year',typeid='$typeid' where id='$id'");
	}

if($action=="events_del"){
	db_query("delete from events_data where id='$id'");
	}

//------------- show events ------------------------
print "<center> [ <a href='index.php?action=events_add'> $phrases[add_event] </a> ] </center><br>";
$qr = db_query("select * from events_data order by day,month,year DESC");
if(db_num($qr)){
print "<center><table width=98% class=grid>";
while($data = db_fetch($qr)){

$datax = db_qr_fetch("select * from events_types where id='$data[typeid]'");

 print "<tr><td width=5 bgcolor='$datax[color]'>&nbsp;&nbsp;&nbsp;</td>
 <td><span dir=ltr>$data[day]/$data[month]/$data[year]</span></td>

 <td width=50%>$data[name]</td>
 <td>$datax[name]</td>
 <td> <a href='index.php?action=events_edit&id=$data[id]'> $phrases[edit] </a>
 - <a href='index.php?action=events_del&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\"> $phrases[delete] </a></td></tr>";
}

print "</table></center>";
}else{
	print "<center><table width=50% class=grid><tr><td><center>  $phrases[no_events] </center></td></tr></table></center>";
   }
         }

//------------------------ events edit -------------------------------------------
if($action == "events_edit"){

if_admin("events");

   $id=intval($id);

  $qr=db_query("select * from events_data where id='$id'");
   if(db_num($qr)){
           $data = db_fetch($qr);


      print " <center>
                <table border=0 width=\"80%\"  style=\"border-collapse: collapse\" class=grid><tr>

                <form method=\"POST\" action=\"index.php\">

                    <input type=hidden name=\"action\" value='events_edit_ok'>
                       <input type=hidden name=\"id\" value='$id'>

                   <tr>
                                <td width=\"100\">
                <b>$phrases[the_date]</b></td><td >
                 <input type=\"text\" name=\"day\" size=\"2\" value='$data[day]'>/<input type=\"text\" name=\"month\" size=\"2\" value='$data[month]'>/<input type=\"text\" name=\"year\" size=\"4\" value='$data[year]'></td>

                  </td>
                        </tr>
                        <tr>
                                <td width=\"100\">
                <b>$phrases[the_title]</b></td><td >
                <input type=\"text\" name=\"name\" size=\"50\" value='$data[name]'></td>
                        </tr>

   <tr>
                                <td width=\"100\">
                <b>$phrases[the_type]</b></td><td >
                <select name=\"typeid\">
                <option value=0>$phrases[without]</option>";
                $qrx=db_query("select * from events_types order by id desc");
                while($datax = db_fetch($qrx)){

                if($data['typeid']==$datax['id']){$chk="selected";}else{$chk="";}

                print "<option value='$datax[id]' $chk>$datax[name]</option>";
                	}
                print "</select></td>
                        </tr>
                              <tr> <td width=\"50\">
                <b>$phrases[the_content]</b></td>
                                <td>";

      editor_print_form("content",600,300,$data['content']);
                        print "</td>
                        </tr>
                 <tr><td colspan=2 align=center>  <input type=\"submit\" value=\"$phrases[edit]\">  </td></tr>




                </table>

</form>    </center>\n";
   }else{
           print "<center> $phrases[err_wrong_url] </center>";
           }
        }

 //--------------------- events add -----------------------
 if($action=="events_add"){
   if_admin("events");



          print "<center><table border=\"0\" width=\"80%\"   cellpadding=\"0\" cellspacing=\"0\" class=\"grid\">
        <tr>
                <td height=\"0\">
                <div align=\"center\">
                <table border=0 width=\"97%\"  style=\"border-collapse: collapse\"><tr>

                <form name=sender method=\"POST\" action=\"index.php\">

                      <input type=hidden name=\"action\" value='events_add_ok'>

               <tr>
                                <td width=\"100\">
                <b>$phrases[the_date]</b></td><td >
                <input type=\"text\" name=\"day\" size=\"2\">/<input type=\"text\" name=\"month\" size=\"2\">/<input type=\"text\" name=\"year\" size=\"4\"></td>
                        </tr>

                        <tr>
                                <td width=\"100\">
                <b>$phrases[the_title]</b></td><td >
                <input type=\"text\" name=\"name\" size=\"50\"></td>
                        </tr>

   <tr>
                                <td width=\"100\">
                <b>$phrases[the_type]</b></td><td >
                <select name=\"typeid\">
                <option value=0>$phrases[without]</option>";
                $qrx=db_query("select * from events_types order by id desc");
                while($datax = db_fetch($qrx)){


                print "<option value='$datax[id]' $chk>$datax[name]</option>";
                	}
                print "</select></td>
                        </tr>

                                          <tr> <td width=\"100\">
                <b>$phrases[the_content]</b></td>
                                <td width=\"223\">";

    editor_print_form("content",600,300,"");

                 print "<input type=\"submit\" value=\"$phrases[add_button]\">
                        </td>
                        </tr>

                </table>
                </div>
                </td>
        </tr>
</table>
</form>    </center>\n";

}


//------------------------- Events Types ----------------------------
if($action=="events_types" || $action=="events_types_add_ok" || $action=="events_types_edit_ok" || $action=="events_types_del"){

if_admin("events");

if($action=="events_types_add_ok"){
	db_query("insert into events_types (name,color) values('$name','$color')");
	}

if($action=="events_types_edit_ok"){
db_query("update events_types set name='$name',color='$color' where id='$id'");
}

if($action=="events_types_del"){
db_query("delete from events_types where id='$id'");
}

$qr = db_query("select * from events_types order by id desc");
    print "<center> [<a href='index.php?action=events_types_add'>$phrases[events_add]</a>]<br><br>" ;
if(db_num($qr)){
 print "

 <table width=90% class=grid>" ;

while($data = db_fetch($qr)){
print "<tr><td width=5 bgcolor='$data[color]'>&nbsp;&nbsp;&nbsp;</td><td>$data[name]</td>
<td align=left><a href='index.php?action=events_types_edit&id=$data[id]'>$phrases[edit]</a>
 - <a href='index.php?action=events_types_del&id=$data[id]' onClick=\"return confirm('Are you sure you want to delete ?');\">$phrases[delete]</a></td></tr>";
	}

	print "</table>";


}else{
	print "<table width='90%' class=grid><tr><td align=center> $phrases[events_no_types]  </td></tr></table>";
	}

}

//---------------------- Events types add ----------------------

if($action=="events_types_add"){

if_admin("events");

print "<center>
<form action='index.php' method=post>
<input name=action value='events_types_add_ok' type=hidden>
<table width=50% class=grid>
<tr><td> $phrases[the_name] </td><td><input type=text size=20 name=name></td></tr>
<tr><td> $phrases[the_color] </td><td><input type=text size=20 name=color dir=ltr></td></tr>
<tr><td colspan=2 align=center><input type=submit value=' $phrases[add_button] '></td></tr>
</table></form></center>";
}

//---------------------- Events types edit ----------------------

if($action=="events_types_edit"){

if_admin("events");

 $id = intval($id);

$qr = db_query("select * from events_types where id='$id'");

if(db_num($qr)){
	$data = db_fetch($qr);

print "<center>
<form action='index.php' method=post>
<input name=action value='events_types_edit_ok' type=hidden>
<input name=id value='$id' type=hidden>
<table width=50% class=grid>
<tr><td> $phrases[the_name] </td><td><input type=text size=20 name=name value='$data[name]'></td></tr>
<tr><td> $phrases[the_color] </td><td><input type=text size=20 name=color dir=ltr value='$data[color]'></td></tr>
<tr><td colspan=2 align=center><input type=submit value=' $phrases[edit] '></td></tr>
</table></form></center>";

}else{
	print "<center> $phrases[err_wrong_url] </center>";

	}
}
