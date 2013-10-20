<?php


class calendar {
    // Déclaration de toutes les variables membres
    // array contenant les infos de config du calendrier
    var $CFG = array("month_chiffre" => "", "year" => "", "lng" => "");
    var $buffer;
    var $url;
    // Futur array contenant les jours pour lesquels un lien est nécessaire (voir méthode links)
    var $LINKS;
    // variables de config mais changeables directement, sans méthode particulière (moins lourd)
    var $monday_1st; //Quel type de calendrier ? 0 => commence par Dimanche 1 => commence par Lundi
    // variables de fonctionnements, privées (uniquement pour des calculs)
    var $jour_1er_du_mois;
    var $jour_1er_du_mois_chiffre;
    var $cases_vides_debut;
    var $cases_vides_fin;
    var $nombre_jour_du_mois;
    var $use_links;

    var $allow_change = 1;
	var $prev = '&lt;';
	var $next = '&gt;';

    // Initialisation de qqs données, vérifications, on détermine nom du calendrier, mois et année.
    function calendar($month_chiffre = 'auto', $year = 'auto', $lng = 'en')
    {
        $this->CFG['lng'] = $lng;
        $this->CFG['year'] = $year;
        $this->CFG['month_chiffre'] = $month_chiffre;

		//On vérifie s'il y a des options données pour la date : par url ou auto. NEW 02/24/'05
		if($_GET['calmonth'] !== '' && $_GET['calmonth'] > 0 && $_GET['calmonth'] <= 12)
			$this->CFG['month_chiffre'] = intval($_GET['calmonth']);
		elseif($_GET['calmonth'] == '' && $this->CFG['month_chiffre'] == 'auto')
            $this->CFG['month_chiffre'] = date("m");

		if ($_GET['calyear'] !== '' && $_GET['calyear'] > 1902 && $_GET['calyear'] < 2037)
		    $this->CFG['year'] = intval($_GET['calyear']);
		elseif($_GET['calyear'] == '' && $this->CFG['year'] == 'auto')
			$this->CFG['year'] = date("Y");

        // On détermine le nombre de jour dans le mois (utile pour calculer cases vides à la fin)
        $this->nombre_jour_du_mois = date("t" , mktime(0, 0, 0, intval($this->CFG['month_chiffre']), 1 , intval($this->CFG['year'])));


        // On vérifie si les chiffres donnés sont valides, sachant qu'il y a 12 mois et que le calendrier va de
        // 1902 à 2037
        if ($this->CFG['month_chiffre'] < 0 || $this->CFG['month_chiffre'] > 12 || $this->CFG['year'] < 1902 || $this->CFG['year'] > 2037)
            die('Invalid date');
    }
    // Génération du calendrier
    function generate()
    {
  global $phrases;
/*
$monday = 'ÇËäíä';
$tuesday = 'ËáÇËÇÁ';
$wednesday = 'ÇÑÈÚÇÁ';
$thursday = 'ÎãíÓ';
$friday = 'ÌãÚÉ';
$saturday = 'ÓÈÊ';
$sunday = 'ÇÍÏ';
*/
/*
$monday = 'Mon';
$tuesday = 'Tue';
$wednesday = 'Wed';
$thursday = 'Tue';
$friday = 'Fri';
$saturday = 'Sat';
$sunday = 'Sun';
*/

$monday = 'M';
$tuesday = 'T';
$wednesday = 'W';
$thursday = 'T';
$friday = 'F';
$saturday = 'S';
$sunday = 'S';

$january = $phrases['january'];
$february = $phrases['february'];
$march = $phrases['march'];
$april = $phrases['april'];
$may = $phrases['may'];
$june = $phrases['june'];
$july = $phrases['july'];
$august = $phrases['august'];
$september = $phrases['september'];
$october = $phrases['october'];
$november = $phrases['november'];
$december = $phrases['december'];

		// Traductions
        switch ($this->CFG['month_chiffre']) {
            case "1":
                $month_trans = $january;
                break;
            case "2":
                $month_trans = $february;
                break;
            case "3":
                $month_trans = $march;
                break;
            case "4":
                $month_trans = $april;
                break;
            case "5":
                $month_trans = $may;
                break;
            case "6":
                $month_trans = $june;
                break;
            case "7":
                $month_trans = $july;
                break;
            case "8":
                $month_trans = $august;
                break;
            case "9":
                $month_trans = $september;
                break;
            case "10":
                $month_trans = $october;
                break;
            case "11":
                $month_trans = $november;
                break;
            case "12":
                $month_trans = $december;
                break;
	}

	//Que veut-on : avec ou sans possibilité de changer de mois ? NEW 02/24/'05
	if($this->allow_change == '1')
	{
		//On prépare les liens (on vérifie s'il y a déjà des variables passées par url pour rendre le système adaptable partout)
		//Si rien n'est donné dans la query string, on peut envoyer direct avec un '?'
		if ($_SERVER['QUERY_STRING'] == '')
			$pattern = $_SERVER['PHP_SELF'].'?calmonth=';
    	else {
			//Sinon on compte les éléments de la query string
       		$array = explode ('calmonth=', $_SERVER['QUERY_STRING']);
        	$count = count($array);
				//s'il y a un élément çà veut dire qu'il n'y a pas de présence de notre variable ... donc on il faut un '&'.
        		if ($count == 1) {
            		$pattern = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&calmonth=';
        		}
        		else {
						//Sinon, si la première partie est vide, on peut mettre ?
            			if ($array[0] == '') {
               				 $pattern = $_SERVER['PHP_SELF'].'?calmonth=';
            				}
						//Sinon on fout les éléments de la première partie
            			else {
                		$pattern = $_SERVER['PHP_SELF'].'?'.$array[0].'calmonth=';
            			}
        		}
    		}


//Evaluons la date précédente et suivante : on prend garde aux 2 cas spéciaux : janvier et décembre.
if($this->CFG['month_chiffre'] == '1' || $this->CFG['month_chiffre'] == '01'){
	$prev_mois = '12';
	$prev_an = $this->CFG['year'] - 1;
	$next_mois = $this->CFG['month_chiffre'] + 1;
	$next_an = $this->CFG['year'];}
elseif($this->CFG['month_chiffre'] == '12'){
	$prev_mois = $this->CFG['month_chiffre'] - 1;
	$prev_an = $this->CFG['year'];
	$next_mois = '1';
	$next_an = $this->CFG['year'] + 1;}
else {
	$prev_mois = $this->CFG['month_chiffre'] - 1;
	$prev_an = $this->CFG['year'] ;
	$next_mois = $this->CFG['month_chiffre'] + 1;
	$next_an = $this->CFG['year'] ; }

$url_prev = $pattern.$prev_mois.'&calyear='.$prev_an;
$url_next = $pattern.$next_mois.'&calyear='.$next_an;

//On remplace les '&' par des '&amp;' pour garder une validité XHTML 1.1
$url_prev = str_replace('&','&amp;', $url_prev);
$url_next = str_replace('&','&amp;', $url_next);

//Il y a un risque d'avoir des '&amp;amp;'
$url_prev = str_replace('&amp;amp;','&amp;', $url_prev);
$url_next = str_replace('&amp;amp;','&amp;', $url_next);

        $this->buffer = "<center>
<table id=\"phpalm_calendar\" width=60>
<td colspan=7 align=center> <p class=title>$month_trans  {$this->CFG[year]} </p></td>";

	}
	else
	{
    	//Pas de changement - tout simple.
        $this->buffer = <<<TABLE
<table id="phpalm_calendar">
<caption>$month_trans  {$this->CFG['year']}</caption>\n
TABLE;
}

	   // On vérifie s'il faut un calendrier qui commence par Dimanche ou Lundi et on fait les calculs et initialisations en conséquence
        switch ($this->monday_1st) {
            case "1":
            case "y":
            case "yes": // on veut un calendrier qui commence par Lundi, on va calculer en conséquence le nombre de cases vides + commencer affichage des jours de la semaine
            case "o":
            case "oui":

                $this->jour_1er_du_mois = date("l", mktime (0 , 0 , 0 , $this->CFG['month_chiffre'] , 1 , $this->CFG['year']));
                if ($this->jour_1er_du_mois !== 'Monday') {
                    // Obtention du numéro du jour de la semaine le 1er
                    $this->jour_1er_du_mois_chiffre = date("w", mktime (0 , 0 , 0 , $this->CFG['month_chiffre'] , 1 , $this->CFG['year']));
                    $this->cases_vides_debut = $this->jour_1er_du_mois_chiffre - 1 ;
                    // Comme la vie est mal foutue, et que pour moi, le 1er jour de la semaine c'est Lundi et pas Dimanche ... ben vala quoi ...
                    // => dimanche = 0 , lundi = 1, mardi = 2, mercredi = 3, jeudi = 4, vendredi = 5, samedi = 6 , d'où
                    if ($this->cases_vides_debut == -1)
                        $this->cases_vides_debut = 6;
                } else
                    $this->cases_vides_debut = 0;
                // On commence à générer l'affichage des jours de la semaine.
                $this->buffer .= "

    		<tr>
			<td>$monday</td>
			<td >$tuesday</td>
			<td>$wednesday</td>
			<td >$thursday</td>
			<td >$friday</td>
			<td >$saturday</td>
			<td >$sunday</td>
    		</tr>

";

                break;
            case "0":
            case "n": // on veut un calendrier qui commence par Dimanche ou bien on n'a rien spécifié
            case "no":
            case "non":
            default:
                // On cherche le nombre de cases vides au début
                $this->cases_vides_debut = date("w", mktime (0 , 0 , 0 , $this->CFG['month_chiffre'] , 1 , $this->CFG['year']));
                $this->buffer .= <<<TABLE
    <thead>
    		<tr>
			<td abbr="$sunday"  title="$sunday">{$sunday['0']}</td>
			<td abbr="$monday"  title="$monday">{$monday['0']}</td>
			<td abbr="$tuesday" title="$tuesday">{$tuesday['0']}</td>
			<td abbr="$wednesday"  title="$wednesday">{$wednesday['0']}</td>
			<td abbr="$thursday"  title="$thursday">{$thursday['0']}</td>
			<td abbr="$friday"  title="$friday">{$friday['0']}</th>
			<td abbr="$saturday"  title="$saturday">{$saturday['0']}</td>
    		</tr>
    	</thead>\n
TABLE;
                break;
        } //fin du switch, on passe à nouveau à du général.
        // Une condition pour éviter d'avoir une ligne en moins ou en trop (hauteur dynamique quoi)
        if ($this->cases_vides_debut + $this->nombre_jour_du_mois > 35)
            $this->cases_vides_fin = 42 - ($this->cases_vides_debut + $this->nombre_jour_du_mois);
        else
            $this->cases_vides_fin = 35 - ($this->cases_vides_debut + $this->nombre_jour_du_mois);

        // On passe maintenant à l'affichage des numéros (3 étapes, cases vides débuts, cases pleines, cases vides fin)
        // cases vides début:
        $this->buffer .= <<<TABLE
        <tbody>
        	<tr>
TABLE;

        if ($this->cases_vides_debut !== 0 && $this->cases_vides_debut !== 7)
            $this->buffer .= '<td colspan="' . $this->cases_vides_debut . '">&nbsp;</td>' . "\n";
        // cases pleines:
        for ($i = 1 ; $i <= $this->nombre_jour_du_mois ; $i++) {
            $count = $i + $this->cases_vides_debut;
            // On génère l'url si besoin est, elle sera utilisée en dessous
            if ($this->use_links == '1' && in_array($i , $this->LINKS)) {
                $this->url = str_replace('{D}', $i, $this->url);
                $this->url = str_replace('{Y}', $this->CFG['year'], $this->url);
                $this->url = str_replace('{M}', $this->CFG['month_chiffre'], $this->url);
            }
            // GO
            if ($this->use_links == '1' && ($count == 7 || $count == 14 || $count == 21 || $count == 28 || $count == 35) && (in_array($i , $this->LINKS))) {

             $qrx =db_query("select events_types.color from events_types,events_data where events_data.day='$i' and events_data.year='".$this->CFG['year']."' and events_data.month='".$this->CFG['month_chiffre']."' and events_data.typeid=events_types.id limit 1");
             if(db_num($qrx)){
             	$datax= db_fetch($qrx);

              $this->buffer .= '<td bgcolor='.$datax['color'].' align=center><b><a href="' . $this->url . '">' . $i . '</a></b></td>' . "\n";
              }else{
               $this->buffer .= '<td bgcolor=#FFFFFF align=center><b><a href="' . $this->url . '">' . $i . '</a></b></td>' . "\n";

             	}
                $this->buffer .= '		</tr>' . "\n";
               /* if ($this->nombre_jour_du_mois == 28)
                    $this->buffer .= '		<tr>' . "\n";*/
            } elseif ($count == 7 || $count == 14 || $count == 21 || $count == 28 || $count == 35) {
                $this->buffer .= '			<td align=center>' . $i . '</td>' . "\n";
                $this->buffer .= '		</tr>' . "\n";
                /*if ($this->nombre_jour_du_mois == 28)
                    $this->buffer .= '		<tr>' . "\n";*/
            } elseif ($this->use_links == '1' && in_array($i , $this->LINKS)){

            $qrx =db_query("select events_types.color from events_types,events_data where events_data.day='$i' and events_data.year='".$this->CFG['year']."' and events_data.month='".$this->CFG['month_chiffre']."' and events_data.typeid=events_types.id limit 1");

             if(db_num($qrx)){
             	$datax= db_fetch($qrx);

                $this->buffer .= '<td bgcolor='.$datax['color'].' align=center><b><a href="' . $this->url . '">' . $i . '</a></b></td>' . "\n";
                 }else{
             $this->buffer .= '<td bgcolor=#FFFFFF align=center><b><a href="' . $this->url . '">' . $i . '</a></b></td>' . "\n";

             	}
			}elseif ($count == 8 || $count == 15 || $count == 22 || $count == 29 || $count == 36){
				$this->buffer .= '<tr>' . "\n";
				$this->buffer .= '			<td align=center>' . $i . '</td>' . "\n";}
            else
                $this->buffer .= '			<td align=center>' . $i . '</td>' . "\n";
            $this->url = url; //On réinitialise $this->url pour qu'il parse correctement pour les jours suivants
        }
        // cases vides fin:
        if ($this->cases_vides_fin == 7)
            $this->cases_vides_fin = 0;

        if ($this->cases_vides_fin !== 0)
            $this->buffer .= '<td colspan="' . $this->cases_vides_fin . '">&nbsp;</td>' . "\n";

          $this->buffer .= '</tr></tbody>';

        $this->buffer .= '</table>';


          $this->buffer .="<table width=100%><tr><td colspan=3 align=right><a href=\"$url_prev\">$phrases[events_prev]</a></td>" ;
          $this->buffer .="<td colspan=4 align=left><a href=\"$url_next\">$phrases[events_next]</a></td></tr></table></center>" ;





$qr = db_query("select * from events_types order by id desc");

if(db_num($qr)){
 $this->buffer .= " <br><br><table>" ;

while($data = db_fetch($qr)){
$this->buffer .= "<tr><td width=5 bgcolor='$data[color]'>&nbsp;&nbsp;</td><td>$data[name]</td>";
}

	$this->buffer .= "</table>";
  }

    }
    // Ajouter des liens & gérer le format de l'url
    function links($days, $url)
    {
		$this->use_links = '1';
        $this->LINKS = explode(":", $days);
        $this->url = $url;
        define (url , $url); //On crée une constante qui possède le format de l'url
    }
    // Affiche le calendrier
    function draw()
    {
        echo $this->buffer;
    }
}

?>