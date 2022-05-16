<?php
ob_start();
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");

$permission_sql=get_pagePermission_level($lggedInUser->cpnomber);
/*
if (!empty($permission_level) && $permission_level=='sector'){
    
    $permission_sql=' and sectors.sec_id=';
}elseif (!empty($permission_level) && $permission_level=='teamsite'){
    $permission_sql=' and teamsites.ts_id=';
}elseif (!empty($permission_level) && $permission_level=='unit'){
    $permission_sql=' and units.unit_id=';
}
$permission_sql .= $permission_level_id;
*/
echo "
<div id='wrapper'>
<div id='content'><br>
        <link rel='stylesheet' type='text/css' href='../style/menu.css'>
        <link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
        <script type='text/javascript' src='../style/tablecloth.js'></script>
        <link href='../style/tooltip.css' rel='stylesheet' type='text/css' media='screen' />
       ";
echo "
</div>
<div id='main'>"
?>
<p>
<?php
//include('../config.php');
//session_start();
header('Cache-Control: max-age=900');
?>
<?php
date_default_timezone_set('Etc/GMT+3');
$datee=date('Y-m-d');
include('../models/datepicker.php');
	  	 $avvr=0;
		 $plann=0;
		 $diff=0;
		 $checks=0;

?>
<table>
  <tr>
    <th width="272" align="left"   scope="col"> login by <?php 
$aa=$loggedInUser->displayname; echo $aa;?></th>
    <th width="779"><div align="center"   scope="col"> DEPLOYMENT/DISTRIBUTION MONITORING DASHBOARD </th>
    <th width="113"   scope="col"><a href="javascript:window.close()"> Close </a>--<a href="../account.php"> Back </a></th>
        <?php 
        $job_dsc_url ="/cdms/positions/post_list_files.php?download_file=sysmanual.pdf&loc=Manual";
        echo "<th  align=center>" . "<a href = '". $job_dsc_url . "'>" . "<img src='../style/images/helpl.gif'>" ."</a>" . "</th>";	 
        ?>
  </tr>
</table>			 	

<script>
    function openPopup(winname, url) {
        var popwidth = screen.availWidth - 100;
        var popheight = screen.availHeight - 100;
        var popleft = Math.round((screen.availWidth - popwidth) / 2);
        var poptop = Math.round((screen.availHeight - popheight) / 2);
        var args = 'toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=no,scrollbars=yes,width=' + popwidth + ',height=' + popheight + ',left=' + popleft + ',top=' + poptop;
        var nw = window.open(url, winname, args);
        return nw;
    }
</script>

  <script language="javascript" type="text/javascript">
      function showsector(sec_id, ts_id, unit_id, post_id) {
          document.frm.submit();
      }
    </script>
  </head>
<!--  <script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
  <link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="deployment/library/Styles.css" rel="stylesheet" type="text/css">
<link href="Style/Styles.css" rel="stylesheet" type="text/css">-->

<form action="" method="post" name="frm" id="frm">
<table width="971" height="152" border="0">
    <tr>
