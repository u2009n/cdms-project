<?php

  $x = array('a', 'b', 'c');
  $y = array();
  
  $y = ${$x};
  
  print_r($y);
?>