<?php
require_once("../models/config_admin.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");
 
$page_id = $_REQUEST['val'];
$pages = fetchPageDetails($page_id); //Retrieve  page from pages table

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
    <td >Edit Page</td>
  </tr>
</table> 
 <table width="1000" border="0" align="center">
  <tr  >
    <th width="274" align="left"   scope="col">logged on By : <?php 
$aa=$loggedInUser->displayname; echo $aa;?></th>
    <th width="757"   scope="col">&nbsp;</th>
    <th width="112"   scope="col"><p><a href="../account.php"> Home </a></p></th>
  </tr>
</table>
<div id='main'>
<form name='adminPage' method='post'>
<table>
<tr>
<th>Name</th>
<td><input type='text' name='pagename' value ="<?php echo  $pages['page'] ?>" /></td>
</tr>
<tr>
<th>URL</th>
<td><input type='text' name='URL' value ="<?php echo $pages['url'] ?>" /></td>
</tr>
<tr>
<th>Project</th>
<td> 
        <div align="left">
          <select name="project_id" id="project_id" >
            <option value="0">---Select Project---</option>
            <?php
		$sql1  = "SELECT * FROM  uc_projects where is_active = 1 order by  id ";
       $sql_row =mysql_query($sql1);
       while($sql_res=mysql_fetch_array($sql_row))
       {
       ?>
            <option value="<?php echo $sql_res["id"]; ?>" <?php if($sql_res["id"]== $pages['project_id'] ) { echo "Selected"; } ?>>
			<?php echo $sql_res["project"];?></option>
       <?php 
	   } 	
        ?>
          </select>
        </div></td>
</tr>
<tr>
<th>Private</th>		
<td><input name="checkbox" type="checkbox"  value="1" <?php if ( $pages['private']== 1) {echo 'checked="checked"'; }?>/>
</tr>
<tr>
<th>Menu Page</th>		
<td><input name="checkbox1" type="checkbox" value="1" <?php if ( $pages['MenuPage']== 1) {echo 'checked="checked"'; }?> />	
</tr>
<tr>
<th><input type='submit' name='Submit' value='Submit'  />
</th>
</tr>
</table>
</form>

 
<?php

if(!empty($_POST['pagename']))
	 {
		$page = trim($_POST['pagename']);
		$url = trim($_POST['URL']);
		$project_id= $_POST['project_id'];
		if ($_POST['checkbox']==1) $private=  1; else $private=  0;
		if ($_POST['checkbox1']==1) $menupage=  1; else $menupage=  0;
				
		//Validate request

		if (minMaxRange(1, 50, $page)){
			echo "<script>alert(' Name Limited to 50 characters')  </script>";	
		}
		else
                {
                        echo "<script>alert('updating page')</script>";
			if (updatePage($page,$project_id,$private,$menupage,$url,$page_id) ) 
                                
                        {
                           print "<script>";
                           print "self.location='admin_pages.php'";
                           print "</script>";                       
                        }
			else 
			{
                            echo "<script>alert(' System Fails ,Contact System Admin') </script>";
			}
		}
	}
?>
 
</table>
</div>

</div>
</div>
 
<div id='bottom'></div>
</body>
</html>