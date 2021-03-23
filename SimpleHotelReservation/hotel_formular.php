<?php
include ("library/functions.php");

//Einleseblock der Variablen-------Als Methode wurde GET gewählt, um nachzuvollziehen, was übergeben wurde----------------------
$anrede 		= get_param("anrede");
$name 			= get_param("name");  											
$vorname 		= get_param("vorname");
$strasse 		= get_param("strasse");
$plz 			= get_param("plz");
$ort 			= get_param("ort");
$email 			= get_param("email");
$telefon 		= get_param("telefon");
$erste_nacht 	= get_param("erste_nacht");
$anzahl_naechte = get_param("anzahl_naechte");
$anzahl_personen= get_param("anzahl_personen");
$zusatzleistung = $_GET['zusatzleistung'] ?? array();	
$verpflegung 	= get_param("verpflegung");
$hotelkategorie = get_param("hotelkategorie");
					
$aktion = get_param("aktion");													// 1. Aufruf "" 2. Aufruf(Folgeaufruf) Wert "Senden";

//Vorinitialisierung-----------------------------------------------------------------------------------------------------------
$out 					= "";													//Ausgabevariable
//Fehlermeldungen für einzelne Positionen
$fehler_anrede 			= "";														
$anredetext				= "";	
$fehler_name 			= "";
$fehler_vorname 		= "";
$fehler_strasse 		= "";
$fehler_plz 			= "";
$fehler_ort 			= "";
$fehler_email 			= "";
$fehler_telefon 		= "";
$fehler_erste_nacht 	= "";
$fehler_anzahl_naechte 	= "";
$fehler_anzahl_personen = "";
$fehler_zusatzleistung 	= "";
$fehler_verpflegung		= "";
$fehler_hotelkategorie	= "";
$fehler 				= 0;													// 0 bedeutet Kein Fehler

//Variablen für das Array $zusatzleistung
$leistung_wlan 		= "";
$leistung_sauna 	= "";
$leistung_fitness 	= "";
													
//Variablen für den Radiobutton, damit die gecheckt bleiben. 
$check_w			= "";														//Frau
$check_m			= "";														//Herr
$check_f			= "";														//Firma
$check_fruehstueck 	= "";														//Frühstück
$check_halbpension	= "";														//Halbpension
$check_vollpension	= "";														//Vollpension

//Variablen für die Checkboxen, damit die gecheckt bleiben.
$check_wlan			= "";
$check_sauna 		= "";
$check_fitness		= "";

//Variablen für die Selectboxen, damit die mit Attribut "selected" versehen werden.
$check_standard 	= "";
$check_comfort		= "";
$check_premium		= "";

//Reguläre Ausdrücke zur Prüfung der Eingaben-------------------------------------------------------------------------------------
$reg_plz = "/^[0-9]{3,5}$/";													//Postleitzahl Beispiel 31535
$reg_email = "/^[^@]{1,}@[^@]{1,}\.[^@]{1,}$/";									//E-Mail Beispiel: kire@gmail.com
$reg_telefon = "/^\+[1-9][0-9]{0,2} [1-9][0-9]{1,3} [1-9][0-9]{2,8}$/";			//Telefon Beispiel +49 171 487987
$reg_erste_nacht = "/^([0-3]{0,1}[0-1]|[0-2]{0,1}[0-9])\.([1]{0,1}[0-2]|[0]{0,1}[1-9])\.20[1-2][0-9]$/"; 	//Anmeldung Beispiel: 12.12.2019

//Timestamps initialisieren-----------------Wichtige Hilfsvariablen, um als Vergleich herzuhalten.
$erste_nacht_unix = strtotime($erste_nacht) + 86399;							//String $erste_nacht wird in Unix timestamp gewandelt, +86399 bedeutet 23 Stunden 59 Minuten 59 Sekunden. Dies ist notwendig, da sonst das heutige Datum nicht als Datum der ersten Übernachtung genommen werden kann!!. Sonst würde 0:00:00 Uhr des jeweiligen Datums genommen werden.
$timestamp_unix = time();														//Aktueller timestamp

//Hilfsvariablen zum Zerlegen des Datum der ersten Übernachtung und zum Speichern des Wahrheitswertes
$explode_erste_nacht 	= "";
$checkdate_bool 		= "";

