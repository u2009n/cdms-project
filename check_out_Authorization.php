<?php
ob_start();
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");
include("../models/datepicker.php")
?> 

<div id='wrapper'>
<div id='content'><br>
        <link rel='stylesheet' type='text/css' href='../style/menu.css'>
        <link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
        <script type='text/javascript' src='../style/tablecloth.js'></script>
<table>
    <tr>
    <th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    <tr>
    <td >write down what is this screen</td>
  </tr>
</table> 
 
 
<div id='main'> 
<p>
<?php 
// write your code here 



?>
</p>

</div>

</div>
</div>
<div id='bottom'></div>    
</body>
</html>
<?php 
ob_end_flush();
?> 