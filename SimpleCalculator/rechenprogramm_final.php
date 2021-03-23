<?php
	$ausgabe = "";
	$fehler = "";
	if (isset($_GET['zahl1']))
	{
		if (is_numeric($_GET['zahl1']))
		{
			$zahl1 = $_GET['zahl1'];
		
			if ((isset($_GET['zahl2'])) AND is_numeric($_GET['zahl2']))
			{
				$zahl2 = $_GET['zahl2'];

				if (isset($_GET['rechenoperation']))   //überflüssige Bedingungsabfrage
				{
					$operation = $_GET['rechenoperation'];
					switch($operation){
						case '+':
						$ausgabe = $zahl1 + $zahl2;
						break;
					}
					switch($operation){
						case '-':
						$ausgabe = $zahl1 - $zahl2;
						break;
					}
					switch($operation){
						case '*':
						$ausgabe = $zahl1 * $zahl2;
						break;
					}
					switch($operation){
						case '/':
						if ($zahl2 == 0)
						{
							$ausgabe = "Durch Null darf nicht geteilt werden!";
							break;
						}
						else
						{
							$ausgabe = $zahl1 / $zahl2;
							break;
						}	
					}
					switch($operation){
						case '%':
						$ausgabe = $zahl1 % $zahl2;
						break;
					}
					switch($operation){
						case '**':
						$ausgabe = $zahl1 ** $zahl2;
						break;
					}
				}						
			}
			else
			{
				$fehler = "Bitte geben Sie im 2.Feld eine gültige Zahl ein!";
			}								
		}
		else
		{
			$fehler = "Bitte geben Sie im ersten Feld eine gültige Zahl ein!";			
		}
	}
?>



<!DOCTYPE html>
	<html lang="de">
		<head>
			<meta charset="utf-8">
			<title>Rechenprogramm</title>
			<style>
				*{
					box-sizing: border-box;
				}
				
				.wrapper{
					margin: 0 auto;
					width: 890px;
				}
				
				#rechenblatt
				{
					margin: 200px auto;
				}
			</style>
		</head>
		<body>
			<div class="wrapper">
				<form id="rechenblatt" action="rechenprogramm_final.php" method="get">
					<input type="text" name="zahl1">				
					<select name="rechenoperation">
						<option value="+">Addieren</option>
						<option value="-">Subtrahieren</option>
						<option value="*">Multiplizieren</option>
						<option value="/">Dividieren</option>
						<option value="**">Potenzieren</option>
						<option value="%">Restwertberechnung Modulo</option>
					</select>
					<input type="text" name="zahl2">
					<input type="submit" value="Ausrechnen" name="rechnung">
				</form>
				<?php
					echo "<p>Das Ergebnis der Berechnung beträgt: ".$ausgabe."</p>";
					echo $fehler;
				?>
			</div>
		</body>
	</html>