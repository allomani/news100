function creat_Object()
{ 
var xmlhttp;
// This if condition for Firefox and Opera Browsers 
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') 
{
try 
{
xmlhttp = new XMLHttpRequest();
} 
catch (e) 
{
alert("Your browser is not supporting XMLHTTPRequest");
xmlhttp = false;
}
}
// else condition for ie
else
{
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
return xmlhttp;
}

var request = creat_Object();
function sever_interaction(idd)
{

if(request.readyState == 1)
{
document.getElementById(divhandler.divtag).innerHTML='';
document.getElementById(divhandler.divtag).innerHTML = '<center><img src="images/ajax-loader.gif" /></center>';
}

if(request.readyState == 4)
{
var answer = request.responseText;



document.getElementById(divhandler.divtag).innerHTML='';
document.getElementById(divhandler.divtag).innerHTML = answer;

}
}




function handleDivTag(divtag) 
{ 
   var divtag; 
   return divtag; 
} 

var divhandler = new handleDivTag(null); 



function sam(idd,url){
var tt=idd
document.getElementById('ShowTopic-' + idd).innerHTML = idd;
document.getElementById('ShowTopic-' + idd).style.display = "block";


//------------



request.open("GET", url ); 
request.onreadystatechange = sever_interaction;
divhandler.divtag = 'ShowTopic-' + tt; 
   
request.send('');

}