//Prüfungsblock-------------------------------------------------------------------------------------------------------------------
if($aktion == "Senden")															//Prüfung, ob die Daten abgesendet wurden
{
	if($anrede == "")
	{
		$fehler_anrede = "<span class='fehler'>Bitte Anrede angeben</span>";
		$fehler = 1;															//Fehlervariable = 1 bedeutet Fehler
	}
	if($name == "")
	{
		$fehler_name = "<span class='fehler'>Bitte Nachnamen eingeben</span>";
		$fehler = 1;															//Fehler s.o.
	}
	if($vorname == "")
	{
		$fehler_vorname = "<span class='fehler'>Bitte Vornamen eingeben</span>";
		$fehler = 1;		
	}
	if($strasse == "")
	{
		$fehler_strasse = "<span class='fehler'>Bitte Strasse eingeben</span>";
		$fehler = 1;		
	}
	if($ort == "")
	{
		$fehler_ort = "<span class='fehler'>Bitte Ort eingeben</span>";
		$fehler = 1;		
	}
	if($plz == "")
	{
		$fehler_plz = "<span class='fehler'>Bitte Postleitzahl eingeben</span>";
		$fehler = 1;		
	}
	elseif(!preg_match($reg_plz, $plz))											//Prüfung auf gültige PLZ
	{	
			$fehler_plz = "<span class='fehler'>Ungültige Postleitzahl eingegeben!</span>";
			$fehler = 1;		
	}
	
	if($email == "")
	{
		$fehler_email = "<span class='fehler'>Bitte E-Mail eingeben</span>";
		$fehler = 1;
	}
	else{
														
		if (0 == preg_match($reg_email, $email))								//Prüfung auf gültige E-Mail.
		{
			$fehler_email = "<span class='fehler'>Ungültige E-Mail-Adresse eingegeben!</span>";
			$fehler = 1;
		}
	}
	if($telefon == "")
	{
		$fehler_telefon = "<span class='fehler'>Bitte Telefonnummer angeben</span>";
		$fehler = 1;
	}
	else{ 
		if (0 == preg_match($reg_telefon,$telefon))
		{
			$fehler_telefon = "<span class='fehler'>Ungültige Telefonnummer eingegeben!</span>";
			$fehler = 1;
		}
	}
	if($erste_nacht == "")
	{
		$fehler_erste_nacht = "<span class='fehler'>Bitte Datum angeben</span>";
		$fehler = 1;
	}
	else
	{
		if (0 == preg_match($reg_erste_nacht,$erste_nacht)||$erste_nacht_unix <= $timestamp_unix)		//Vergleich Regulärer Ausdruck oder Timestamps
		{
			$fehler_erste_nacht = "<span class='fehler'>Bitte gültiges Datum nach Format eingeben</span>";
			$fehler = 1;
		}
		
		$explode_erste_nacht = explode('.',$erste_nacht);														//Das Eingangsdatum wird zerlegt und in Array gepackt.
		$checkdate_bool = checkdate($explode_erste_nacht[1],$explode_erste_nacht[0],$explode_erste_nacht[2]);	//Hier wird geprüft, ob es das Datum gibt. (31.02.2020 entspricht False)
		if (FALSE == $checkdate_bool)
		{
			$fehler_erste_nacht = "<span class='fehler'>Kein gültiges Datum. Bitte neu eingeben.</span>";
		}
	}
	if($anzahl_naechte == "" || $anzahl_naechte <= 0)
	{
		$fehler_anzahl_naechte = "<span class='fehler'>Bitte Übernachtungen angeben</span>";
		$fehler = 1;
	}
	if($anzahl_personen == "" || $anzahl_personen <= 0)
	{
		$fehler_anzahl_personen = "<span class='fehler'>Bitte Anzahl der Personen angeben</span>";
		$fehler = 1;
	}
	if($anzahl_personen > 5)													//Hier wird geprüft, ob das Limit der Personen überschritten wurde. 
	{
		$fehler_anzahl_personen = "<span class='fehler'>Bei mehr als 5 Personen bitte mehrfach buchen.</span>";
		$fehler = 1;
	}
	if(TRUE == empty($zusatzleistung))											//prüft, ob das Array leer ist.
	{
		$fehler_zusatzleistung = "<span class='fehler'>Bitte mindestens eine Leistung markieren</span>";
		$fehler = 1;
	}
	if ($verpflegung == "")
	{
		$fehler_verpflegung = "<span class='fehler'>Bitte Verpflegungsart angeben</span>";
		$fehler = 1;
	}
}

//Prüfung, welcher Radiobutton angeklickt wurde. Beim Neuaufruf soll dieser das Attribut "checked" tragen.-----------------------------------------------------
if($anrede == "Frau")
{
	$check_w = "checked";	
}
elseif($anrede == "Herr")
{
	$check_m = "checked";		
} 
elseif($anrede == "Firma")
{
	$check_f = "checked";
}

