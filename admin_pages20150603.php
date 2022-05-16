<?php
require_once("../models/config_admin.php");
if (!securePage($_SERVER['PHP_SELF'])){ die();} 
require_once("../models/header.php");
 
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
    <td >Admin Pages</td>
  </tr>
</table> 
 <!--<style>
    
 .scroll_div     { 
                height: 300px;
                overflow-y: auto;
                 
                }
</style>-->
<?php
if ( isset ($_REQUEST['delete']) and ($_REQUEST['delete']== 'delete')) { deletePage($_REQUEST['val']);}
if(!empty($_POST['newpage']))
	 {
		$page = trim($_POST['newpage']);
		$url = trim($_POST['URL']);
		$project_id= $_POST['project_id'];
		if ($_POST['checkbox']==1) $private=  1; else $private=  0;
		if ($_POST['checkbox1']==1) $menupage=  1; else $menupage=  0;
				
		//Validate request
		if (pageNameExists($page)){
			echo "<script>alert('Page Name in Use') </script>";
		}
		elseif (minMaxRange(1, 50, $page)){
			echo "<script>alert(' Name Limited to 50 characters')  </script>";	
		}
		else{
			if (createPage($page,$project_id,$private,$menupage,$url)) {
			echo "<script>alert(' Page Created Successfully ') </script>";
		}
			else 
			{
				echo "<script>alert(' System Fails ,Contact System Admin') </script>";
			}
		}
	}
?>
<script language="javascript" type="text/javascript">
    function showoption() {
        document.adminPage.submit();
    }
    </script>
 
<div id='main'>
<form name='adminPage' method='post'> 

<table>
<tr>
<th>Name</th>
<td><input type='text' name='newpage'  /></td>
<th>URL</th>
<td><input type='text' name='URL'  /></td>
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
            <option value="<?php echo $sql_res["id"]; ?>"
                 <?php if (isset($_REQUEST["project_id"])){ if($sql_res["id"]==$_REQUEST["project_id"]) { echo "Selected"; } }?>>
			<?php echo $sql_res["project"];?></option>
       <?php 
	   } 	
        ?>
          </select>
        </div></td>
<th>Private</th>		
<td><input name="checkbox" type="checkbox" value="1" checked="checked" />		
<th>Menu Page</th>		
<td><input name="checkbox1" type="checkbox" value="1" checked="checked" />	</td>	
<td><input type='submit' name='Submit' value='Submit'  />
</td>
</tr>
</table>

 
<table>
    <tr>
        <th colspan="2"></th>   </tr>
    <tr>
<th>Limit display to Project Pages  </th>
<td> 
        <div align="left">
          <select name="project_id1" id="project_id1" onchange="showoption()" >
            <option value="0">---Select Project---</option>
            <?php
		$sql11  = "SELECT * FROM  uc_projects where is_active = 1 order by  id ";
       $sql_row1 =mysql_query($sql11);
       while($sql_res1=mysql_fetch_array($sql_row1))
       {
       ?>
            <option value="<?php echo $sql_res1["id"]; ?>"
                 <?php if (isset($_REQUEST["project_id1"])) {if($sql_res1["id"]==$_REQUEST["project_id1"]) { echo "Selected"; }} ?>>
			<?php echo $sql_res1["project"];?></option>
       <?php 
	   } 	
        ?>
          </select>
        </div></td></tr>
</table>
</form> 
    <table width="100%">
    <tr>
        <th width="5%">Id</th>
        <th width="15%"> project</th>
        <th width="20%" >Page</th>
        <th width="25%">URL</th>
        <th width="5%">Menu page</th>
        <th width="5%">Access</th> 
        <th width="5%">Update </th>
        <th width="10%">Delete </th></tr> 
    </table>
<?php
if (isset($_REQUEST["project_id1"]) and ($_REQUEST["project_id1"] > 0))
{$dbpages = fetchprojectPages($_REQUEST["project_id1"]);}  
else
{$dbpages = fetchAllPages();} //Retrieve list of pages in pages table
//Display list of pages
    echo "<div class=scroll_div ><table width=100%>";
    foreach ($dbpages as $page){
	echo "
	<tr>
	<td width=5% >
	".$page['id']."
	</td>
	<td width=15%>
	".$page['project'].
	"
	</td>
	<td width=20%>
	<a href ='admin_page.php?id=".$page['id']."'>".$page['page']."</a>
	</td>
         <td width=25%> $page[url] </td>
             
	<td width=5%>";
	if($page['MenuPage'] == 0){
		echo "  ";
	}
	else {
		echo "Yes";	
	}
	echo "</td><td width=5%>";
	//Show public/private setting of page
	if($page['private'] == 0){
		echo "Public";
	}
	else {
		echo "Private";	
	}
	
	echo "
	</td> ";
        echo "
        <td width=5% align=center><a href = 'edit_page.php?val=$page[id]'>  "
                        . "<img src='../style/images/ButtonBarEdit.gif'"
                . " onmouseout=this.src='../style/images/ButtonBarEdit.gif' "
                . "onmouseover=this.src='../style/images/ButtonBarEditOver.gif'>  </a></td>";
	 echo "
        <td  width=10% align=center><a href = 'admin_pages.php?val=".$page['id']."&delete=delete'>  "
                        . "<img src='../style/images/ButtonBarDelete.gif'"
                 . " onmouseout=this.src='../style/images/ButtonBarDelete.gif' "
                 . "onmouseover=this.src='../style/images/ButtonBarDeleteOver.gif'>  </a></td>";
	echo "</tr>";
      
}
echo "  
</table></div>";
?>
</div></div></div>
<div id='bottom'></div>
 
</body>
</html> 
