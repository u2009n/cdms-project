<?php
ob_start();
require_once("../models/config_admin.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//echo "$_SERVER[PHP_SELF]";
require_once("../models/header.php");
require_once("../models/datepicker.php");
  ?>
 <html>
<head>
<title>UNAMID Police</title>
<!--<link rel="shortcut icon" href="Style/images/unicon.jpg">-->
<meta http-equiv="X-UA-Compatible" content="IE=8"/>
     
    <style type="text/css">
        #datepicker0 {
            width: 128px;
        }
    </style>
     
</head>
<body class="bdy">
<p>
<?php
echo "
<div id='wrapper'>
<div id='content'><br>
        <!--<link rel='stylesheet' type='text/css' href='../style/menu.css'>-->
        <link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
        <script type='text/javascript' src='../style/tablecloth.js'></script>
<table>
    <tr>
    <th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    <tr>
    <td >Auditing Search</td>
  </tr>
</table>

</div>
<div id='main'>";
?>
<p>

<script language="javascript" type="text/javascript">
 function show()
    {
      document.frmAudit.submit();
     }
  
  </script>
<?php
date_default_timezone_set('Etc/GMT+3');
$datee=date('Y-m-d');
$log_dest = get_log_dest();
?>
 
<table>
  <tr>
    <th width="274">logged on By : <?php $aa=$loggedInUser->displayname; echo $aa;?></th>
    <th width="112"> <a href="../account.php"> Back </a></th>
  </tr>
</table>
	
<form id="frmAudit" name="frmAudit" method="post" action="">
   
 
<table width ="100%">
 
<tr>

         <th><div align="center"> Project Name :  </div>
         </th>
         <td> 
           <select name="project_id" id="project_id" onChange="show(this.value);">
             <option value="0">--Select Project Name--</option>
             <?php
             $sql_pro="select  distinct Project_Name from $log_dest.log_table order by Project_Name ";
             $res_pro=mysql_query($sql_pro);
             while($row_pro=mysql_fetch_assoc($res_pro))
                 {
              ?>
            <option value="<?php echo $row_pro["Project_Name"]; ?>" <?php  if(isset($_POST["project_id"]) and $row_pro["Project_Name"]==$_POST["project_id"]) { echo "Selected"; } ?>><?php echo $row_pro["Project_Name"]; ?></option>
            <?php
            }
          ?>
           </select>
         </td>
 
         <th><div align ="center" >  Function Name : </div> 
         </th>
         <td>        
              <label>
           <select name="Function_id" id="Function_id" onChange="show(this.value);">
             <option value="0">--Select Function Name--</option>
             <?php
             if(isset($_REQUEST["project_id"])){
                 $sql_funName="select distinct Function_name  from $log_dest.log_table 
                               where Project_Name='$_REQUEST[project_id]'";
                 $res_FunName=mysql_query($sql_funName);
                 while($row_FunName=mysql_fetch_array($res_FunName))
                 {
              ?>
                   <option value="<?php echo $row_FunName["Function_name"]; ?>" <?php if(isset($_POST['Function_id']) and $row_FunName["Function_name"]==$_POST['Function_id']) { echo "Selected"; } ?>><?php echo $row_FunName["Function_name"]; ?></option>
             <?php
                 }
             }
               ?>
           </select>
           </label>
        </td>
 
</tr>