if($verpflegung == "Frühstück")
{
	$check_fruehstueck = "checked";	
}
elseif($verpflegung == "Halbpension")
{
	$check_halbpension = "checked";		
} 
elseif($verpflegung == "Vollpension")
{
	$check_vollpension = "checked";
}

//Prüfung der Selectbox Werte zum Setzen des Attribut "selected". 
if($hotelkategorie == "Standard")
{
	$check_standard = "selected";	
}
elseif($hotelkategorie == "Comfort")
{
	$check_comfort = "selected";		
} 
elseif($hotelkategorie == "Premium")
{
	$check_premium = "selected";
}

//Prüfung, welche Buttons unter Zusatzleistung markiert wurden. Diese werden mit Attribut "checked" versehen.-----------------------------------------
foreach($zusatzleistung as $leistung)
{
	if("Wlan" == $leistung )					//$leistung ist eine Hilfsvariable
	{
		$check_wlan = "checked";
		$leistung_wlan = "Gebucht";
	}
	else
	{
		$leistung_wlan = "n.g.";
	}
	if("Sauna" == $leistung)
	{
		$check_sauna = "checked";
		$leistung_sauna = "Gebucht";
	}
	else
	{
		$leistung_sauna = "n.g.";
	}
	if("Fitnessraum" == $leistung)
	{
		$check_fitness = "checked";
		$leistung_fitness = "Gebucht";
	}
	else
	{
		$leistung_fitness = "n.g";
	}
}
	

