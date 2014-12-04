<?php 

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
  
?>