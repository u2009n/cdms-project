<?php
ob_start();
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
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
    <td >Add New Position</td>
  </tr>
</table> 
</div>
<div id='main'> 
<script language="javascript" type="text/javascript">

    function showsector(sec_id,ts_id,unit_id)
    {
        document.frmlist.submit();
    }
  </script>
</head>


<table width="100%" border="0">
  <tr >
    <th width="30%" align="left" scope="col">logged on By : <?php $aa=$loggedInUser->displayname; echo $aa; ?> </th>
    <th width="60%"  scope="col">&nbsp;</th>
    <th width="10%" scope="col"><p><a href="planning.php"> Back </a></p></th>
  </tr>
</table>

<?php
date_default_timezone_set('Etc/GMT+3');
$datee=date('Y-m-d');
$stamp = time();
?>
<form id="frmlist" name="frmlist" method="post" action="" enctype="multipart/form-data">
<table width="1028" border="1">
  <tr>
    <th  colspan="2"  bgcolor="#3366CC" scope="col">Duty Station</th>
  </tr>
  <tr>
    <td width="641"    scope="col">
      <table width="641" border="0">
      <tr>
        <th width="169"  scope="col"><span >SECTOR</span></th>
        <td width="456"  scope="col"><label>
            <div align="left">
              <select name="sec_id" id="sec_id" onChange="showsector(this.value);">
                <option value="0">--Select--</option>
                <?php 
                       $sql_sec="select `sec_id`,`sec_name` from `sectors` order by `sec_id`";
                       $sql_sec_row=mysql_query($sql_sec);	   
                        while($sql_sec_result=mysql_fetch_assoc($sql_sec_row))
                        { ?>
                            <option value="<?php echo $sql_sec_result["sec_id"]; ?>" 
				           <?php if(isset($_REQUEST["sec_id"])){if($sql_sec_result["sec_id"]==$_REQUEST["sec_id"]){ echo "Selected"; }} ?> >
					      <?php echo $sql_sec_result["sec_name"];  ?> 
					   </option>
                        <?php  
                        } 
                         ?>
              </select>
            </div>
          </label></td>
      </tr>
      <tr>
        <th  scope="row"><span >DEPARTMENT</span></th>
        <td ><label>
            <div align="left">
              <select name="ts_id" id="ts_id" onChange="showsector(this.value);">
                <option value="0">--Select--</option>
                <?php
                if (isset($_REQUEST['sec_id'])){ 
       $sql="select * from `teamsites` where `teamsites`.`sec_id`='$_REQUEST[sec_id]'";
       $sql_row=mysql_query($sql);
       while($sql_res=mysql_fetch_assoc($sql_row))
       {
		    
		   
       ?>
                <option value="<?php echo $sql_res["ts_id"]; ?>"
                     <?php if(isset($_REQUEST["ts_id"])){if($sql_res["ts_id"]==$_REQUEST["ts_id"]) { echo "Selected"; }} ?>><?php echo $sql_res["ts_name"]; ?></option>
                <?php
       }}
       ?>
              </select>
            </div>
          </label></td>
      </tr>
      <tr>
        <th  scope="row"><span >UNIT</span></th>
        <td ><label>
            <div align="left">
              <select name="unit_id" id="unit_id" onChange="showsector(this.value);">
                <option value="0">--Select--</option>
                <?php
                if (isset( $_REQUEST['sec_id'],$_REQUEST['ts_id']))
                { 
                $sql="select units.* from `units`,teamsites where 
                        units.ts_id = teamsites.ts_id  
                        and teamsites.sec_id = $_REQUEST[sec_id] and 
                        `units`.`ts_id`='$_REQUEST[ts_id]'   ";

                     $sql_row2=mysql_query($sql);

                    while($sql_res2=mysql_fetch_assoc($sql_row2))

                     {
		              ?>
                <option value="<?php echo $sql_res2["unit_id"]; ?>"
                     <?php  if(isset($_REQUEST["unit_id"])){if($sql_res2["unit_id"]==$_REQUEST["unit_id"]) { echo "Selected"; }} ?>><?php echo $sql_res2["unit_name"]; ?></option>
                <?php

                     }}

                    ?>
              </select>
            </div>
          </label></td>
      </tr>
    </table></td>

  </tr>
  <tr>
    <th  colspan="2"  bgcolor="#3366CC" scope="col">Position Details</th>
  </tr>
  <tr>
    <td   colspan="2"  scope="col"><div align="left">
      <table width="1020"   border="0">

          <tr>
            <th width="98"    scope="row">Post ID </th>
            <th width="372" > 
             
			  <?php   
			 
			  if(isset($_REQUEST['unit_id']) and ($_REQUEST['unit_id']!=""))
			  {
			  if(isset($_REQUEST['unit_id']) and ($_REQUEST['unit_id']!="0")) 
			  {
					$sql_max= "select max(post_id) as max_post from positions,units,teamsites,sectors 
								where 
										positions.unit_id = units.unit_id and 
										units.ts_id = teamsites.ts_id and 
										teamsites.sec_id = sectors.sec_id and 
										sectors.sec_id = $_REQUEST[sec_id];";
						
				$sql_query =mysql_query($sql_max);
				$sql_max_val=mysql_fetch_array ($sql_query);	
				$max = 		$sql_max_val['max_post'];
				$post_id = $max+1;	
				echo $post_id;	  
			  }
			  } 
			    
			  ?>
			  
			  
             </th>
            <th class="auto-style1" ><div align="center">Stringth : </div></th>
            <td width="370" ><input name="txtstringth" type="text" id="txtstringth" 
                value="<?php if (isset($_REQUEST['txtstringth'])){echo $_REQUEST['txtstringth'];}?>" size="15" width="50" /></td>
          </tr>
          <tr>
            <th    scope="row">Post Name </th>
            <td  >
					<div align="left">
						<label >
              				<input name="txtpostname" type="text" id="txtpostname" <?php 
			  			    if (isset( $_REQUEST['txtpostname'])) echo "value= \"". trim($_REQUEST['txtpostname']). "\""; ?> size="60" />
            			</label>
					</div>
			</td>
            <th class="auto-style1" ><div align="center">Imm.Supervisor : </div></th>
            <td >
			<select name="lstsuper" id="lstsuper">
             <option value="0">--Select--</option>
              <?php
			if (isset ($_REQUEST['sec_id'],$_REQUEST['ts_id'])){ 

                      $sql1="SELECT post_id ,post_name  from positions
					         where 
							 positions.post_id in 
							 (select post_id from positions,units,teamsites where 
							 positions.unit_id = units.unit_id and 
							 units.ts_id = teamsites.ts_id and 
							 (teamsites.sec_id = $_REQUEST[sec_id] or
							  teamsites.ts_id = $_REQUEST[ts_id] ) and	 keypost != 0  and ops > 0   ) ";
 							 if ( $_REQUEST['sec_id'] == 2 )
							   {
							   	$sql1 = $sql1 . "   union SELECT post_id ,post_name  from positions
					         	where unit_id = 100";
								}


	       $sql_row1=mysql_query($sql1);

       while($sql_res1=mysql_fetch_assoc($sql_row1))
       {
		    
       ?>
              <option value="<?php echo $sql_res1["post_id"]; ?>" 
              <?php if(isset($_REQUEST["lstsuper"])){ if($sql_res1["post_id"]== $_REQUEST["lstsuper"]) { echo "Selected"; }} ?>>
              <?php echo $sql_res1["post_name"]; ?></option>
              <?php
       }
            }
        ?>
            </select>            </td>
          </tr>
          <tr>
            <th    scope="row">Category</th>
            <td ><select name="cat_id" id="cat_id" >
              
            
              <option value="0">--Select--</option>
              <?php
			

        $sql2="select `id`,`Category` from `categories` order by `id`";

       $sql_row12=mysql_query($sql2);

       while($sql_res11=mysql_fetch_assoc($sql_row12))
       {
		    
       ?>
              <option value="<?php echo $sql_res11["id"]; ?>"
                   <?php if(isset($_REQUEST['cat_id'])){ if($sql_res11['id']==$_REQUEST['cat_id']) { echo "Selected"; } }?>>
                   <?php echo $sql_res11["Category"]; ?></option>
              <?php
        }
        ?>
            </select>            </td>
         
           
          </tr>
          <tr>
            <th   colspan="2"  scope="row"><table width="459" border="0" align="left">
              <tr>
                <th width="223"><input name="checkbox" type="checkbox" value="yes" checked="checked" />
                  Operational</th>
               
              </tr>
            </table></th>
            <td colspan="2" ><table width="473" border="0">
              <tr>
                <th width="200"  scope="col"><label>
                  <input name="radiobutton" type="radio" value="P"  />
                  P Position</label></th>
                <th width="200"  scope="col"><label>
                  <input name="radiobutton" type="radio" value="K" />
                  K Position</label></th>
                <th width="200"  scope="col"><label>
                  <input name="radiobutton" type="radio" value="N" checked="checked"/>
                  Non Key Position</label></th>
              </tr>
            </table></td>
          </tr>
          <tr>
            
                        <th  colspan="3"    > <label for="file">
              <div align="left">Filename:
                <input type="file" name="uploadfile"  />
                <!-- <input name="upload" type="submit"  value="upload" /> -->
              </div>
            </label>
              <div align="left"></div></th>
              <td> 
            <table width="200"  >
                <tr>
                  <td><input name="Submit" type="submit" id="Submit" value="Submit" /></td>
                  <td><input name="Reset" type="submit" id="Reset" value="New Insert" /></td>
                </tr>
              </table>
			
              </td>
          </tr>
          </table>
    </div>
  </tr>