//Hauptprogramm $aktion == "" dann ist dies der erste Aufruf.-----------------------------------------------------------------
if($fehler == 1 || $aktion == "")
{	
//Formular im Heredoc Format
$out .= <<<FORMULAR
			<form action="{$_SERVER['PHP_SELF']}" method="get">
				<fieldset>
				<legend>Adresseingabe</legend>
				<label>Anrede: </label>
				<input type="radio" name="anrede" id="firma" value = "Firma" $check_f>
				<label for = "firma">Firma</label>
				<input type="radio" name="anrede" id="frau" value = "Frau" $check_w>
				<label for = "frau">Frau</label>
				<input type="radio" name="anrede" id="herr" value = "Herr" $check_m>
				<label for = "herr">Mann</label>	$fehler_anrede
				<br>
				<label for = "name">Nachname: </label>
				<input type="text" name="name" id="name" value = "$name"> $fehler_name
				<br>
				<label for = "vorname">Vorname: </label>
				<input type="text" name="vorname" id="vorname" value = "$vorname"> $fehler_vorname
				<br>
				<label for = "strasse">Strasse: </label>
				<input type="text" name="strasse" id="strasse" value = "$strasse"> $fehler_strasse
				<br>
				<label for = "plz">Postleitzahl: </label>
				<input type="text" name="plz" id="plz" value = "$plz"> $fehler_plz
				<br>
				<label for = "ort">Ort: </label>
				<input type="text" name="ort" id="ort" value = "$ort"> $fehler_ort
				<br>
				<label for = "telefon">Telefonnummer: </label>
				<input type="text" name="telefon" id="telefon" placeholder="+49 171 5876987" value = "$telefon"> $fehler_telefon 
				<br>
				<label for = "email">Email: </label>
				<input type="text" name="email" id="email" value = "$email"> $fehler_email
				<br>
				</fieldset>
				<fieldset>
				<legend>Zeitraum und Anzahl der Personen</legend>
				<label for = "erste_nacht">Tag der ersten Übernachtung: </label>
				<input type="text" name="erste_nacht" placeholder="01.01.2020" id="erste_nacht" value = "$erste_nacht"> $fehler_erste_nacht
				<br>
				<label for = "anzahl_naechte">Anzahl der Übernachtungen: </label>
				<input type="text" name="anzahl_naechte" id="anzahl_naechte" value = "$anzahl_naechte"> $fehler_anzahl_naechte
				<br>
				<label for = "anzahl_personen">Anzahl der Personen: </label>
				<input type="text" name="anzahl_personen" id="anzahl_personen" value = "$anzahl_personen"> $fehler_anzahl_personen
				</fieldset>
				<fieldset>
				<legend>Zusatzleistung</legend>
				<ol>
					<li>
						<label>WLAN</label>
						<input type="checkbox" name="zusatzleistung[]" id="wlan" value="Wlan" $check_wlan>
					</li>
					<li>
						<label>Sauna</label>
						<input type="checkbox" name="zusatzleistung[]" id="sauna" value="Sauna" $check_sauna>
					</li>
					<li>
						<label>Fitnessraum</label>
						<input type="checkbox" name="zusatzleistung[]" id="fitnessraum" value="Fitnessraum" $check_fitness>
					</li>
				</ol>
				<p>$fehler_zusatzleistung</p>
				</fieldset>
				<fieldset>
				<legend>Verpflegung</legend>				
				<input type="radio" name="verpflegung" id="fruehstueck" value="Frühstück" $check_fruehstueck>
				<label for = "fruehstueck">Frühstück</label>
				<input type="radio" name="verpflegung" id="halbpension" value="Halbpension" $check_halbpension>
				<label for = "halbpension">Halbpension</label>
				<input type="radio" name="verpflegung" id="vollpension" value="Vollpension" $check_vollpension>
				<label for = "vollpension">Vollpension</label>
				<p>$fehler_verpflegung</p>
				</fieldset>
				<fieldset>
				<legend>Hotelkategorie</legend>
				<select name="hotelkategorie">
					<option value="Standard" $check_standard>Standard</option>
					<option value="Comfort" $check_comfort>Comfort</option>
					<option value="Premium" $check_premium>Premium</option>
				</select>
				</fieldset>
				<input type="submit" id="submit" name="aktion" value="Senden">				
			</form>
FORMULAR;
}
//Ausgabe der Eingaben, wenn alles korrekt eingetragen wurde------------------------------------------------------------------------
elseif($fehler === 0)
{
	$timestamp_eingang = time();
	$eingangsdatum = date("d.m.Y",$timestamp_eingang);
	$out .=<<<AUSGABE
	<h1>Reservierung</h1>
	<p class="text">Vielen Dank für Ihre Angaben.</p>
	<p class="title"><b>Adressangaben:</b></p>
	<p class="text">Anrede:			$anrede</p>
	<p class="text">Nachname:		$name</p>
	<p class="text">Vorname:		$vorname</p>
	<p class="text">Strasse:		$strasse</p>
	<p class="text">Ort:			$ort</p>
	<p class="text">Postleitzahl:	$plz</p>
	<p class="text">Telefon:		$telefon</p>
	<p class="text">E-Mail:			$email</p>
	<p class="title"><b>Zeitraum und Anzahl der Personen</b></p>
	<p class="text">Erste Übernachtung:		$erste_nacht</p>
	<p class="text">Anzahl Übernachtungen: 	$anzahl_naechte</p>
	<p class="text">Anzahl Personen:		$anzahl_personen</p>
	<p class="title"><b>Zusatzleistungen</b></p>
	<p class="text">WLAN:	$leistung_wlan</p>
	<p class="text">Sauna:	$leistung_sauna</p>
	<p class="text">Fitnessraum:	$leistung_fitness</p>
	<p class="title"><b>Verpflegung</b></p>
	<p class="text">Verpflegungsart:		$verpflegung</p>
	<p class="title"><b>Hotelkategorie</b></p>
	<p class="text">Kategorie:				$hotelkategorie</p>
	<p class="title">Eingang der Reservierung : $eingangsdatum </p>
	
	
		
AUSGABE;
	$datei = fopen('hotel_reservierungen.csv','a');			//Datei wird zum Schreiben geöffnet. Die Ressource/Dateizeiger wird an Ende gesetzt.
	$daten = [	$anrede, 									//Array aus den Eingabedaten wird gebildet.
				$vorname, 
				$name, 
				$strasse, 
				$ort, 
				$plz, 
				$telefon, 
				$email, 
				$erste_nacht, 
				$anzahl_naechte, 
				$anzahl_personen,
				$leistung_wlan,
				$leistung_sauna,
				$leistung_fitness,
				$verpflegung,
				$hotelkategorie,
				$eingangsdatum
				];	
	$fputcsv = fputcsv($datei, $daten, ';');				//Die Daten $daten werden im CSV Format in Datei gespeichert. ';' Delimiter. Rückgabewert der Funktion fputcsv wird abgefragt.
	if ($fputcsv == True)
		{
		$out .="<p class='title'><b>Vielen Dank für Ihren Reservierungswunsch</b></p>";
		}
	else
		{
		$out .="<p class='title'><b>Unerwarteter Fehler aufgetreten. Reservierung fehlgeschlagen.</b></p>";
		}
	$out .="<a id='formular' href='{$_SERVER['PHP_SELF']}'>Zurück</a>"; 
	fclose($datei);															
}

// Hier drunter erfolgt die Ausgabe ----------------------------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Formular Hotelreservierung</title>
		<link type="text/css" rel="stylesheet" href="styles/hotel_formular.css">
	</head>
	<body>
		<div class="wrapper">
			<?php
				//Aus aus dem PHP-Block gespeicherter Inhalte in $out.
				echo $out;
			?>
		</div>	
	</body>
</html>