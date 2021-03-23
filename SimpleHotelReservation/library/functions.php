<?php
   // Testausgabe einer übergebenen Variablen (vorzugsweise Array)
   function test_var($var)
   {
	   $out  = "<pre>";
	   $out .= print_r($var,true);
	   $out .= "</pre>";
	   return $out;
   }

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_param($String $name, String $method) dient dem Einlesen von Formularwerten
	$name = der Name des Formularelements
	$method = die Übertragungsmethode (get oder post) Optional Standard = get
	Rückgabe = der im Feld übertragende Wert, aus dem Tags und Sonderzeichen
	entfernt bzw. umcodiert wurden. Im Fehlerfall wird ein Leerstring zurückgegeben.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	
function get_param($name,$method = 'get')
   {
	   $out ="";
	   $method = strtolower($method);
	   if($method == "get")
	   {
			$out = $_GET[$name] ?? "";   
	   }
       elseif($method == "post")
	   {
			   $out = $_POST[$name] ?? "";   
	   }
       return htmlspecialchars(strip_tags($out));	   
   }
  
/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Funktion option_num (int $start, int $end, int $input) dient der Erzeugung von Optiontags mit 
	fortlaufendem Wert.
	$start: der Wert des ersten Optiontags;
	$end: 	der Wert des letzten Optionstag;
	$input:	der zuvor versendete Wert dieser Selectbox;
	Die zuvor gesendeten Werte werden beim Selbstaufruf wieder eingesetzt.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */


function option_num($start,$end,$input)
	{
		$out = "";
		for ($i = $start; $i <= $end; $i++)
		{
			$out .= "<option";
			if($i == $input)
			{
				$out .= " selected";
			}
			$out .= ">$i</option>";
		}
		return $out;
	}

 /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Funktion zur Erzeugung von Optionsfelder aus einem zweidimensionalen Array
    $array: das zu verwendende Array;
    $input: der zuvor versendete Wert dieser Selectbox;
	Rückgabe: Die Optionstags mit Value-attribut und Wertanzeige
	Die zuvor gesendeten Werte werden beim Selbstaufruf wieder eingesetzt.
    ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */	
   function option_array($array,$input)
   {
	   $out = "";
	   foreach($array as $satz)
	   {
		   $out .= "<option value='$satz[0]'";
		   if($satz[0] == $input)
		   {
			   $out .= " selected";
		   }
		   $out .= ">$satz[1]</option>\n";
	   }
	   return $out;  
   }
   
 /* Optionsfelder aus übergebenen array erstellen und selektieren des übergebenes Optionwertes 
   indiziertes Array nur Werte werden gelesen*/
	function option_array_value($liste,$input)
	{
		$out ="";
		foreach($liste as $value)
		{
			$out .= "<option";
			if($value == $input)
			{
				$out .= " selected";
			}
			$out .= ">$value</option>\n";
		}
		return $out;
	}

/* Optionsfelder aus übergebenen array erstellen und selektieren des übergebenes Optionwertes 
   indiziertes Array Schlüssel und Werte werden gelesen*/
	function option_array_key_value($liste,$input)
	{
		$out ="";
		foreach($liste as $key => $value)
		{
			$out .= "<option value='$key'";
			if($key == $input)
			{
				$out .= " selected";
			}
			$out .= ">$value</option>\n";
		}
		return $out;
	}	
function liste($array, $listentyp)
{
	$out = "";
	$listentyp = strtolower($listentyp);
	if("ol" == $listentyp || "ul" == $listentyp)
	{
		$out .= "<$listentyp>\n";
		for ($i = 0; $i < count($array); $i++)
		{
			$out .= "<li>$array[$i]</li>\n";
		}
		$out .= "</$listentyp>\n";
	}
	return $out;
}	

/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	Funktion option_liste ( int $start, int $input) dient zur Erzeugung von Optionstag. Zusätzlich soll
	der Value übergeben werden und über Selected wird der Wert festgehalten.
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	
function option_liste($start,$input)
	{
		$out = "";
		
		foreach ($start as $key => $value)
		{
			$out .= "<option  value = '$value' ";
			
			if($value == $input)
			{
				$out .= " selected";
			}
			$out .= ">$key</option>";
		}
		return $out;		
	}

	function option_auto($array_auto,$id,$auswahl_id)
	{
		$out= "";
	
		for($i = 0 ; $i< count($array_auto); $i++){
			
			$out.= "<option";
			$out.= ' value="'.$id[$i].'"';
			 if($auswahl_id == $id[$i])
			 {
				$out .= " selected";
			 }
			
			$out .= ">".$array_auto[$i]."</option>\n";
		}
		return $out;
	}
	
    function sort_autolist($array_auto , $auswahl)
    {
        $out ="";
        
        
        if($auswahl == 0)
        {
            $out .= "<ol>"; 
            foreach($array_auto as $value)
            {
                $out .="<li>$value</li>";
            }
            $out .= "</ol>";               
        }
        
        elseif($auswahl == 1)
        {
             $out .= "<ul>"; 
            foreach($array_auto as $value)
            {
                $out .="<li>$value</li>";
            }
            $out .= "</ul>";
        }
        else{
             $out ="";
        }
        
        return $out;
    }






	
	
/*   Broken function
function option_liststyle ($Liste, $Auswahl)
	{
		$out = "";
		
		foreach ($start as $key => $value)
		{
			
			if ($Auswahl == 'ul')
			{
				$out = "<ul><li>$key</li></ul>";
			}
		
		}
		
		return $out;
	}
	
	*/
