<?php
	
	if (isset($_POST['zufall']))
	{
		$zufallszahl = $_POST['zufall'];
		
		if ((($_POST['eingabe']) != null && is_numeric($_POST['eingabe'])))  //isset funktioniert hier nicht. Deshalb habe ich != null als Vergleich verwendet!
		{
			$eingabe = $_POST['eingabe'];
			if ($eingabe < $zufallszahl)
			{
				echo "Die Eingabe war zu klein!";
			}
			else if ($eingabe > $zufallszahl)
			{
				echo "Die Eingabe war zu gross!";
			}
			else
			{
				echo "Gewonnen!";
				$zufallszahl = rand(1,100);
				echo '<form><input type="hidden" name="zufall" value="<?php echo $zufallszahl; ?>"></form>';
			}			
		}
		else
		{
			echo "Bitte mache eine richtige Eingabe!";
		}
		
		
	}
	else
	{
		$zufallszahl = rand(1,100);
		echo '<form><input type="hidden" name="zufall" value="<?php echo $zufallszahl; ?>"></form>';   //Dient dazu, den Wert wieder ins Formular zu übertragen. Sonst würde der Wert vergessen werden. So srpingt der Wert zwischen HTML Teil und PHP Teil hin und her.
	}
?>




<!DOCTYPE html>
	<html lang="de">
		<head>
			<meta charset="utf-8">
			<title>Zahlenratespiel</title>
			<style>
			
			
			</style>
		</head>
		<body>
			<div class="wrapper">
				<form action="zahlenratespiel.php" method = "post">
					<input type="text" name="eingabe"><label for="eingabe">Eingabe</label>
					<input type="hidden" name="zufall" value="<?php echo $zufallszahl; ?>">
					<input type="submit" value="Senden">
				
				</form>			
			</div>
		</body>
	</html>