<!--      <td width="115" height="148"><p><a href="schedule_interview.php?id=0">Schedule Interview</a></p>
        <p><a href="Interview_Result.php"> Interview Results</a></p>
      <p><a href="Interview_daily_activity.php">Interview On Date </a></p>
      <p><a href="../Contingents.php"></a></p>
      <p><a href="../katum.php"></a></p></td>
        -->
      <td width="846">
	  	<table width="846" height="40" border="0" align="center">
        <tr>
          <th width="230" ><div align="center"  >Choose Sector </div></th>
          <th width="249" ><div align="center"  >Choose Department </div></th>
          <th width="223" ><div align="center" >Choose Unit</div></th>
          <th width="136" ><div align="center" >Choose Date </div></th>
        </tr>
        <tr>
          <td height="24" scope="row"><span id="spryselect1">
            <select name="sec_id" id="sec_id"   onChange="showsector(this.value);"> 
              <option value="0">--Select--</option>
              <?php

              $sql1="select sectors.sec_id, sectors.sec_name from sectors, teamsites,units where  sectors.sec_id=teamsites.sec_id and teamsites.ts_id=units.ts_id group by sectors.sec_id;";

       $sql_row1=mysql_query($sql1);

       while($sql_res1=mysql_fetch_assoc($sql_row1))
       {
       ?>
              <option value="<?php echo $sql_res1["sec_id"]; ?>" <?php if(isset($_REQUEST["sec_id"]) and $sql_res1["sec_id"]==$_REQUEST["sec_id"]) { echo "Selected"; } ?>><?php echo $sql_res1["sec_name"]; ?></option>
              <?php
        }
        ?>
            </select>
          </span></td>
          <td height="24" scope="row"><span id="spryselect2">
            <select name="ts_id" id="ts_id" onChange="showsector(this.value);">
              <option value="0">--Select--</option>
              <?php
              if(isset($_REQUEST['sec_id'])){
                  $sql="select teamsites.ts_id, teamsites.ts_name from sectors, teamsites,units where  sectors.sec_id=teamsites.sec_id and teamsites.ts_id=units.ts_id  and teamsites.sec_id=$_REQUEST[sec_id] group by teamsites.ts_id;";

       $sql_row=mysql_query($sql);

       while($sql_res=mysql_fetch_assoc($sql_row))

       {

       ?>
              <option value="<?php echo $sql_res["ts_id"]; ?>" <?php if($sql_res["ts_id"]==$_REQUEST["ts_id"]) { echo "Selected"; } ?>><?php echo $sql_res["ts_name"]; ?></option>
              <?php
       }
       }

       ?>
            </select>
          </span></div></td>
          <td height="24" scope="row" ><span id="spryselect3">
            <select name="unit_id" id="unit_id" onChange="showsector(this.value);">
              <option value="0">--Select--</option>
              <?php
              if(isset($_REQUEST['ts_id'])){
                  $sql="select units.unit_id, units.unit_name from sectors, teamsites,units where  sectors.sec_id=teamsites.sec_id and teamsites.ts_id=units.ts_id   and units.ts_id=$_REQUEST[ts_id] group by units.unit_id;";

       $sql_row2=mysql_query($sql);

       while($sql_res2=mysql_fetch_assoc($sql_row2))

       {

       ?>
              <option value="<?php echo $sql_res2["unit_id"]; ?>" <?php if($sql_res2["unit_id"]==$_REQUEST["unit_id"]) { echo "Selected"; } ?>><?php echo $sql_res2["unit_name"]; ?></option>
              <?php
       }
       }

       ?>
            </select>
          </span></div></td>
          <th height="24" scope="row"><span id="sprytextfield1">
            <input name="textfield1" type="text" id="datepicker" value = "<?php  if(isset($_POST['textfield1'])){echo $_POST['textfield1'];}?>"/>
          </span></th>
        </tr>
      </table> 
    </tr>
</table>
      
    <form id="form1" name="form1" method="post" action="">
        <table>
            <tr>
            <th>
        <div align="center">
            <input type="submit" name="RadioGroup14" value="Advertise" />
            <input type="submit" name="RadioGroup13" value="non key post" />
            <input type="submit" name="RadioGroup12" value="   key post  " />
            <input  type="submit"name="RadioGroup1" value="ALL"   />
            <input type="submit" name="Submit1" value="Reset Search" />
        </div>
        </th>
      </tr>
      </table>
		
   </form>
    <table width="1024" border="1" align="center" style="font-weight: bold">
    <tr>
        <th width="15" rowspan="2" > SN </th>
        <th width="140" rowspan="2"  colspan="3" ><div align="center">OrgUnit </div></th>
        <th width="140" rowspan="2"  ><div align="center">Positions </div></th>
        <th width="140" colspan="3"  ><div align="center">Strength Status </div></th>
        <th width="140" colspan="5"  ><div align="center">Application Status </div></th>
    </tr>
    <tr>
        <th width="20" rowspan="1"   >Planned </th>
        <th width="20" rowspan="1"   >Current </th>
        <th width="20" rowspan="1"   >check out </th>
        <th width="20" rowspan="1"   >Qualified</th>
        <th width="20" rowspan="1"   >sh.list</th>
        <th width="20" rowspan="1"   >Int.vwd</th>
        <th width="20" rowspan="1"   >unint.vwd</th>
        <th width="20" rowspan="1"   >recom.</th>
      </tr>
      <tr>
