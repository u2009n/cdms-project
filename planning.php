<?php
ob_start();
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");
echo "


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
    <td >Planning</td>
  </tr>
</table>";
echo "
</div>
<div id='main'>"

?>
<p>

<title>Planning </title>

<script language="javascript" type="text/javascript">


 function showselect(sec_id,ts_id,unit_id,  
   post_id,supervisor)
    {
	 document.frmlist.submit();
	}  
  </script>
  
  <script language="javascript" type="text/javascript">


 function frmsearch()
    {
	 document.frmResult.submit();
	}  

function openPopup(winname,url){    
    var popwidth=screen.availWidth-100;
    var popheight=screen.availHeight-100;
    var popleft = Math.round((screen.availWidth - popwidth) / 2);
    var poptop = Math.round((screen.availHeight - popheight) / 2);
	var args = 'toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=no,scrollbars=yes,width='+ popwidth+',height='+ popheight+',left='+ popleft+',top='+ poptop;	
	var nw = window.open(url, winname, args);	
	return nw;
}
</script>

</head>


<table width="1100" border="0">
  <tr >
    <th width="274" align="left" scope="col">logged on By : <?php 
$aa=$loggedInUser->displayname; echo $aa; ?> </th>
    <th width="757" height="10"  scope="col">&nbsp;</th>
    <th width="112" scope="col"><p><a href="../account.php"> Back </a></p></th>
  </tr>
</table>

<p>

  <?php
//include("../config.php");
 $_SESSION['phpfile'] = 'planning';

