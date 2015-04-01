<?php
  include("sql.php");
  include('assets/jpgraph/jpgraph.php');
  include('assets/jpgraph/jpgraph_bar.php');

  $result=mysql_query("SELECT count(*) as total from projects where category='Technology'");
  $data=mysql_fetch_assoc($result);
  $tech = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Art'");
  $data=mysql_fetch_assoc($result);
  $art = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Music'");
  $data=mysql_fetch_assoc($result);
  $music = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Photography'");
  $data=mysql_fetch_assoc($result);
  $photo = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Food'");
  $data=mysql_fetch_assoc($result);
  $food = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Film and Video'");
  $data=mysql_fetch_assoc($result);
  $film = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Design'");
  $data=mysql_fetch_assoc($result);
  $design = $data['total'];

  $result=mysql_query("SELECT count(*) as total from projects where category='Games'");
  $data=mysql_fetch_assoc($result);
  $games = $data['total'];


  $array = array($tech, $art, $music, $photo, $food, $film, $design, $games);

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

  $graph->yaxis->SetTitle("Number of Projects", "middle");
  $graph->xaxis->SetTitle("Categories", "middle");
  $days = array('Technology', 'Art', 'Music', 'Photography', 'Food', 'Film and Video','Design', 'Games'); 
  $graph->xaxis->SetTickLabels($days);
  $graph->Stroke();
  ?>