<?php	
$RadioGroup1="";$RadioGroup12="";$RadioGroup13="";$RadioGroup14="";$Submit="";$Submit2="";
$select_sec_id="";$select_ts_id="";$select_unit_id="";$dd="";
if(isset($_POST['RadioGroup1'])){ $RadioGroup1 =($_POST['RadioGroup1']);}
if(isset($_POST['RadioGroup12'])){ $RadioGroup12=($_POST['RadioGroup12']);}
if(isset($_POST['RadioGroup13'])){ $RadioGroup13=($_POST['RadioGroup13']);}
 if(isset($_POST['RadioGroup14'])){$RadioGroup14=($_POST['RadioGroup14']);}
 if(isset($_POST['Submit'])){$Submit=($_POST['Submit']);}
 if(isset($_POST['Submit2'])){$Submit2=($_POST['Submit2']);}
 
 if(isset($_POST['sec_id'])){ $select_sec_id=($_POST['sec_id']);}
 if(isset($_POST['ts_id'])){ $select_ts_id=($_POST['ts_id']);}
 if(isset($_POST['unit_id'])){ $select_unit_id=($_POST['unit_id']);}
 if(isset($_POST['textfield1'])){ $dd=($_POST['textfield1']);}
if(isset($_SESSION['phpfile'])){ $_SESSION['phpfile']='stringth';}