<tr>
    
  
    
       <th><div align="right">
           <div align="center">Proccess Date :</div>
         </div></th>
       <td>
         <input name="ProccessDate" type="text" id="datepicker" 
         <?php if(isset($_POST['ProccessDate'])){?> value="<?php echo $_POST['ProccessDate'];}?>" />
         </td>
    
    <th><div align ="center" >  User ID : </div> 
         </th>
	<td ><div align="left">
	  <select name="user_id" id="user_id" >
        <option value="0">--Select User--</option>
        <?php 
        $sql_user="select distinct ipo.LastName,ipo.FirstName,log_table.User_cp_number
                  from ipo,$log_dest.log_table
                  where ipo.cp_no=log_table.User_cp_number
                  order by ipo.LastName";
        $res_user=mysql_query($sql_user);	   
        while($row_user=mysql_fetch_assoc($res_user))
                 {
 		             ?>
        <option value="<?php echo $row_user["User_cp_number"]; ?>" 
				    <?php if(isset($_POST['user_id']) and $row_user["User_cp_number"]==$_POST['user_id'])
					{
					 echo "Selected";
					
				    } ?> > 
                    <?php echo $row_user["LastName"]." ". $row_user["FirstName"];                   
					?> </option>
        <?php  
                          } 
                      ?>
      </select>
	</div></td>
    
	</tr>
<tr>
    
  
    
       <th><div align="right">
           <div align="center">Proccess Result :</div>
         </div></th>
       <td colspan="3">
         &nbsp;<select name="Result_id" id="Result_id" onChange="show(this.value);">
        <option value="0">--Select Result--</option>
        <?php 
        $sql_Result="select distinct log_table.Proccess_result
                  from  $log_dest.log_table";
        $res_Result=mysql_query($sql_Result);	   
        while($row_Result=mysql_fetch_assoc($res_Result))
                 {
 		             ?>
        <option value="<?php echo $row_Result["Proccess_result"]; ?>" 
				    <?php if(isset($_POST['Result_id']) and $row_Result["Proccess_result"]==$_POST['Result_id'])
					{
					 echo "Selected";
					
				    } ?> > 
                    <?php echo $row_Result["Proccess_result"];                   
					?> </option>
        <?php  
                          } 
                      ?>
      </select></td>
    
	</tr>
    <tr>
    
  
    
       <th><div align="right">
           <div align="center">Proccess Info :</div>
         </div></th>
       <td colspan="3">
           
	  &nbsp;<textarea name="ProccessInfo" type="text" style="width: 100%"><?php if(isset($_POST['ProccessInfo'])){echo $_POST['ProccessInfo'];}?></textarea> 

        </td>
    
	</tr>
     <tr>
    <td height="36" colspan="4"  >
        <div align="center">
            <br />
            <input name="Submit" type="submit"  value="Search" />
        </div>      
    </td>
  </tr>
    
 
 </table> 



  <?php
  $Submit="";$SQL_SELECT="";$ProccessDate="";$ProjectName="";$functionName="";$User_id="";
  $Result_id="";$ProccessInfo="";
   if(isset($_REQUEST['Submit'])){ $Submit =$_REQUEST['Submit'];}
   
   if(isset($_POST["ProccessDate"])){ $ProccessDate = $_POST["ProccessDate"];}
   
   if(isset($_POST['project_id'])){ $ProjectName = $_POST['project_id'];}
 
   if(isset($_POST["Function_id"])){ $functionName =$_POST["Function_id"];}
 
   if(isset($_POST['user_id'])){ $User_id =$_POST['user_id'];}
   
   if(isset($_POST['Result_id'])){ $Result_id =$_POST['Result_id'];}
   
   if(isset($_POST['ProccessInfo'])){ $ProccessInfo =$_POST['ProccessInfo'];}
   
 
 
 if (isset($_POST['Submit']) and ($Submit ==="Search"))
{
  
    
  
  $SQL_SELECT="SELECT ipo.FirstName,ipo.LastName,
                      log_table.User_cp_number,log_table.Project_name,
                      log_table.Function_name,log_table.Proccess_info,
                      log_table.Proccess_result,log_table.Proccess_time
               From   ipo,$log_dest.log_table
               where  ipo.cp_no=log_table.User_cp_number ";
 
   	 if ($ProjectName!="0")
	    {$SQL_SELECT=$SQL_SELECT." and  log_table.Project_name='$ProjectName'"; }
	 if ($functionName!="0")
	    {$SQL_SELECT=$SQL_SELECT." and  log_table.Function_name='$functionName'"; }
	 if ($ProccessDate!="")
        {$SQL_SELECT=$SQL_SELECT." and  DATE_FORMAT(log_table.Proccess_time,'%Y-%m-%d') ='$ProccessDate'"; }	
	 if ($User_id!="0")
	    {$SQL_SELECT=$SQL_SELECT." and  log_table.User_cp_number='$User_id'"; }	
     if ($Result_id!="0")
        {$SQL_SELECT=$SQL_SELECT." and  log_table.Proccess_result='$Result_id'"; }
     if ($ProccessInfo!="")
        {$SQL_SELECT=$SQL_SELECT." and  LOWER(log_table.Proccess_info) like '%".strtolower($ProccessInfo)."%'"; }
     $SQL_SELECT=$SQL_SELECT." order by ipo.LastName,ipo.FirstName"; 
     try
    {
     $results = mysql_query($SQL_SELECT) or die(mysql_error());  
     $number = mysql_num_rows ($results); 
    }
    catch (Exception $exception)
    {
        echo "<script>alert(\"UnSuccesfull Opration\");</script>";
    }
     
     $ResultCount='0';
     $ResultCount=intval($number);
?>
<table width="100%" border="1" align="center" style="font-weight: bold"> 
<tr>
<th width='80' colspan='12'><?php echo "Total Records Found : " . $ResultCount." Records"; ?></th>
</tr>
<tr >   
<th  scope="col" class="auto-style2">#</th> 
<th  scope="col" class="auto-style1">User Details</th>
<th  scope="col">Project Name</th> 
<th  scope="col" >Function Name</th>
<th  scope="col">Proccess Info</th> 
<th  scope="col">Proccess Result</th>
<th  scope="col">Proccess Time</th> 
  
</tr>

<?php

 $count=0;

if ($number > 0) 
{
  while($row = mysql_fetch_array($results))
  {
  $count+=1;
   echo "<tr>";
   echo "<td width='5px'  align=center>" . $count . "</td>";
   echo "<td  align=center>" . $row['User_cp_number'] ." ".$row['LastName']." ".$row['FirstName']. "</td>";
   echo "<td  align=center>" . $row['Project_name'] . "</td>";
   echo "<td  align=center>" . $row['Function_name'] . "</td>";
   echo "<td  align=center>" . $row['Proccess_info'] . "</td>";	
   $Proccess_result="";
   if(!empty($row['Proccess_result']))
   {$Proccess_result=$row['Proccess_result'];}
   else {$Proccess_result="Result is Empty";}
   echo "<td  align=center>" . $Proccess_result . "</td>";
   echo "<td  align=center>" . $row['Proccess_time'] . "</td>";
    echo "</tr>";
	   }
   echo "</table>"; 
   }
else
{
echo "<tr>";
echo "<td colspan=11  align=center> No Result Match </td>";} 
echo "</tr>";
echo "</table>";    
 }	
	?>
 
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