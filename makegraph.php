<?php
  include("sql.php");
  include('assets/jpgraph/jpgraph.php');
  include('assets/jpgraph/jpgraph_bar.php');

  $result=mysql_query("SELECT count(*) as total from projects where category='Technology'");
  $data=mysql_fetch_assoc($result);
  $tech = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Health'");
  $data=mysql_fetch_assoc($result);
  $health = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Education'");
  $data=mysql_fetch_assoc($result);
  $education = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Finance'");
  $data=mysql_fetch_assoc($result);
  $finance = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Travel'");
  $data=mysql_fetch_assoc($result);
  $travel = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Film and Video'");
  $data=mysql_fetch_assoc($result);
  $film = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Design'");
  $data=mysql_fetch_assoc($result);
  $design = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Games'");
  $data=mysql_fetch_assoc($result);
  $games = $data['total'];


  $array = array($tech, $health, $education, $finance, $travel, $film, $design, $games);

  //graph
  $graph = new Graph(600,350);
  $graph->SetScale('textint');
  $graph->SetBackgroundImageMix(70);
  $graph->SetShadow();
  $graph->SetMarginColor("#5599FF");

  $graph->title->Set("Distribution of Projects");
  $graph->subtitle->Set("By Category");

  $plot = new BarPlot($array);
  $plot->SetFillColor(array('#FFFF00', '#FFEE00', '#FFDD00', '#FFCC00', '#FFBB00', '#FFAA00', '#FF9900'));
  $graph->Add($plot);

  $graph->yaxis->SetTitle("Number of Ideas", "middle");
  $graph->xaxis->SetTitle("Categories", "middle");
  $days = array('Technology', 'Health', 'Education', 'Finance', 'Travel', 'Film and Video','Design', 'Games'); 
  $graph->xaxis->SetTickLabels($days);
  $graph->Stroke();
  ?>