if (isset($_POST['RadioGroup1']) or isset($_POST['RadioGroup12']) or isset($_POST['RadioGroup13']) or isset($_POST['RadioGroup14']) )
{
    /*
    $query= "SELECT concat(sectors.sec_name,'   -   ',teamsites.ts_name,'   -   ',units.unit_name) full_unit_name, positions.post_id,
    positions.post_name,positions.planned,positions.unit_id
    from   units,teamsites,sectors,positions
    where  sectors.sec_id=teamsites.sec_id and teamsites.ts_id=units.ts_id
    and units.unit_id=positions.unit_id and positions.ops=1 ";
     */
    $query="SELECT concat(sectors.sec_name,'   -   ',teamsites.ts_name,'   -   ',units.unit_name) full_unit_name,
				pos.post_id,pos.post_name,pos.planned,pos.unit_id,pos.status,pos.dead_line, ifnull(PA.crnt,0) current,ifnull(App.app,0) app,ifnull(intr,0) shortlst, ifnull(viewed,0) interviewed, ifnull(ntviewed,0) notinterviewed, ifnull(recom,0) recom
        from   units,teamsites,sectors,positions pos
		left join (select count(cp_no) crnt, ipo_active.post_id 
					from ipo_active, positions ps 
                    where ipo_active.post_id=ps.post_id group by ipo_active.post_id) as PA on PA.post_id=pos.post_id
		left Join (select count(cand.candidate_id) app,count(intrv.interview_id) intr,sum(intrv.interviewed) viewed,sum(intrv.notinterviewed) ntviewed,sum(intrv.recommended) recom, cand.post_id 
					from post_candidate cand
						left join ( 
                        select interview_schedule.interview_id,interview_schedule.app_id, 
									case when interview_schedule.interview_status='interviewed' then 1 end as interviewed,
                                    case when interview_schedule.interview_status='not interviewed' then 1 end as notinterviewed,
                                    case when interview_schedule.conclusion='recommended' then 1 end as recommended 
                        from interview_schedule) intrv on intrv.app_id=cand.app_id, positions psc
                    where 	cand.post_id=psc.post_id and
                            cand.Conclusion='Qualified' and
                            cand.date_applied >=psc.date_advertised and
                            cand.date_applied <=psc.dead_line and
                            cand.app_status <> 999
                    group by 
                            cand.post_id) as App on App.post_id=pos.post_id
	    where  sectors.sec_id=teamsites.sec_id and teamsites.ts_id=units.ts_id
               and units.unit_id=pos.unit_id and pos.ops=1";

                   if ($select_sec_id!=0)
					{$query = $query . " and  sectors.sec_id=$select_sec_id";}						
					
					if ($select_ts_id!="0")
					{$query = $query . " and  teamsites.ts_id=$select_ts_id";}
					
					 if ($select_unit_id!="0")
					{$query = $query . " and  units.unit_id=$select_unit_id";}
					
					if ($RadioGroup12 ==="   key post  ")
					{$query = $query . " and  pos.keypost=1";}
					
					if ($RadioGroup13 ==="non key post")
					{$query = $query . " and  pos.keypost=0";}
					
					if ($RadioGroup14 ==="Advertise")
					{$query = $query . " and  pos.status=1";}
                    if ($permission_sql !='')
                    {$query .= str_replace('positions.','pos.',$permission_sql);}
					
					
					
//					$query = $query . " order by sectors.sec_id,teamsites.ts_id,units.unit_id,pos.post_id";
										
		   $current_count=0;
		   $planned_count=0;
		   $check_count=0;	
$planned_count="";$current_count="";$checkedout_count="";$checkingout_count=""; $applied_count=0; $shortlst_count=0;
$interviewed_count=0; $notinterviewed_count=0; $recom_count=0;
    
$result = mysql_query($query);
//$number = mysql_num_rows ($result);
$count=0;
while($row = mysql_fetch_array($result))
        {
		   $checkedout = 0;
		   $checkingout = 0;
		   $current= 0 ;
		   
		   
		   
             $post_id=$row['post_id'];
		     echo "<tr>";
			 echo "<th width='3'>". $count +=1 . "</th>";
             echo "<td colspan='3' align='left' >". $row["full_unit_name"]. "</td>";
//			 echo "<td >". $row["ts_name"]. "</td>";
//			 echo "<td >". $row["unit_name"]. "</td>";
			 					
			 $sql="select COUNT(cp_no) AS total 
			            from ipo_active where post_id=$post_id ";
		
			if ($dd!="" and $dd >  $datee )
			{
				$_SESSION['dateend']= $dd;
				$sql_checkedout = $sql . "  and eom >= curdate() and eom < '$dd'";
				$sql_checkingout = $sql . "  and ( eom  > '$dd' )and (`eom` - interval 45 day )<='$dd'";
				$sql_current= $sql . "  and  eom >= curdate() and eom >= '$dd'";
				
			}
			else
			{
				$_SESSION['dateend']= $datee;
				$sql_checkedout = " ";
				$sql_checkingout = $sql . "and ( eom  > curdate() ) and (`eom` - interval 45 day ) <= curdate()";
				$sql_current= $sql . "  and  eom >= curdate() ";
			}


/*
//current stringth.
			$result_current = mysql_query($sql_current);
			$row_current = mysql_fetch_array($result_current);	
			$current = 	$row_current['total'];	
 */ 
//checked out 	
			if ($sql_checkedout != " "  )
			{
				$result_ckeckedout=mysql_query($sql_checkedout);
				$row_ckeckedout=mysql_fetch_array($result_ckeckedout);	
				$checkedout = $row_ckeckedout['total'];
			}
			else
			{
				$checkedout=0;
			}
	// on checkout process 45 days 
			$result_ckeckingout=mysql_query($sql_checkingout);
			$row_ckeckingout=mysql_fetch_array($result_ckeckingout);	
			$checkingout = $row_ckeckingout['total'];


//__________________________________________________________________________
	
//		     echo "<td>" . "<a href = 'post_name.php?id=" . encrypt($row['post_id']) . "'>" . $row['post_name'] . "</a>" . "</td>";
            if(($row['status'] == 1) &&($row['dead_line'] > $datee)){
                echo "<td align=center style='background: yellow' ><a href =\"javascript:void(openPopup('View','../positions/post_name.php?id=". encrypt($row['post_id'])."'));
			\">$row[post_name]</a></td>";
            } elseif(($row['status'] == 1) &&($row['dead_line'] < $datee)){
                echo "<td align=center style='background: lightgray' ><a href =\"javascript:void(openPopup('View','../positions/post_name.php?id=". encrypt($row['post_id'])."'));
			\">$row[post_name]</a></td>";
            }else{
                echo "<td align=center ><a href =\"javascript:void(openPopup('View','../positions/post_name.php?id=". encrypt($row['post_id'])."'));
			\">$row[post_name]</a></td>";
            }
            
            echo "<td align=center >" . $row['planned']. "</td>";	
			 	$planned_count+=$row['planned'];
			if ($row['current']> 0)
			{ 
			
				echo "<td align=center ><a href =\"javascript:void(openPopup('View','../HumanResources/current_pa_view.php?id=".$row['post_id']."'));
			\">$row[current]</a></td>";
			}
			else	 
			{
				echo "<td align=center >" .$row['current']. "</td>";
			}
		     $current_count+=$current;

			
			if ($checkedout > 0 )
			{
				echo "<td align=center ><a href =\"javascript:void(openPopup('View','check_out.php?id=".$row['post_id']."')); \">" 
				.$checkedout . "</a></td>";
				$checkedout_count+=$checkedout;
			}
			else
			{	
				echo "<td align=center >" .$checkedout. "</td>";
				$checkedout_count+=$checkedout;
			}
			if ($row['app'] > 0 )
			{?>
                <td><a href="javascript:void(openPopup('View','schedule_interview.php?id=<?php echo $row['post_id'] ?> &app_st=applied'))" class="tooltip">
                <?php echo $row['app']; ?>
        <span>
            <img class="callout" src="style/images/ButtonBarEditOver.gif" />
            <strong>Applications</strong><br />
            Click Number to scheddule for interview
        </span>
    </a></td>
<?php                      
                $applied_count +=$row['app'];
            } else {
				echo "<td align=center >" .$row['app']. "</td>";
                $applied_count +=$row['app'];
            }
            if($row['shortlst'] > 0) 
            { ?>
                            <td><a href="javascript:void(openPopup('View','schedule_interview.php?id=<?php echo $row['post_id'] ?> &app_st=shortlist'))" class="tooltip">
                <?php echo $row['shortlst']; ?>
        <span>
            <img class="callout" src="style/images/ButtonBarEditOver.gif" />
            <strong>Short Listed</strong><br />
            Click Number to update interview details
        </span>
    </a></td>
<?php      
            $shortlst_count +=$row['shortlst'];

            } else{
				echo "<td align=center >" .$row['shortlst']. "</td>";
                $shortlst_count +=$row['shortlst'];
            }
            if($row['interviewed'] > 0) 
            {?>
                            <td><a href="javascript:void(openPopup('View','schedule_interview.php?id=<?php echo $row['post_id'] ?> &app_st=interviewed'))" class="tooltip">
                <?php echo $row['interviewed']; ?>
        <span>
            <img class="callout" src="style/images/ButtonBarEditOver.gif" />
            <strong>View Interviewed </strong><br />
            Click Number to View interview details
        </span>
    </a></td>
<?php
                
                $interviewed_count +=$row['interviewed'];
              }else {
				echo "<td align=center >" .$row['interviewed']. "</td>";
                $interviewed_count +=$row['interviewed'];
              }
            if($row['notinterviewed'] > 0)
             {?>
               <td><a href="javascript:void(openPopup('View','schedule_interview.php?id=<?php echo $row['post_id'] ?> &app_st=notinterviewed'))" class="tooltip">
                <?php echo $row['notinterviewed']; ?>
        <span>
            <img class="callout" src="style/images/ButtonBarEditOver.gif" />
            <strong>View Uninterviewed Candidates </strong><br />
            Click Number to View interview details
        </span>
    </a></td>
<?php
                $notinterviewed_count +=$row['notinterviewed']; 
			}
			else
			{	
				echo "<td align=center >" .$row['notinterviewed']. "</td>";
                $notinterviewed_count +=$row['notinterviewed'];
			}
			
            if($row['recom'] > 0)
            {?>
             <th><a href="javascript:void(openPopup('View','schedule_interview.php?id=<?php echo $row['post_id'] ?> &app_st=recom'))" class="tooltip">
                <?php echo $row['recom']; ?>
            <span>
            <img class="callout" src="style/images/ButtonBarEditOver.gif" />
            <strong>View Recommended Candidates </strong><br />
            Click Number to View interview details
        </span>
    </a></th>
<?php
/*
echo "<th align=center ><a href =\"javascript:void(openPopup('View','checking_out.php?id=".$row['post_id']."')); \">" 
				.$row['recom'] . "</a></th>";*/
                $recom_count +=$row['recom'];
			}
			else
			{	
				echo "<th align=center >" .$row['recom']. "</th>";
                $recom_count +=$row['recom'];
			}
			
			echo "</tr>";
			
        }
        echo "<tr>";
        echo "<td align=center class=HeadcellReport></td>";
        echo "<td align=center class=HeadcellReport></td>";
        echo "<td align=center class=HeadcellReport></td>";
        echo "<td align=center class=HeadcellReport></td>";
        echo "<td align=center class=HeadcellReport>Total</td>";
        echo "<td align=center class=HeadcellReport>" .$planned_count. "</td>";
        echo "<td align=center class=HeadcellReport>" .$current_count. "</td>";
        echo "<td align=center class=HeadcellReport>" .$checkedout_count. "</td>";
        echo "<td align=center class=HeadcellReport>" .$applied_count. "</td>";
        echo "<td align=center class=HeadcellReport>" .$shortlst_count. "</td>";
        echo "<td align=center class=HeadcellReport>" .$interviewed_count. "</td>";
        echo "<td align=center class=HeadcellReport>" .$notinterviewed_count. "</td>";
        echo "<td align=center class=HeadcellReport>" .$recom_count. "</td>";
        echo "</tr>"; 
}
?>
      </tr>
    </table>
<?php

echo
"</div>
<div id='bottom'></div>
</div>
</body>
</html>";
ob_end_flush();
?>
</pre>