?>
</p>

	  
        <form id="form2" name="form2" method="post" action="add_new_post.php">
          
          <table width="142" border="1">
            <tr>
              <th width="132"  scope="col" >
                  <input name="Submit" type="submit"  value="ADD NEW POST" />
              </th>
            </tr>
          </table>
        </form>
       
			
		<form id="frmlist" name="frmlist" method="post" action="">	
		<table width="1101" border="1">
          <tr>
            <td width="1091">
			
			<table width="1092" border="1">
                  <tr>
                    <th width="413"   scope="col">SECTOR</th>
                    <td width="112"  scope="col">
                        <label>
						
					    <div align="left">
					      <?php 
						?>					
					      <select name="sec_id" id="sec_id" onChange="showselect(this.value);">			
					        <option value="0">--Select--</option>
					        <?php 
					  
						
                       $sql_sec="select `sec_id`,`sec_name` from `sectors` order by `sec_id`";
                       $sql_sec_row=mysql_query($sql_sec);	   
                        while($sql_sec_result=mysql_fetch_assoc($sql_sec_row))
                        {
							if(isset($_REQUEST["sec_id"])){$SecID=$_REQUEST["sec_id"];} else $SecID=""
							
		             ?>
                <option value="<?php echo $sql_sec_result["sec_id"]; ?>" 
				    <?php if($sql_sec_result["sec_id"]==$SecID)
					{ 
					echo "Selected";
					
					 } 
					 ?> > <?php echo $sql_sec_result["sec_name"];
					
					 ?>		  </option>
					        <?php  
                      } 
                      ?>
				          </select>
				        </div>
                    </label>					</td>
                  
                    <th width="336"   scope="row">DEPARTMENT </th>
                    <td width="202" ><label>
			        <div align="left">
			          <select name="ts_id" id="ts_id" onChange="showselect(this.value);">			
			              <option value="0">--Select--</option>
			            <?php 
                        if(isset($_REQUEST["sec_id"])){
                       $sql="select * from `teamsites` where `teamsites`.`sec_id`='".$_REQUEST['sec_id']."'";
       $sql_row=mysql_query($sql);
       while($sql_res=mysql_fetch_assoc($sql_row))
       {
		   if(isset($_REQUEST["ts_id"])){$TeamID=$_REQUEST["ts_id"];} else $TeamID=""
		   
       ?>
                <option value="<?php echo $sql_res["ts_id"]; ?>" <?php if($sql_res["ts_id"]==$TeamID) { echo "Selected"; } ?>><?php echo $sql_res["ts_name"]; ?>
									  </option>
			            <?php  
                          } }
                      ?>
                      </select>
		            </div>
                    </label></td>
           </tr>
          
		   <tr>
            <th   scope="row" width="413">UNIT</th>
                    <td  width="112"><label>
                    <div align="left">
                      <select name="unit_id" id="unit_id" onChange="showselect(this.value);">			
                          <option value="0">--Select--</option>
                        <?php 
                      // $sql_unit="select * from units where ts_id='$_REQUEST[ts_id]' and units.active=1 ";
                        if(isset($_REQUEST["sec_id"],$_REQUEST['ts_id'])){
                       $sql_unit="select  units.* from `units` ,teamsites where `units`.`ts_id` = ".$_REQUEST['ts_id'] ." and units.active = 1 "
               . " and teamsites.ts_id = units.ts_id and teamsites.sec_id = ".$_REQUEST['sec_id'];
                       $sql_unit_row=mysql_query($sql_unit);	   
                        while($sql_unit_result=mysql_fetch_assoc($sql_unit_row))
                         {
						if(isset($_REQUEST["unit_id"])){$UnitID=$_REQUEST["unit_id"];} else $UnitID=""
		             ?>	
                          <option value="<?php echo $sql_unit_result["unit_id"]; ?>" 
				    <?php if($sql_unit_result["unit_id"]==$UnitID)
					{ 
					echo "Selected"; 
					
					} ?> >
                            <?php echo $sql_unit_result["unit_name"]; 
					
					?>				  </option>
                        <?php  
                          } }
                      ?>
                      </select>
                      </div>
             </label></td>
              
                    <th   scope="row">POSITION</th>
                    <td ><label>
                    <div align="left">
                      <select name="post_id" id="post_id" onChange="showselect(this.value);">			
                          <option value="0">--Select--</option>
                        <?php 
                      // $sql_post="select * from positions where unit_id='$_REQUEST[unit_id]'";
                        if(isset($_REQUEST['unit_id'],$_REQUEST['ts_id'],$_REQUEST['sec_id']))
                        { 
                        $sql_post="select positions.* from `positions`,teamsites,units where "
               . " `positions`.`unit_id`= ".$_REQUEST['unit_id']. " and `keypost`=1"
               . " and teamsites.ts_id = units.ts_id and "
               . " teamsites.sec_id =" .$_REQUEST['sec_id']
               . " and units.ts_id = ".$_REQUEST['ts_id']   
                . " and `units`.`unit_id`= ".$_REQUEST['unit_id']. ";";
                       $sql_post_row=mysql_query($sql_post);	   
                        while($sql_post_result=mysql_fetch_assoc($sql_post_row))
                         { if(isset($_REQUEST['post_id'])){$PostID=$_REQUEST['post_id'];} else $PostID=""
		             ?>	
                          <option value="<?php echo $sql_post_result['post_id']; ?>" 
				    <?php if($sql_post_result['post_id']==$PostID)
					{
					 echo "Selected";
					
				    } ?> >
                            <?php echo $sql_post_result["post_name"];                   
					?>				  </option>
                        <?php  
                          } }
                      ?>
                      </select>
                      </div>
             </label></td>
           </tr>
          
		   <tr>
           <th   scope="row" >SUPERVISOR</th>
                    <td colspan="1" class="R-LA1">
                    <label class="R-LA1">
                   
                     <?php 
					
					
					if(isset($_REQUEST['post_id'],$_REQUEST['sec_id'],$_REQUEST['ts_id']))
					
					 {
					
	                $select="SELECT post_id ,post_name from positions where 
                                        positions.post_id=(select positions.supervisor from positions,units,teamsites,sectors 
                                        where post_id=".$_REQUEST['post_id'] . "  

                                        and positions.unit_id = units.unit_id 
                                        and teamsites.ts_id = units.ts_id
                                        and teamsites.sec_id = sectors.sec_id 
                                        and teamsites.sec_id =".$_REQUEST['sec_id'] ."  
                                        and units.ts_id = " . $_REQUEST['ts_id'] ." 
                                          )   
                                      
                                        and positions.post_id <> 0 ;";
                                            //     echo  $select;
			        $query=mysql_query($select);
	                 while(@$results=mysql_fetch_array($query))
		                   { 
                            echo $results['post_name'];
						   }
                  ;}
				         ?>
                    </label>					
			 </td>
			<th   scope="row" >Categories</th>		
		   <td ><label>
                    <div align="left">
                      <select name="cat_id" id="cat_id" >			
                          <option value="0">--Select--</option>
                        <?php 
                       $sql1="select `id`,`Category` from `categories` order by `id`";

       $sql_row1=mysql_query($sql1);

       while($sql_res1=mysql_fetch_assoc($sql_row1))
       {
		   if(isset($_REQUEST["id"])){$CatID=$_REQUEST["id"];} else $CatID=""
       ?>
              <option value="<?php echo $sql_res1["id"]; ?>" <?php if($sql_res1["id"]==$CatID) { echo "Selected"; } ?>><?php echo $sql_res1["Category"]; ?>  </option>
                        <?php  
                          } 
                      ?>
                      </select>
              </div>
             </label></td>
		   
		   </tr>
		   <tr>
		    <table width="100%" border="1">
               <tr>
                 <th width="9%" ><strong>ALL</strong></th>
                 <td width="14%" ><input name="radiobutton" type="radio" value="ALL" checked="checked"/></td>
                 <th width="12%" ><strong>P Position </strong></th>
                 <td width="13%" ><input name="radiobutton" type="radio" value="2" /></td>
                 <th width="14%" ><strong>K Position </strong></th>
                 <td width="13%" ><input name="radiobutton" type="radio" value="1" /></td>
				 <th width="15%" ><strong>Non Key Position </strong></th>
				 <td width="10%" ><input name="radiobutton" type="radio" value="0" /></td>
				 <td width="10%" class="buttonBlue"> ops <input name="operational" type="checkbox" value=1 checked="checked"/></td>
               </tr>
             </table>
		   </tr>
		   <tr>
		     <th  scope="row" ><input name="btnSearch" type="submit"  onClick="frmsearch" value="Search" /></th>
		     </tr>
             </table>

            </td>
            
          </tr>
        </table>
		</form>
		<p>

 <form id="frmResult" name="frmResult" method="post"    action="">
	

       <table width="1100" border="1">
                <tr>
                  <th width="" align="center" valign="middle"  scope="col"><p >Sector</p></th>
                <th width="" height="15" align="center" valign="middle"  scope="col">Department</th>
              <th width="" height="15" align="center" valign="middle"  scope="col">Unit</th>
                  <th width="" height="15" align="center" valign="middle"  scope="col">P Position</th>
                  <th width="" height="15" align="center" valign="middle"  scope="col">Report To</th>
                  <th width="" height="15" align="center" valign="middle"  scope="col">Type</th>
                  <th width="" height="15" align="center" valign="middle"  scope="col">Planned St</th>
                   <th width="" height="15" align="center" valign="middle"  scope="col">Operational</th>
                   <th width="" height="15" align="center" valign="middle"  scope="col">Status</th>
  				  <th width="" height="15" align="center" valign="middle"  scope="col">Edit</th>
				  <th width="" height="15" align="center" valign="middle"  scope="col">P.Profile</th>
				  <th width="" height="15" align="center" valign="middle"  scope="col">PAs/Del </th>
                </tr>
