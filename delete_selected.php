<?php 
echo "sahil";

  $aDoor = $_POST['formDoor'];
  if(empty($aDoor)) 
  {
    echo("You didn't select any buildings.");
  } 
  else
  {
    $N = count($aDoor);
 
    echo("You selected $N door(s): ");
    for($i=0; $i < $N; $i++)
    {
      echo($aDoor[$i] . " ");
    }
  }
/*
  if(empty( $_POST['checkboxvar'])) 
  {
  
    echo("You didn't select any buildings.");
  } 
  else
  {	$chbox = $_POST['checkboxvar'];
    $N = count($chbox); 
    echo("You selected $N door(s): ");
    for($i=0; $i < $N; $i++)
    {
      echo($chbox[$i] . " ");
    }
  }
  */
?>