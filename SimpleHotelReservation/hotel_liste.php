<?php
include "library/functions.php";
//Suchfeld einlesen--------------------------------------------------------------------------------
$suchfeld 	= get_param("suchfeld");
$action 	= get_param("submit");

//Vorinitialisierung-----------------------------------------------------------------------------------------------------------------------------
$ausgabe = "";												//Hauptausgabe für die Tabelle
$ausgabe2 = "";												//$ausgabe2 dient dazu, das Suchfeld oben und ausserhalb der Tabelle anzuordnen. 
$ausgabe_fehler ="";
$farbe ="";													//Diese Variable dient zum Einfärben der TD Elemente. Beispiel: style="background-color:red" wird dort hinterlegt.
$schleifenzähler_while = 0;									//Hilfsvariable für die Farbe der TD-Elemente


$reg_mail = "/[@]/";										//Regulärer Ausdruck, um die Email herauszufinden und zu verlinken


//Öffnen der Datei-------------------------------------------------------------------------------------------------------------------------------
$datei = fopen('hotel_reservierungen.csv','r');

while($zeile = fgetcsv($datei,0,';'))						//Der Rückgabewert soll in $zeile stehen / 1 Zeile wird gelesen und in $zeile gespeichert. Danach kommt die nächste Zeile. Delimiter muss als Parameter angegeben werden. Die 0 bedeutet, dass bis zum Zeilenende gelesen wird. Wichtig ist, dass $Zeile ein Array ist und so auch angesprochen werden muss!!
{ 
if(($zeile[2] == $suchfeld && "Senden" == $action)|| ("" == $suchfeld && "" == $action))
{
	{
		$schleifenzähler_while++;								//Der Schleifenzähler dient als Abfragebedingung zum Einfärben der TD-Elemente.
		if (0=="$schleifenzähler_while"%2)						//Bei jeder geraden Zahl werden alle TD-Elemente in der Reihe eingefärbt.
		{
			$farbe = "style='background-color:#F5F5DC'";
		}
		else
		{
			$farbe = "style='background-color:white'";			//Alle ungeraden Zahlen bleiben weiss.
		}
		$ausgabe .= "<tr>\n";
		for ($i=0; $i < count($zeile); $i++)					//Mit dieser Schleifen werden alle TD-Elemente einer Reihe geschrieben. Am Ende eines Durchlaufs wird eine neue Reihe begonnen.
		{
			if (1 == preg_match($reg_mail,$zeile[$i]))			//Über den Regulären Ausdruch wird das @ gesucht. Falls die Funktion Value == 1 zurückgibt, wird das TD Element um den Mail-Link erweitert.
				{
				$ausgabe .= "<td $farbe>"."<a href='mailto:$zeile[$i]'>"."$zeile[$i]</a>"."</td>\n";
				}
			else												//simples TD-Element ohne Link wird erzeugt.
			{
			$ausgabe .= "<td $farbe>"
						. "$zeile[$i]"
						."</td>\n";
			}
		}
		$ausgabe .= "</tr>\n";
		$ausgabe_fehler = "";
	}
}
elseif($zeile[2]!= $suchfeld && 0 == $schleifenzähler_while)		//Wenn die Eingabe im Suchfeld nicht anspricht und der Schleifenzähler nicht hochgezählt hat (Zeichen, dass der vorige If-Block nicht ausgeführt wurde), dann soll die Fehlermeldung ausgegeben werden. Ohne Schleifenzähler-Bedingung würde trotz erfolgreicher Suche die Fehlermeldung ausgegeben werden.
{
	$ausgabe_fehler ="<p id='fehler'>Name nicht gefunden</p>";
}
}
$ausgabe2 =<<<SUCHFORMULAR
<form action="{$_SERVER['PHP_SELF']}" method="get">
	<fieldset>
	<legend>Suchfeld Nachname</legend>
	<input type="text" name="suchfeld" id="suchfeld" value="$suchfeld">
	<input type="submit" name="submit" value="Senden">
	<input type="reset" name="reset">	
	</fieldset>
	</form>
	<a id ="gesamtansicht" href="{$_SERVER['PHP_SELF']}">Zurück zur Gesamtansicht</a>
	$ausgabe_fehler
SUCHFORMULAR;
 
fclose($datei);												//Die Datei wird geschlossen.
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Hotel Reservierungsliste</title>
		<link type="text/css" rel="stylesheet" href="styles/hotel_liste.css">
	</head>
	<body>
		<div class="wrapper">
		<?= $ausgabe2?>
			<table>
				<tr>
					<th>Anrede</th>
					<th>Vorname</th>
					<th>Nachname</th>
					<th>Strasse</th>
					<th>Ort</th>
					<th>Postleitzahl</th>
					<th>Telefon</th>
					<th>E-Mail</th>
					<th>Datum erste Übernachtung</th>
					<th>Anzahl Übernachtungen</th>
					<th>Anzahl Personen</th>
					<th>W-LAN</th>
					<th>Sauna</th>
					<th>Fitnessraum</th>
					<th>Verpflegungsart</th>
					<th>Hotelkategorie</th>
					<th>Eingangsdatum Reservierung</th>
				</tr>
<?= $ausgabe?>
			</table>
		</div>
	</body>
</html>