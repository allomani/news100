function set_checked_color(id,box){
if(box.checked == true){
document.getElementById(id).style.backgroundColor='#EFEFEF';
}else{
document.getElementById(id).style.backgroundColor='#FFFFFF';
}
}

function CheckAll()
{
count = document.submit_form.elements.length;
    for (i=0; i < count; i++) 
	{
    if((document.submit_form.elements[i].checked == 1) ||(document.submit_form.elements[i].checked == 0))
    	{document.submit_form.elements[i].checked = 1; }
  
	}
}
function UncheckAll(){
count = document.submit_form.elements.length;
    for (i=0; i < count; i++) 
	{
    if((document.submit_form.elements[i].checked == 1) || (document.submit_form.elements[i].checked == 0))
    	{document.submit_form.elements[i].checked = 0; }

	}
}

function show_options(box){

//box = document.forms['submit_form'].action;
	nms = box.options[box.selectedIndex].value;

if (nms == 'song_album_set') {
document.getElementById("albums_set_div").style.display = "inline";
document.getElementById("comments_set_div").style.display = "none";
}else if(nms == 'song_comment_set'){
document.getElementById("albums_set_div").style.display = "none";
document.getElementById("comments_set_div").style.display = "inline";
}else{
document.getElementById("albums_set_div").style.display = "none";
document.getElementById("comments_set_div").style.display = "none";
}

}

function show_adv_options(box){

	nms = box.options[box.selectedIndex].value;

if (nms == 'menu') {
document.getElementById("add_after_menu").style.display = "inline";
document.getElementById("add_after_menu2").style.display = "inline";
}else{
document.getElementById("add_after_menu").style.display = "none";
document.getElementById("add_after_menu2").style.display = "none";
}

}

function show_banner_code(){

document.getElementById("banners_code_area").style.display = "inline";

document.getElementById("banners_img_area").style.display = "none";
document.getElementById("banners_url_area").style.display = "none"
}

function show_banner_img(){

document.getElementById("banners_code_area").style.display = "none";

document.getElementById("banners_img_area").style.display = "inline";
document.getElementById("banners_url_area").style.display = "inline"
}

function set_tr_color(tr,color){

if(tr.style.backgroundColor !='#efefef'){
tr.style.backgroundColor=color;
}
}

function set_menu_pages(box){

nms = box.options[box.selectedIndex].value;

if (nms == 'c') {
count = document.submit_form.elements.length;
    for (i=0; i < count; i++) 
	{
    if((document.submit_form.elements[i].checked == 1) ||(document.submit_form.elements[i].checked == 0))
    	{
if(document.submit_form.elements[i].name == 'pages[0]'){
document.submit_form.elements[i].checked = 1; 
}else{
document.submit_form.elements[i].checked = 0; 
}
}

  
	}
}else{
count = document.submit_form.elements.length;
    for (i=0; i < count; i++) 
	{
    if((document.submit_form.elements[i].checked == 1) ||(document.submit_form.elements[i].checked == 0))
    	{document.submit_form.elements[i].checked = 1; }
  
	}
}

}


function uploader(folder,f_name)
{

msgwindow=window.open("uploader.php?folder="+folder+"&f_name="+f_name,"displaywindow","toolbar=no,scrollbars=no,width=520,height=160,top=200,left=200")
}

function uploader2(folder,f_name,frm)
{

msgwindow=window.open("uploader.php?folder="+folder+"&f_name="+f_name+"&frm="+frm,"displaywindow","toolbar=no,scrollbars=no,width=520,height=160,top=200,left=200")
}


function cats_list()
{

msgwindow=window.open("get_catid.php","displaywindow","toolbar=no,scrollbars=yes,resizable=yes,width=350,height=250,top=200,left=200")
}