<?php     
				//Begin of main PHP form Search  			 
if(isset($_POST['btnSearch']))$Submit =($_POST['btnSearch']);
if(isset($Submit) and ($Submit ==="Search"))
{
		   
   if(isset($_POST['sec_id']))$select_sec_id=($_POST['sec_id']);					  
   if(isset($_POST['ts_id']))$select_ts_id=($_POST['ts_id']);
   if(isset($_POST['unit_id']))$select_unit_id=($_POST['unit_id']);
   if(isset($_POST['post_id']))$select_post_id=($_POST['post_id']);
   if(isset($_POST['cat_id']))$select_cat_id=($_POST['cat_id']);
   $query="select sectors.sec_name,units.unit_name,teamsites.ts_name,positions.planned,ops,
				  positions.post_name,positions.post_id,positions.supervisor,positions.status,positions.keypost
		   from   positions,units,teamsites,sectors
		   where  sectors.sec_id=teamsites.sec_id and teamsites.ts_id=units.ts_id
				  and units.unit_id=positions.unit_id   ";
						
	if ($select_sec_id!="0")
	{$query = $query . " and  sectors.sec_id=$select_sec_id";}						
	
	if ($select_ts_id!="0")
	{$query = $query . " and  teamsites.ts_id=$select_ts_id";}
	
	 if ($select_unit_id!="0")
	{$query = $query . " and  units.unit_id=$select_unit_id";}
	
	 if ($select_post_id!="0")
	{$query = $query . " and  positions.post_id=$select_post_id";}
	
	 if ($select_cat_id!="0")
	{$query = $query . " and  positions.category=$select_cat_id";}
						

 	$selected_radiobtn=($_POST['radiobutton']);				      
 	if ($selected_radiobtn==='0')
		{$query = $query . " and  positions.keypost=0";}
 	if ($selected_radiobtn==='1')
		{$query = $query . " and  positions.keypost=1";}
 	if ($selected_radiobtn==='2')
		{$query = $query . " and  positions.keypost=2";}
 	if ($_POST['operational']==='1')
		{$query = $query . " and  positions.ops=1";}
		
   $result=mysql_query($query);
   $number = mysql_num_rows ($result);
   
	if ($number > 0) 
	{
		$total_planned = 0;
		$total_ipos= 0;
	   while ($row=mysql_fetch_array($result))
		{
		   echo "<tr>";
		   echo "<td  align=center>" . $row['sec_name'] . "</td>" ;
		   echo "<td  align=center>" . $row['ts_name'] . "</td>";
		   echo "<td  align=center>" . $row['unit_name'] . "</td>";
		   echo "<td  align=center>" . $row['post_name'] . "</td>";
		   if(isset($row['supervisor']) and ($row['supervisor'] !=0))
		   {
				$select="SELECT post_name  from positions
						where  positions.post_id=$row[supervisor]"; 
			   $query=mysql_query($select);
			   while(@$results=mysql_fetch_array($query))
			   { 
					echo "<td  align=center>" . $results['post_name']. "</td>";
			   }
			}
			else
			{
				echo "<td  align=center>0</td>";
			}
			$type="No Data";
			if($row['keypost']=="0") {$type="No Key Position";}
			if($row['keypost']=="1") {$type="Key Position";}
			if($row['keypost']=="2") {$type="P Position";}
			echo "<td  align=center>" . $type . "</td>";
			echo "<td  align=center>" . $row['planned'] . "</td>";
			$total_planned = $total_planned +  $row['planned'];
			if ($row['ops'] == 1)
			{
			   echo "<td  align=center>  </td>";
			}
			else 
			{
			   echo "<td  align=center> No </td>";
			}
		   
		   if ($row['status'] == 1)
		   {
			   echo "<td  align=center> Adertised</td>";
		   }
		   else 
		   {
			   echo "<td  align=center>  </td>";
		   }
		  
		   $post_id=$row['post_id'];
		   $_SESSION['initial_edit'] = 1;
           
           echo "<td> <a href =\"javascript:void(openPopup('View','../planning/edit_post_cdms.php?post=".$post_id ."')); \"><img   src='../style/images/Edit.gif'> </a> </td>";
           echo "<td> <a href =\"javascript:void(openPopup('View','../planning/position_profile.php?post_id=".$post_id ."')); \"> *** </a> </td>";
           
//		   echo "<td align=center ><a href ='edit_post_cdms.php?post=$post_id'><img 	src='../style/images/Edit.gif'></a></td>";
//		   echo "<td  align=center><a href ='position_profile.php?post_id=$post_id'> *** </td>";
		   
		   $sql_count="SELECT count(*) as total  from ipo
					where  post_id=$post_id and eom >= curdate();";
					
		   $q_count=mysql_query($sql_count);
		   $results=mysql_fetch_array($q_count);
		   if($results['total'] <= 0 ) 
		   {
		   	
		   	echo "<th  align=center><a onclick=\"return confirm('Are you sure you want to delete this position ?')\" href='DeletePostions.php?post_id=$post_id'>
                                          <img   src='../style/images/Delete.png'> </a> </th>";
		   }
		   else
		   {
		   	$total_ipos = $total_ipos + $results['total'];
            echo "<td align=center ><a href =\"javascript:void(openPopup('View','../HumanResources/current_pa_view.php?id= $post_id ')); \">". $results['total']." ipos</a></td>";
//			echo "<td  align=center>" . $results['total'] . " ipos</td>";
		   }
		   echo "</tr>";

		 }
		   echo "<tr>";
		   echo "<th colspan=6  align=right> Total Planned </th>";
		   echo "<td colspan=1  align=center> $total_planned </td>";
		   echo "<th colspan=4  align=right> Total IPOs </th>";
		   echo "<td colspan=1  align=center> $total_ipos </td>";
		   echo "</tr>";
	  		
	
	} 
	else
	{
		echo "<tr>";
		echo "<th colspan=10  align=center> No Data Match </th>";
		echo "</tr>";
	}


}

/**/
?>			
</table>

</form>			
        </p>
 <?php
"</div>
<div id='bottom'></div>
</div>
</body>
</html>";
ob_end_flush();
?>
</body>
</html>