</table>

 
       <?php
       if(isset($_FILES["uploadfile"]["name"])) {$filename=$_FILES["uploadfile"]["name"];}
  if(isset($_POST['Submit']))$Submit =($_POST['Submit']);
  if(isset($_POST['ResetSearch']))$resetSearch=($_POST['ResetSearch']);
  if(isset($_REQUEST['sec_id']))$lst_sec_id=($_REQUEST['sec_id']);
  if(isset($_REQUEST["ts_id"]))$lst_ts_id=($_REQUEST["ts_id"]);
  if(isset($_REQUEST['unit_id']))$lst_unit_id=($_REQUEST['unit_id']);
  if(isset($_REQUEST["lstsuper"]))$lst_lstsuper=($_REQUEST["lstsuper"]);
  if(isset($_REQUEST["cat_id"]))$lst_cat_id=($_REQUEST["cat_id"]);
  
   if(isset($_POST['txtpostname']))$txt_post_name=($_POST['txtpostname']);
   if(isset($_POST['txtstringth']))$txt_stringth=($_POST['txtstringth']);
 //  if(isset($_POST['txtstatus']))$txt_status=($_POST['txtstatus']);
 
   if(isset($Submit) and  ($Submit ==="Submit"))
{

	if ($lst_sec_id==0 )
	{
		echo "<script>alert(\"choose the SECTOR.....\");</script>";
	}
    elseif  ($lst_ts_id==0)
    {
            echo "<script>alert(\"choose the Department.....\");</script>";
    }
    elseif ($lst_unit_id==0)
    {
            echo "<script>alert(\"choose the UNIT.....\");</script>";
    }
    elseif ($lst_lstsuper==0)
    {
            echo "<script>alert(\"choose the Imm.Supervisor.....\");</script>";
    }
    elseif ($txt_post_name=="")
    {
            echo "<script>alert(\"write the post name.....\");</script>";
    }
    elseif ($txt_stringth=="")
    {
            echo "<script>alert(\"write the stringth.....\");</script>";
    }
    elseif ($lst_cat_id==0)
    {
            echo "<script>alert(\"choose the categorie.....\");</script>";
    }
    elseif ($filename=="") 
    {
            echo "<script>alert(\"choose job description file to upload.....\");</script>";
    } // end of validations 
    else
    {
        if(isset($_POST['radiobutton'])){ $selected_radiobtn=($_POST['radiobutton']);}
        if ($selected_radiobtn==='P')
            {$keypost=2;}
        elseif ($selected_radiobtn==='K')
             {$keypost=1;}
        else
        {$keypost=0;}	 

        if(isset($_POST['checkbox'])){$selected_checkbox=($_POST['checkbox']);}
        if ($selected_checkbox=='yes')
            {$ops=1;}
        else
                {$ops=0;}

        if(  ($_FILES["uploadfile"]["error"]==0) )
        {      
            //if ($filename !="exsits" )   
               // {
            $filename=$_FILES["uploadfile"]["name"];
            $temp=$_FILES["uploadfile"]["tmp_name"];
            $size=$_FILES["uploadfile"]["size"];
                    $destt=$txt_post_name;
                    $ext=pathinfo($filename,PATHINFO_EXTENSION);
                    $dest="../upload/post_profile/".$post_id .".".$ext;
                    $allowed=array("pdf");
                                                       
                    if ($size>1048576*10) 
                    {
                          echo "<script>alert(\"Size is too big.....\");</script>";
                    }
                    elseif($size==0) 
                    {	
                          echo "<script>alert(\"Size can not be Zero.....\");</script>";
                    } 
                    elseif(!in_array($ext,$allowed)) 
                    {	
                          echo "<script>alert(\"this file type is not allowed.....\");</script>";
                    } 
                    else
                    {
                  
		 $sqlInsert="INSERT INTO positions(post_id,post_name,unit_id,planned,keypost,supervisor,ops,category) VALUES ($post_id,'$txt_post_name',$lst_unit_id,$txt_stringth,$keypost,$lst_lstsuper,$ops,$lst_cat_id)";
											
		
		        $log = new log_proccess;
                $log->Project_name="Planning";
                $log->Function_name="Add New Post";
	            $log->Proccess_info="  post_id : ".$post_id.  "  post_name :  ".$txt_post_name."  unit_id :  ".$lst_unit_id. "  planned : ".$txt_stringth. "  keypost :".$keypost. "  supervisor :".$lst_lstsuper. 
             "ops : ".$ops." category :".$lst_cat_id;
								
	
             try {
                  $res = $mysqli->query($sqlInsert);
               if($res === false) {
                 throw new Exception('Wrong SQL: ' . $sqlInsert  . ' Error: ' . $mysqli->error );
                }
                 $log->Procces_result="Succesfull";
                 $log->complate();     
                  if (move_uploaded_file($temp,$dest)) 
                            {
                               echo "<script>alert('the post Successfuly inserted & file uploaded');</script>";
                            }
                            else
                            {
                            echo "<script>alert('There was an error uploading // the post Successfuly inserted !');</script>";
                            } 
    
                 }
            catch (Exception $e) 
             {
            $log->Procces_result = "Unsuccesful";
           $log->Proccess_error = $e->getMessage();
           $log->complate();
		echo "<script>alert('error while inserting ');</script>";
		die;
                } 

                    }// end of else for file validation 
        }// end of if for file 
    }//end of else for validation 
}// end of submit
   ?>
        </form>

</div>
<div id='bottom'></div>
</div>
</body>
</html>
<?php
ob_end_flush();
?> 
 
