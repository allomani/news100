<?

function encodeHTML($sHTML)
		{
		$sHTML=str_replace("&","&amp;",$sHTML);
		$sHTML=str_replace("<","&lt;",$sHTML);
		$sHTML=str_replace(">","&gt;",$sHTML);
		return $sHTML;
		}

function editor_html_init(){
    global $script_path;

if(trim($script_path)){$script_path="$script_path/";}

$scripturl = "http://$_SERVER[HTTP_HOST]/".$script_path  ;


print "<script language=JavaScript src='".$scripturl."/ckeditor/ckeditor.js'></script>" ;

}

function editor_init() {

}

function editor_print_form($name,$width,$height,$content){
    global $global_dir,$global_lang;
	print "<textarea id=\"$name\" name=\"$name\" rows=4 cols=30>\n";



if($content){
	print encodeHTML($content);
	}else{
        print encodeHTML("<div dir=$global_dir></div>");
    }

print "</textarea>

	<script>
		CKEDITOR.replace('$name',{language:'".($global_lang=="arabic" ? "ar" : "en")."'});
	</script>";

	}
