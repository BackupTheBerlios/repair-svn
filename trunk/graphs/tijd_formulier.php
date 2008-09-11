<?php
	include ("../classes/jpgraph/jpgraph.php");
	include ("../classes/jpgraph/pgraph_line.php");
	require_once '../classes/Config.class.php';
	require_once '../classes/Categorie.class.php';
	require_once '../classes/Herstelformulier.class.php';
	
	$kleuren = array("dodgerblue3", "firebrick3", "gold2", "goldenrod3", "gray4", "green", "hotpink3");
	
	$cats = Categorie::getCategorien();//we halen eerst alle categorieën op
	$data = array();
	$eersteDag = '9999-00-00';
	$laatsteDag = '0000-00-00';
	foreach ($cats as $cat){
		$lijst = Herstelformulier::getAantalFormulieren($cat, 1);
		if(sizeof($lijst)!=0){//categorie enkel gebruiken als er iets in zit
			foreach ($lijst as $dag){
				if($dag[0] < $eersteDag) $eersteDag=$dag[0];
				if($dag[0] > $laatsteDag) $laatsteDag=$dag[0];
				$data[$cat][$dag[0]] = $dag[1];//nu hebben we een lijst met "gaten" in
			}
		}
	}
	
	//lijst van alle dagen maken
	$dagen = array();
	$datum = $eersteDag;
	while($datum!=$laatsteDag){
		$dagen[] = $datum;
		$ts = strtotime($datum);
		$datum = date("Y-m-d", mktime(0,0,0,date("m", $ts), date("d", $ts)+1, date("Y", $ts)));
	}
	$dagen[]=$laatsteDag;
	
	//de gaten opvullen
	$data2 = array();
	foreach ($data as $key=>$categorie){
		foreach ($dagen as $dag){
			$d = $categorie[$dag]==""?0:$categorie[$dag];
			$data2[$key][] = $d;
		}
	}
	
	// Create the graph. These two calls are always required
	$graph = new Graph(500,500,"auto");    
	$graph->SetScale("textlin");
	$graph->SetShadow();
	$graph->img->SetMargin(40,30,20,40);
	
	//lineplots maken
	$dplot=array();
	$legende = array();
	foreach ($data2 as $naam=>$dataset){
		$dplot[] = new LinePLot($dataset);
		$legende[] = $naam;
	}
	//kleuren instellen
	foreach ($dplot as $key=>$value)
		$value->SetFillColor($kleuren[$key]);
	
	// Create the accumulated graph
	$accplot = new AccLinePlot($dplot);
	
	// Add the plot to the graph
	$graph->Add($accplot);
	
	$graph->xaxis->SetTextTickInterval(2);
	$graph->xaxis->title->Set("Datum");
	$graph->yaxis->title->Set("Aantal");
	
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	
	// Display the graph
	$graph->Stroke();
?>