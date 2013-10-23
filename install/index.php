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
    chdir('./../');
    define('CWD', (($getcwd = str_replace("\\","/",getcwd())) ? $getcwd : '.'));

    require (CWD ."/install/ClassSQLimport.php");

    //-------------------
    $product_name = "News";
    $product_ver = "1.0";

    $files_perms = array("config.php","uploads/");

    $steps = array(1 => 'Server Requirements' , 2=> 'Configuration' , 3=> 'Database Clean' , 4=> 'Database Installation' , 5=> 'Installation Done');
    $step = (int) $_REQUEST['step'];
    $last_step = count($steps);
    
    $db_versions = array(
    'Arabic' => 'news_ar.sql.gz',
    'English' => 'news_en.sql.gz');
    
    
    //-------------------

    $fn = "verify_step_".$step;
    if($fn()){
        $step += 1;
    }

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <style>
            body {
                font-family: 'Tahoma';
            }

            #content {

                width:60%;
                margin:0 auto;
                border: 1px solid #ccc;
                padding:20px;
                text-align:center;
            }
            .success {
                color: #92C030;
                font-weight: bold;
            }
            .failed {
                color: #9D1A1D;
                font-weight: bold;
            }

            .notice {

                border: 1px solid;
                margin: 10px 0px;
                padding:15px 10px 15px 50px;
                background-repeat: no-repeat;
                background-position: 10px center;
                -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
                color: #9F6000;
                background-color: #FEEFB3;
            }

            table td {
                padding:2px;
                border: 1px solid #ccc;
            }

            form {
                margin:10px;
            }
            
 input[type="submit"] {
    color: #fef4e9;
    font-weight: bold;
    border: solid 1px #da7c0c;
    background: #f78d1d;
    background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
    background: -moz-linear-gradient(top,  #faa51a,  #f47a20);
    filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
     padding:10px 15px;
                margin:10px;
                  -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
}
 input[type="submit"]:hover {
    background: #f47c20;
    background: -webkit-gradient(linear, left top, left bottom, from(#f88e11), to(#f06015));
    background: -moz-linear-gradient(top,  #f88e11,  #f06015);
    filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f88e11', endColorstr='#f06015');
}
 input[type="submit"]:active {
    color: #fcd3a5;
    background: -webkit-gradient(linear, left top, left bottom, from(#f47a20), to(#faa51a));
    background: -moz-linear-gradient(top,  #f47a20,  #faa51a);
    filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f47a20', endColorstr='#faa51a');
}
        
    select {
        font-size: 16px;
        padding:6px;
    }        
            h4 {
                text-align:left;
            }
            
        </style>
        <title>Allomani Installation</title>
    </head>
    <body>

        <div id="content">
            <img src="http://allomani.com/images/logo.gif" alt="Allomani" title="Allomani" />  
            <br />
            <h2><?=$product_name;?> v<?=$product_ver;?> Installation</h2> 
            <h3><?=$steps[$step]?></h3>
            <?
                if($msg){
                    print "<div class='notice'>$msg</div>";
                }

                $fn = "print_step_".$step;
                $fn();
            ?>

        </div>
    </body>
</html>
<?


    //---------- steps functions ------------------------
    function verify_step_0(){
        return true;
    }

    function verify_step_1(){
        global $msg,$files_perms;

        if(function_exists('curl_version')){ 
            $curl = (array) @curl_version();
        }else{
            $curl = array();
        }

        if(!$curl['version_number']){ 
            $msg = 'cURL is not available';
            return false;
        }

        foreach($files_perms as $f){
            if(!is_writable(CWD."/".$f)){
                $msg = "$f is not writable";
                return false;  
            }
        }


        return true;
    }

    function print_step_1(){
        global $step,$files_perms;
        print "

        <h4>Modules</h4>

        <table width=100%\">  

        <tr><td> PHP</td>";


        print "<td><font color=green>Available</font></td>" ;
        print "<td><b>Version :</b> " . phpversion()."</td>" ;


        print "</tr>";


/*
        print "<tr><td>ionCube</td>";

        if(extension_loaded('ionCube Loader')){
            print "<td><font color=green>Available</font></td> " ;
            print "<td><b>Version :</b> " . ioncube_loader_version()."</td>" ;
        }else{
            print "<td><font color=red>Not Available</font></td><td></td>" ;
        }
        print "</tr>";
*/



        print "<tr><td> Mysql </td>";

        if(function_exists("mysql_query")){
            print "<td><font color=green>Available</font></td>" ;
            print "<td><b>Version : <b> <br>" . mysql_get_client_info()."</td>" ;
        }else{
            print "<td><font color=red>Not Available</font></td><td></td>" ;
        }

        print "</tr>";


        print "<tr><td> GD Library </td>";
        if(function_exists("gd_info")){
            $gd_info = @gd_info();
            print "<td><font color=green>Available</font> </td>" ;
            print "<td><b>Version :</b> " . $gd_info['GD Version']."</td>" ;

        }else{
            print "<td><font color=red>Not Available</font></td><td></td>" ;
        }
        print "</tr> ";

        print "<tr><td> cURL</td>";
        if(function_exists('curl_version')){ 
            $curl = (array) @curl_version();
        }else{
            $curl = array();
        }


        if($curl['version_number']){ 
            print "<td><font color=green>Available</font></td>" ;
            print "<td><b>Version :</b> " . $curl['version_number']."</td>" ;
        }else{
            print "<td><font color=red>Not Available</font></td>
            <td></td>" ;
        }
        print "</tr>
        </table>

        <h4>Folders Permissions</h4>

        <table width=100%\">  ";
        foreach($files_perms as $f){
            print "<tr><td>$f</td><td>".iif(is_writeable(CWD ."/".$f),"<font color=green>Yes</font>","<font color=red>No</font>")."</td></tr>";
        }

        print "</table>

        <form action='index.php' method='post'>
        <input type='hidden' name='step' value='".$step."'>
        <input type=submit value='Next'>
        </form>
        ";
    }



    function verify_step_2(){
        global $msg,$db_host,$db_username,$db_password,$db_name;

        //---- write new config ----//
        $config_file = file_get_contents(CWD ."/config.php");
        $config_file = preg_replace("/".'\$'."db_host[\s+]?=[\s+]?\"(.*)\"[\s+]?;/","\$db_host = \"{$_REQUEST['db_host']}\";",$config_file);
        $config_file = preg_replace("/".'\$'."db_name[\s+]?=[\s+]?\"(.*)\"[\s+]?;/","\$db_name = \"{$_REQUEST['db_name']}\";",$config_file);
        $config_file = preg_replace("/".'\$'."db_username[\s+]?=[\s+]?\"(.*)\"[\s+]?;/","\$db_username = \"{$_REQUEST['db_user']}\";",$config_file);
        $config_file = preg_replace("/".'\$'."db_password[\s+]?=[\s+]?\"(.*)\"[\s+]?;/","\$db_password = \"{$_REQUEST['db_pass']}\";",$config_file);
        file_put_contents(CWD ."/config.php",$config_file);
        //---------------------//

        require (CWD . "/config.php");

        if(!mysql_connect($db_host,$db_username,$db_password)){
            $msg = 'Please check database info';
            return false;
        }
        if(!mysql_select_db($db_name)){
            $msg = 'Please check database name';
            return false;
        }
        return true;
    }


    function print_step_2(){
        global $step;

        $config_file = file_get_contents(CWD ."/config.php");

        preg_match("/db_host[\s+]?=[\s+]?\"(.*)\"/",$config_file,$db_host);
        preg_match("/db_name[\s+]?=[\s+]?\"(.*)\"/",$config_file,$db_name);
        preg_match("/db_username[\s+]?=[\s+]?\"(.*)\"/",$config_file,$db_user);
        preg_match("/db_password[\s+]?=[\s+]?\"(.*)\"/",$config_file,$db_pass);


        global $step;
        print "
        <form action='index.php' method='post'>
        <input type='hidden' name='step' value='".$step."'>

        <table width=100%>
        <tr><td>Database Host</td><td><input type=text name='db_host' value=\"".htmlspecialchars($db_host[1])."\"></td></tr>
        <tr><td>Database Username</td><td><input type=text name='db_user' value=\"".htmlspecialchars($db_user[1])."\"></td></tr>
        <tr><td>Database Password</td><td><input type=text name='db_pass' value=\"".htmlspecialchars($db_pass[1])."\"></td></tr>
        <tr><td>Database Name</td><td><input type=text name='db_name' value=\"".htmlspecialchars($db_name[1])."\"></td></tr>
        </table>

        <input type=submit value='Next'>
        </form>";


    }

    function verify_step_3(){
        global $msg;

        require (CWD . "/config.php");

        if(!mysql_connect($db_host,$db_username,$db_password)){
            $msg = 'Please check database info';
            return false;
        }
        if(!mysql_select_db($db_name)){
            $msg = 'Please check database name';
            return false;
        }

        if($_REQUEST['db_force_clean']){
            $qr = mysql_query("show tables");
            while($data = mysql_fetch_array($qr)){
                mysql_query("drop table `$data[0]`");
            }
        }

        $qr = mysql_query("show tables");
        if(mysql_num_rows($qr)){
            $msg = 'Database is not clean';
            return false;
        }


        return true;
    }



    function print_step_3(){
        global $step;
        print "this will check if database is clean

        <form action='index.php' method='post'>
        <input type='hidden' name='step' value='".$step."'>
        <input type='checkbox' name='db_force_clean' value='1'> Force database cleanup <br>
        <input type=submit value='Next'>
        </form>   ";

    }
    
    
    function verify_step_4(){
        
        global $msg,$db_versions;

        require (CWD . "/config.php");
                                  
    $newImport = new sqlImport ($db_host, $db_username, $db_password,$db_name, CWD."/install/".$_REQUEST['db_version']);
$newImport -> import ();
    
    $result= $newImport -> ShowErr ();
     if(!$result['exito']){
       
      $msg = "Database Import Error : " .$result['errorText'];  
     return false;
     }
     
     return true;
    }
    

    function print_step_4(){
       global $step,$db_versions;
       
       print "
       <form action='index.php' method='post'>
        <input type='hidden' name='step' value='".$step."'>
        Select phrases version : <br>";
      print_select_row('db_version',array_flip($db_versions));
       print "
        <input type=submit value='Next'>
        </form>" ;
    }
    
    
    function print_step_5(){
        print "<span class='success'>Installation done successfully.</span> ";
   /*     <br><br>
       <form action='../license_gen.php' method='post'> 
       <input type='submit' value='Activate your License'>
       </form>";   */
        
    }

    //----------- select row ------------
    function print_select_row($name, $array, $selected = '', $options="" , $size = 0, $multiple = false,$same_values=false)
    {
        global $vbulletin;

        $select = "<select name=\"$name\" id=\"sel_$name\"" . iif($size, " size=\"$size\"") . iif($multiple, ' multiple="multiple"') . iif($options , " $options").">\n";
        $select .= construct_select_options($array, $selected,$same_values);
        $select .= "</select>\n";

        print $select;
    }


    function construct_select_options($array, $selectedid = '',$same_values=false)
    {
        if (is_array($array))
        {
            $options = '';
            foreach($array AS $key => $val)
            {
                if (is_array($val))
                {
                    $options .= "\t\t<optgroup label=\"" . $key . "\">\n";
                    $options .= construct_select_options($val, $selectedid, $tabindex, $htmlise);
                    $options .= "\t\t</optgroup>\n";
                }
                else
                {
                    if (is_array($selectedid))
                    {
                        $selected = iif(in_array($key, $selectedid), ' selected="selected"', '');
                    }
                    else
                    {
                        $selected = iif($key == $selectedid, ' selected="selected"', '');
                    }
                    $options .= "\t\t<option value=\"".($same_values ? $val : $key). "\"$selected>" . $val . "</option>\n";
                }
            }
        }
        return $options;
    }

    //--------- iif expression ------------
    function iif($expression, $returntrue, $returnfalse = '')
    {
        return ($expression ? $returntrue : $returnfalse);
    }
?> 