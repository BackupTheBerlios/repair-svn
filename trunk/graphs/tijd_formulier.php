<?php
	include ("../classes/jpgraph/jpgraph.php");
	include ("../classes/jpgraph/jpgraph_line.php");
	require_once '../classes/Config.class.php';
	require_once '../classes/Categorie.class.php';
	require_once '../classes/Herstelformulier.class.php';
	
	$kleuren = array("dodgerblue3", "firebrick3", "gold2", "goldenrod3", "gray4", "hotpink3", "indianred4", "khaki", "lavenderblush", "lemonchiffon");
	
	$cats = Categorie::getCategorien();//we halen eerst alle categorieën op
	$data = array();
	$eersteDag = '9999-00-00';
	$laatsteDag = '0000-00-00';
	foreach ($cats as $cat){
		$lijst = Herstelformulier::getAantalFormulieren($cat, $_GET['homeId']);
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
	$graph = new Graph(600,400,"auto"); 
	$graph->SetScale("textlin");
	$graph->img->SetMargin(50,160,30,60);
	
	// Setup X-scale
	$graph->xaxis->SetTickLabels($dagen);
	$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
	$graph->xaxis->SetLabelAngle(45);

	//lineplots maken
	$dplot=array();
	$legende = array();
	foreach ($data2 as $naam=>$dataset){
		$dplot[] = new LinePLot($dataset);
		$legende[] = $naam;
	}
	//kleuren instellen
	foreach ($dplot as $key=>$value){
		$value->SetFillColor($kleuren[$key%10]);
		$value->SetLegend($legende[$key]);
	}
	
	// Create the accumulated graph
	$accplot = new AccLinePlot($dplot);
	
	// Add the plot to the graph
	$graph->Add($accplot);
	$graph->title->Set ("Aantal defecten per categorie");
	$graph->legend->Pos(0.05,0.2,"right","center");
	
	$graph->xaxis->SetTextTickInterval(2);
	$graph->yaxis->title->Set("Aantal");
	
	$graph->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
	
	// Display the graph
	$graph->Stroke();
?>