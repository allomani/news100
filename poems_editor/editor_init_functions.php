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
function encodeHTML($sHTML)
		{
		$sHTML=ereg_replace("&","&amp;",$sHTML);
		$sHTML=ereg_replace("<","&lt;",$sHTML);
		$sHTML=ereg_replace(">","&gt;",$sHTML);
		return $sHTML;
		}

function editor_html_init(){
 return true;
}

function editor_init() {

}

function editor_print_form($name,$width,$height,$content){
    global $global_dir,$script_path;
?>

<p align="center"><font face="Tahoma" size="2">„·«ÕŸ… : »≈„ﬂ«‰ﬂ ﬂ «»… «·ﬁ’Ìœ… ›Ì ⁄„ÊœÌ‰ »√‰ Ì›’· ‘ÿ—Ì ﬂ· »Ì  »⁄·«„… &quot;=&quot; 
</font><b><font face="Simplified Arabic"> 
<TABLE border=0 dir=rtl width="100%">
  <TBODY>
  
  <TR>
    <TD align=middle colSpan=2><B><FONT face="Tahoma" 
      size=3><SUP><U>«·ﬁ’Ìœ… :</U></SUP></FONT></B></font><font face="Tahoma"> <BR>
    </font><font face="Tahoma">
    <TEXTAREA cols=56 dir=rtl name=poetry rows=6 style="TEXT-ALIGN: right"><? print $content;?></TEXTAREA> 
    </TD></TR></TBODY></TABLE> 
</font>
<font face="Tahoma">
<DIV align=center id=tblPoetry>
<TABLE border=0 height=1 width=185>
  <TBODY>
  <TR>
    <TD noWrap><U><B><SUP>«·Œÿ :</SUP></B></U></TD>
    </font><font face="Simplified Arabic">
    <TD noWrap><font face="Tahoma"><SELECT onchange="fname=selectFont(this); doJustify();" size=1> 
        <OPTION>Andalus<OPTION>Arabic 
        Transparent<OPTION>Arial<OPTION>Courier<OPTION>Courier New<OPTION>MS 
        Dialog<OPTION>MS Sans Serif<OPTION >Simplified 
        Arabic<OPTION selected>Tahoma<OPTION>Times New Roman<OPTION>Traditional 
        Arabic<OPTION>Custom ...</OPTION></SELECT> </TD>
    </font>
    <TD noWrap><font face="Tahoma"><SELECT 
      onchange="fsize=this.options(this.selectedIndex).text; doJustify();" 
      size=1> <OPTION>8<OPTION selected>10<OPTION>12<OPTION 
        >14<OPTION>16<OPTION>18<OPTION>20</OPTION></SELECT> </TD>
    </font>
    <TD noWrap><BUTTON 
      onclick="fbold=!fbold; doJustify();"><font face="Tahoma"><B>€«„ﬁ</B></font></BUTTON>
    </font></TD>
    <TD noWrap><BUTTON 
      onclick="fitalic=!fitalic; doJustify();"><font face="Tahoma"><I>„«∆·</I></font></BUTTON>
    </font></TD>
    <TD noWrap><BUTTON 
      onclick="fcolor=getColor(fcolor,0); ToHTML();"><font face="Tahoma">·Ê‰</font></BUTTON>
    </font></TD>
    <font face="Tahoma">
    <TD noWrap>|</TD>
    <TD noWrap><U><B><SUP>«·Œ·›Ì… :</SUP></B></U> </TD>
    </font>
    <TD noWrap><BUTTON 
      onclick="bkcolor=getColor(bkcolor,1); ToHTML();"><font face="Tahoma">·Ê‰</font></BUTTON>
    </font></TD>
    <font face="Tahoma">
    <TD noWrap><SUP>’Ê—…: </SUP></font><font face="Simplified Arabic">
    <font face="Tahoma"><SELECT id=selImg 
      onchange="bkimage=selImages(this); ToHTML();" size=1> <OPTION 
        selected>‘›«›<OPTION>—«»ÿ...</OPTION></SELECT> </TD></TR></TBODY></TABLE>
<DIV>
<TABLE border=0 width=1>
  <TBODY>
  <TR>
    <TD noWrap><U><B><SUP>«·›«’·:</SUP></B></U></TD>
    </font><font face="Simplified Arabic">
    <TD noWrap><font face="Tahoma"><SELECT onchange="ibsize=this.selectedIndex; doJustify();" 
      size=1> <OPTION>»·« ≈ÿ«—<OPTION>1<OPTION 
        selected>2<OPTION>3<OPTION>4<OPTION>5<OPTION>6<OPTION>7</OPTION></SELECT> 
    </TD>
    <TD noWrap><SUP>&nbsp;—„“: </SUP></font><font face="Simplified Arabic">
    <font face="Tahoma"><INPUT 
      onchange=ibchar=this.value size=1 side="2"> </TD>
    <TD noWrap>&nbsp;</font><font face="Simplified Arabic"><BUTTON 
      onclick="ibcolor=getColor(ibcolor,0); ToHTML();"><font face="Tahoma">·Ê‰</font></BUTTON>
    </font></TD></TR></TBODY></TABLE></DIV>
<DIV>
<TABLE border=0 width="28%">
  <TBODY>
  <TR>
    <TD noWrap width="33%"><font face="Tahoma"><INPUT CHECKED name=justifyYN onclick=doJustify() 
      type=checkbox value=ON> <B><SUP> ‰”Ìﬁ |</SUP></B><SUP>&nbsp;</SUP></TD>
    <TD noWrap width="33%"><font face="Tahoma">&nbsp;<B><SUP>‘ﬂ·:</SUP> </B></font>
    </font>
    <font face="Tahoma"><SELECT 
      onchange="pType=this.selectedIndex; doJustify();" size=1> <OPTION 
        selected>⁄„ÊœÌ‰<OPTION>„‰Õœ—<OPTION>„ œ«Œ·<OPTION>⁄„Êœ<OPTION> Ê”ÿ</OPTION></SELECT> 
    </TD>
    <TD noWrap width="34%"><font face="Tahoma">&nbsp;<B><SUP>ﬂÌ›Ì… «· ‰”Ìﬁ:</SUP></B> 
      </font></font><font face="Tahoma"> 
      <SELECT onchange="pUse=this.selectedIndex; doJustify();" size=1> <OPTION 
        selected>ﬂ·„«  „ »«⁄œ…<OPTION>ﬂ·„«  „„ œ…</OPTION></SELECT> 
</TD></TR></TBODY></TABLE></DIV></DIV>
</font>

<DIV align=center><BUTTON onclick=doJustify()><font face="Tahoma">„⁄«Ì‰…</font></BUTTON>
    </font></DIV>
<HR style="border-style: dashed; border-width: 1px" size="1" color=#000000>

<CENTER> 
<P id=hear></P>

<HR style="border-style: dashed; border-width: 1px" size="1" color=#000000>
<P id=code style="DISPLAY: none"><font face="Tahoma"><TEXTAREA dir=ltr name='<? print $name;?>' ></TEXTAREA></font></P>

</CENTER>
<font face="Tahoma">
<TABLE border=0 width=0>
  <TBODY>
  <TR>
    <TD id=getWidth noWrap style="VISIBILITY: hidden" 
  width=0>Testing</TD></TR></TBODY></TABLE></NOSCRIPT>

<SCRIPT language=javascript>  

  var side, side1, side2, spaceWidth, extendWidth, dif, pType = 0; pLine = 0, pAlign = "center", pUse = 0;
             
            
  var let1 = "&#1575;&#1571;&#1573;&#1570;&#1572;&#1569;&#1583;&#1584;&#1585;&#1586;&#1608;&#1577;&#1609;"
  var let2 = "&#1575;&#1571;&#1573;&#1570;&#1572;&#1574;&#1576;&#1578;&#1579;&#1580;&#1581;&#1582;&#1583;&#1584;&#1585;&#1586;&#1587;&#1588;&#1589;&#1590;&#1591;&#1592;&#1593;&#1594;&#1601;&#1602;&#1603;&#1604;&#1605;&#1606;&#1607;&#1608;&#1610;&#1577;&#1609;";
  var let3 = "&#1614;&#1611;&#1615;&#1612;&#1616;&#1613;&#1618;&#1617;";

  //poetry
  var fname = "Tahoma", fsize = 10, fbold = false, fitalic = false, fcolor = "black";
  var bkcolor = "", bkimage = "";  
  var obstyle = "double", obsize=0, obcolor="gray";
  var ibsize = 1, ibcolor = "gray", ibchar = "";    
  
  //title
  var fname2 = "Simplified Arabic", fsize2 = 14, fbold2 = true, fitalic2 = false, fcolor2 = "black";
  var bkcolor2 = "", bkimage2 = "";
  var obstyle2 = "double", obsize2=4, obcolor2="gray";
  
  //poet
  var fname3 = "Simplified Arabic", fsize3 = 12, fbold3 = true, fitalic3 = false, fcolor3 = "black";
  var aAlign = "left";
  

  
  function showFormat(i) {    
    tblPoet.style.display = (i==0)?"block":"none";
    tblTitle.style.display = (i==1)?"block":"none";
    tblPoetry.style.display = (i==2)?"block":"none";  
  }
  
  function selImages(ob) {           
    var i = ob.selectedIndex, img = "";
    if (i == 0)
      img = "";
    else if (i == 1) {
      img = window.prompt("Enter an image url:", "");
      if (img == null) img = "";
    }
    else
      img = "http://<? print $_SERVER['HTTP_HOST'].($script_path ? "/".$script_path:"")."/backgrounds/";?>" + ob.options(i).text + ".gif";
    return img;  
  }
  
  function selectFont(ob) {
    var i = ob.selectedIndex, f = "";
    if (i == ob.length - 1) {
      f = window.prompt("Enter a font name :", "");
      if (f == null) f = "";
    }
    else
      f = ob.options(i).text;
    return f;  
  }
  
  function getColor(t, f) {
    var c;
    c = showModalDialog("colors.htm","","help:no; status:no; dialogHeight:40px; dialogWidth:300px");
    if (c == "-1" || (f == 0 && c == ""))
      return t;
    else
      return c;    
  }
  
  function removespace(t) {
    var i, sp = true, s = "";
    for (i = 0; i < t.length; i++) 
      if (t.charAt(i) == " " || t.charAt(i) == "\n") {
        if (!sp) s += t.charAt(i);        
        sp = true;
      }  
      else {
        s += t.charAt(i);
        sp = false;
      }          
    return s;
  }

  function trim(t) {
    var i, f=false;
    for (i = 0; i < t.length ; i++)
      if (t.charAt(i) != " ") { f=true; break; }
    if (!f) return "";      
    for (i = 0; t.charAt(i) == " "; i++);
    t = t.substr(i);
    for (i = t.length-1; t.charAt(i) == " "; i--);
    t = t.substr(0, i+1);
    return t;
  }
  
  function textWidth(t) {
    getWidth.innerHTML= t.replace(/ /gi, "&nbsp;");
    return ((getWidth.clientWidth - 2) * 0.75);
  }
  
  function Replace(t, s1, s2, c) {
    var i = 0, len1 = s1.length; len2 = s2.length;
    while (1) {
      i = t.indexOf(s1, i);
      if (i == -1)
        break;
      else {
        t = t.substr(0, i) + s2 + t.substr(i+len1);
        i += len2;
        if (--c == 0) break;
     }        
    }
    return t
  }
  
  function space(n) {
    if (n == 1)
      return " ";
    return  " " + space(n-1);
  }
  
  function createExtend(t) {
    var s = "";
    var befor = "", ch = "";
    t = t.replace(/«··Â/gi,"@");
    for (i = 0; i < t.length; i++) {
      ch = t.charAt(i);
      if (let2.search(ch.charCodeAt(0)) != -1 || ch.charCodeAt(0) == 1569) {        
        if (befor != "")
          if (let1.search(befor.charCodeAt(0)) == -1 && let2.search(ch.charCodeAt(0)) != -1 && (befor.charCodeAt(0) != 1604 || "&#1575;&#1571;&#1573;&#1570;".search(ch.charCodeAt(0)) == -1))
            s += "^";
        befor = ch;
        s += ch;
      }
      else {
        s += ch;
        if (let3.search(ch.charCodeAt(0)) == -1)
          befor = "";
      }        
    }
    s = s.replace(/@/gi,"«··Â");
    return s;
  }
  
  function extend(n) {
    if (n == 1)
      return "‹";
    return  "‹" + extend(n-1);
  } 

  function justifyBYextend(t, w) {
    var sp = 0, i, d;
    t = createExtend(t);    
    for (i = 0; i < t.length; i++)
      sp += (t.charAt(i) == "^");
    if (sp == 0) return t;
    d = Math.floor((w - textWidth(t.replace(/\^/gi,""))) / extendWidth);
    n = Math.floor(d / sp);
    if (n > 0)
      t = t.replace(/\^/gi, extend(n)+"^");
    if (d % sp > 0)
      t = Replace(t, "^", extend(1), d % sp);
    t = t.replace(/\^/gi, ""); 
    return t;
  }
  
  function justifyBYspace(t, w) {
    var sp = 0, i, d, tw;
    for (i = 0; i < t.length; i++)
      sp += (t.charAt(i) == " ");
    if (sp == 0) return justifyBYextend(t, w);
    d = Math.floor((w - textWidth(t)) / spaceWidth);
    n = Math.floor(d / sp);
    if (n > 0)
      t = t.replace(/ /gi, space(n + 1));
    if (d % sp > 0)
      t = Replace(t, space(n + 1), space(n + 2), d % sp);
    tw = w - textWidth(t);
    if (tw - dif > 0) {
      i = t.lastIndexOf(" ");
      if (i != 0)
        t = t.substr(0, i+1) + "<span^style='font-size:1pt;letter-spacing:" +
          tw + "pt;visibility:hidden;'>ii</span>" + t.substr(i+1);
    }
    return t; 
  }
  
  function justify(t, w) {
    if (pUse) t = justifyBYextend(t, w);    
    return justifyBYspace(t, w);  
  }
  
  function doJustify() {
    var L, R, MTW, i, j, cr, txt = sender.poetry.value.replace(/\^/gi,"").replace(/@/gi,"");
    getWidth.parentElement.style.font = (fitalic?"italic":"normal")+" normal "+(fbold?"bold ":"normal ")+fsize+"pt "+fname;        
    getWidth.innerHTML = "<span style='font-size:1pt;letter-spacing:normal'>ii</span>";
    dif = (getWidth.clientWidth) * 0.75;
    extendWidth = textWidth("&#1575;" + "&#1600;&#1600;" + "&#1575;");
    extendWidth -= textWidth("&#1575;" + "&#1600;" + "&#1575;");
    spaceWidth = textWidth("&#1575;" + "&nbsp;&nbsp;" + "&#1575;");
    spaceWidth -= textWidth("&#1575;" + "&nbsp;" + "&#1575;");
    txt += "\r";
    cr = 0;
    j = 0;    
    MTW = 0;
    while (1) {
      cr = txt.indexOf("\r", cr);
      if (cr == -1) break;
      i = txt.indexOf("=", j);
      if (i == -1 || i > cr) i = cr;
      L = removespace(trim(txt.substring(j, i)));
      if (textWidth(L) > MTW) MTW = textWidth(L);
      R = removespace(trim(txt.substring(i+1, cr)));
      if (textWidth(R) > MTW) MTW = textWidth(R);
      cr += 2
      j = cr;      
    }
    
    side1 = "";
    side2 = "";
    side = "";
    cr = 0;
    j = 0;
    var br = ((pLine == 0)?"":"<br>");
    while (1) {
      cr = txt.indexOf("\r", cr);
      if (cr == -1) break;
      if (trim(txt.substring(j, cr)) != "") {
        i = txt.indexOf("=", j);        
        if (i == -1 || i > cr) i = cr;
        L = removespace(trim(txt.substring(j, i)));
        R = removespace(trim(txt.substring(i+1, cr)));
        if (sender.justifyYN.status && L != "") 
          L = justify(L, MTW);          
        L = L.replace(/ /gi, "&nbsp;");
        L = L.replace(/\^/gi, " ");
                
        if (sender.justifyYN.status && R != "") 
          R = justify(R, MTW);
        R = R.replace(/ /gi, "&nbsp;");
        R = R.replace(/\^/gi, " ");
        
        if (pType == 0) {
          side1 += L + "<br>" + br;
          side2 += R + "<br>" + br;
          side += ibchar + "<br>" + br;
        }         
        else if (pType == 1) {
          side1 += "<div style='margin-left:"+Math.round(MTW)+"pt'>" + L + "</div>" + br;
          side1 += "<div style='margin-right:"+Math.round(MTW)+"pt'>" + R + "</div>" + br;
        }
        else if (pType == 2) {
          side1 += "<div style='margin-left:"+Math.floor(MTW/1.5)+"pt'>" + L + "</div>" + br;
          side1 += "<div style='margin-right:"+Math.floor(MTW/1.5)+"pt'>" + R + "</div>" + br;
        }
        else if (pType == 3) {
          side1 += L + br + "<br>" + "<bt>" + R + "<br>" + "<br>" ;
        }
        else {          
          if (R != "\r") {
             side1 += "<tr><td width='0' align='right' valign='top' nowrap>" + L  + "</td>";
             side1 += "<td width='10px' align='center' nowrap>" + ibchar + "</td>";             
             side1 += "<td width='0' align='left' valign='top' nowrap>" + R + "</td></tr>";
          }  
          else
            side1 += "<tr><td align='center' colspan='3' nowrap>" + L + "</td></tr>";
        }
      }
      else {
        side1 += "<br>";
        side2 += "<br>";
        side += "<br>";
      }
      cr += 2;
      j = cr;      
    }
    if (pType == 0 || pType == 3) {
      side1 = side1.substr(0, side1.lastIndexOf("<br>"+br));
      side2 = side2.substr(0, side2.lastIndexOf("<br>"+br));
      side = side.substr(0, side.lastIndexOf("<br>"+br));
   } else if (pLine != 0 && ptype != 4) {
      side1 = side1.substr(0, side1.lastIndexOf(br));
      side2 = side2.substr(0, side2.lastIndexOf(br));
      side = side.substr(0, side.lastIndexOf(br));
   }
   ToHTML();
  }
  
  function ToHTML() {
    var poetstyle, titlestyle, poetrystyle, middlestyle="";
    
    poetstyle = "font:"+(fitalic3?"italic":"normal") + " normal " + (fbold3?"bold ":"normal ") + fsize3 + "pt " + fname3;
    poetstyle += "; color:" + fcolor3;
    
    titlestyle = "; font:"+(fitalic2?"italic":"normal") + " normal " + (fbold2?"bold ":"normal ") + fsize2 + "pt " + fname2;
    titlestyle += "; color:" + fcolor2;
    titlestyle += "; background-image:url(" + bkimage2 + "); background-color:" + bkcolor2;
    titlestyle += "; border:"+ obsize2 +" " + obstyle2 +" " + obcolor2;

    poetrystyle = "font:"+(fitalic?"italic":"normal") + " normal " + (fbold?"bold ":"normal ") + fsize + "pt " + fname;
    poetrystyle += "; color:" + fcolor;
    poetrystyle += "; background-image:url(" + bkimage + "); background-color:" + bkcolor;
    poetrystyle += "; border:" + obsize +" " + obstyle +" " + obcolor;
    
    if (trim(ibchar)=="")
      middlestyle = "border:" + ibsize + "; border-right-style: solid; border-right-color:" + ibcolor;
    else
      middlestyle = "color:" + ibcolor;
      
    HTML = "<table cellspacing='20' cellpadding='0' dir='rtl' border='0' width='0' style='" + poetrystyle + "'>";
   
    if (pType == 4)
      HTML += side1 + "</table>";
    else {  
      HTML += "<tr><td width='0' align='" + ((pType!=0)?"center":"right") +"' valign='top' nowrap>" + side1 + "</td>";    
      if (pType == 0 && sender.poetry.value.search("=") != -1) {
        HTML += "<td width='4' align='center' valign='top' style='" + middlestyle + "' nowrap>" + side + "</td>";
        HTML += "<td width='0' align='left' valign='top' nowrap>" + side2 + "</td>";
      }
      HTML += "</tr></table>";
    }  
    hear.align = pAlign;
    hear.innerHTML = HTML;
    sender.<? print $name;?>.value = "<div align='" + pAlign + "'>" + HTML + "</div>";
  }

</SCRIPT>

<?

	}
