<?php
ob_start();
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");
require_once('../models/datepicker.php');	
?>
	<!--<meta charset="utf-8">-->
        
        <link rel='stylesheet' type='text/css' href='../style/menu.css'>
        <link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
        <script type='text/javascript' src='../style/tablecloth.js'></script>
<script language="javascript" type="text/javascript">
    $(function() {
        $( "#datepicker" ).datepicker( "option", "maxDate","Today"    );
        $( "#datepicker1" ).datepicker( "option", "maxDate","Today"    );
    });
 </script>
<table width=100%>
    <tr>
    <th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    <tr>
     <td>Personal Data   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="#"> You Have Five(05) Pending Tasks</a></td>
  </tr>
</table> 
 
</div>
<div id='main'> 
 
<?php
//include('../config.php');
if(isset($_GET['id'])){$nopage=$_GET['id'];}
?>

<link rel="stylesheet" href="../style/example.css" TYPE="text/css" MEDIA="screen">
<link rel="stylesheet" href="../style/example-print.css" TYPE="text/css" MEDIA="print">

<script type="text/javascript">

/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */


/*==================================================
  Set the tabber options (must do this before including tabber.js)
  ==================================================*/
var tabberOptions = {

  'cookie':"tabber", /* Name to use for the cookie */

  'onLoad': function(argsObj)
  {
    var t = argsObj.tabber;
    var i;

    /* Optional: Add the id of the tabber to the cookie name to allow
       for multiple tabber interfaces on the site.  If you have
       multiple tabber interfaces (even on different pages) I suggest
       setting a unique id on each one, to avoid having the cookie set
       the wrong tab.
    */
    if (t.id) {
      t.cookie = t.id + t.cookie;
    }

    /* If a cookie was previously set, restore the active tab */
    i = parseInt(getCookie(t.cookie));
    if (isNaN(i)) { return; }
    t.tabShow(i);
   
  },

  'onClick':function(argsObj)
  {
    var c = argsObj.tabber.cookie;
    var i = argsObj.index;
    
    setCookie(c, i);
  }
};

/*==================================================
  Cookie functions
  ==================================================*/
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}
function deleteCookie(name, path, domain) {
    if (getCookie(name)) {
        document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}

</script>

<!-- Include the tabber code -->
<script type="text/javascript" src="../style/tabber.js"></script>
<script language="javascript" type="text/javascript">
    function show(deg_id,field_id,maj_id) {
        document.frm.submit();
		
    }
    </script>
	<script type="text/javascript" language="javascript">
function openPopup(winname,url){    
    var popwidth=screen.availWidth-100;
    var popheight=screen.availHeight-100;
    var popleft = Math.round((screen.availWidth - popwidth) / 2);
    var poptop = Math.round((screen.availHeight - popheight) / 2);
	var args = 'toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=yes,scrollbars=yes,width='+ popwidth+',height='+ popheight+',left='+ popleft+',top='+ poptop;	
	var nw = window.open(url, winname, args);	
	return nw;
}
</script>
<!---->
<link href="../Style/Styles_app.css" rel="stylesheet" type="text/css">

</head>

<table width="100%" border="0">
  <tr >
    <th width="274" align="left" scope="col">logged in as: <?php 
                                                            $aa=$loggedInUser->displayname; echo $aa; ?> </th>
    <th width="757" height="10"  scope="col"></th>
    <th width="112" scope="col"><p><a href="../account.php"> Back </a></p></th>
  </tr>
</table>

<?php

 $cp_no=$loggedInUser->cpnomber;
 $encrypted = $encrypted = encrypt( $cp_no ); 
 /*
 if (isset($_GET['ids'])) {$cp_no1=$_GET['ids'];
  $cp_no2 = str_replace(' ', '+', $cp_no1); 
$cp_no = decrypt( $cp_no2 );
$encrypted = encrypt( $cp_no );
}*/ 
?>
<?php
$sql = "select *\n"
    . " from `ranks`,`units`,`teamsites`,`sectors`,`positions`,`country`,`ipo` where `ipo`.`cp_no`='$cp_no' and `ipo`.`Cntr_id`=`country`.`Cntr_id` and `positions`.`post_id`=`ipo`.`post_id` and `positions`.`unit_id`= `units`.`unit_id`\n"
    . "and `units`.`ts_id`=`teamsites`.`ts_id` and `teamsites`.`sec_id`=`sectors`.`sec_id` and ipo.rank_id=ranks.rank_id  ";
$result1 = mysql_query( $sql);
$number = mysql_num_rows ($result1);
$result=mysql_fetch_array($result1);
?>
<table border="1" bordercolor="black" width="100%">
<tr>
<td width="90%">
<table width = "100%" border="0">
  <tr>
    <th width="98" nowrap   scope="row">Cp No</th>
    <td width="112" nowrap  ><?php echo $cp_no;?></td>
    <th width="89" nowrap   scope="row">Index Number</th>
    <td width="148" nowrap  ><?php echo $result['IndexNo'];?></td>
    <th width="110" nowrap  >Positions</th>
    <td width="254" nowrap ><?php echo $result['post_name'];?></td>
  </tr>
  <tr>
    <th nowrap   scope="row">Last Name</th>
    <td nowrap  ><?php echo $result['LastName'];?> </td>
    <th nowrap  >First Name</th>
    <td nowrap  ><?php echo $result['FirstName'];?></td>
    <th nowrap  >Gender</th>
    <td nowrap ><?php echo $result['Gender'];?></td>
  </tr>
  <tr>
    <th nowrap   scope="row">Country</th>
    <td nowrap  ><?php echo $result['cntr_name'];?></td>
    <th nowrap   scope="row">Cell Number</th>
    <td nowrap  ><?php echo $result['cell_no'];?></td>
    <th nowrap  >Date of Arrival</th>
    <td nowrap ><?php echo $result['doa'];?></td>
  </tr>
  <tr>
    <th nowrap   scope="row">Home Phone</th>
    <td nowrap  ><?php echo $result['home_tel_no'];?></td>
    <th nowrap  >Email Address</th>
    <td nowrap  ><?php echo $result['email_address'];?></td>
    <th nowrap  >Pass issue date</th>
    <td nowrap ><?php echo $result['pass_date_issued'];?></td>
  </tr>
  <tr>
    <th nowrap   scope="row">Rank</th>
    <td nowrap  ><?php echo $result['Abbrivation'];?></td>
    <th nowrap  >DOB</th>
    <td nowrap  ><?php echo $result['dob'];?></td>
    <th nowrap  >E.O.M</th>
    <td nowrap ><?php echo $result['eom'];?></td>
  </tr>
  <tr>
    <th nowrap   scope="row">Date Join police</th>
    <td nowrap  ><?php echo $result['date_joined_police'];?></td>
    <th nowrap  >Sat Status</th>
    <td nowrap  ><?php echo $result['sat_status'];?></td>
    <th nowrap  >Pass expire date </th>
    <td nowrap ><?php echo $result['pass_date_expire'];?></td>
  </tr>
  <tr>
    <th nowrap   scope="row">PassNo</th>
    <td nowrap  ><?php echo $result['PassNo'];?></td>
    <th nowrap  >Sate Date</th>
    <td nowrap  ><?php echo $result['sat_date'];?></td>
    <th nowrap  >  CV</th>
    <td nowrap >
	<?php   $pa_no_enc=encrypt($cp_no);
		     echo " <a href =\"javascript:void(openPopup('View','../mysettings/CV_book.php?val=$pa_no_enc')); \">View CV </a>" ?>
	</td>
  </tr>
</table>

<form  method="post" name="frm" >
<div class="tabber" id="mytabber1">

     <div class="tabbertab">
	  <h2>Qualification</h2>
	  <p>
	  <table width="100%" height="80%" border="1">
  <tr>
    <th width="34%"  scope="col">Degree </th>
    <th width="25%"  scope="col">field </th>
    <th width="24%"  scope="col">Major</th>
  </tr>
  <tr>
      <td><select name="deg_id" id="deg_id"  onChange="show(this.value);">
      <option value="0">-----------Select Degree -----------</option>
      <?php
			$sql12="select * from degrees ORDER BY deg_id ";
		   $sql_row12=mysql_query($sql12);
		   while($sql_res12=mysql_fetch_assoc($sql_row12))
		   {
		   ?>
      <option value="<?php echo $sql_res12["deg_id"]; ?>" <?php if(isset($_REQUEST["deg_id"])){ if($sql_res12["deg_id"]==$_REQUEST["deg_id"]) { echo "Selected"; }} ?>><?php echo $sql_res12["deg_name"]; ?></option>
      <?php
			} 	
			?>
    </select>    </td>
      <td><select name="field_id" id="field_id"  onChange="show(this.value);">
      <option value="0">-----------Select Field-----------</option>
      <?php 
        $sql13="select * from fields ORDER BY field_id ";
       $sql_row13=mysql_query($sql13);
       while($sql_res13=mysql_fetch_assoc($sql_row13))
       {
       ?>
      <option value="<?php echo $sql_res13["field_id"]; ?>" <?php if(isset($_REQUEST["field_id"])) { if($sql_res13["field_id"]==$_REQUEST["field_id"]) { echo "Selected"; }} ?>><?php echo $sql_res13["field_name"]; ?></option>
      <?php
        } 
        ?>
    </select>    </td>
      <td><select name="maj_id" id="maj_id"  onChange="show(this.value);">
      <option value="0">-----------Select Major-----------</option>
      <?php
      if (isset($_REQUEST['field_id'])) { 
        $sql14="select * from majors where majors.field_id ='$_REQUEST[field_id]'";
       $sql_row14=mysql_query($sql14);
       while($sql_res14=mysql_fetch_assoc($sql_row14))
       {
       ?>
      <option value="<?php echo $sql_res14["maj_id"]; ?>" <?php if(isset($_REQUEST["maj_id"])) if($sql_res14["maj_id"]==$_REQUEST["maj_id"]) { echo "Selected"; } ?>><?php echo $sql_res14["maj_name"]; ?></option>
      <?php
        } 	}
        ?>
    </select>    </td>
    <td><input type="submit" name="Subdeg" value="Submit">
        <?php 
			 
	if(isset($_POST['Subdeg'])){$submit2=$_POST['Subdeg'];}
	if(isset($_REQUEST["deg_id"])){$exp4=$_REQUEST["deg_id"];}
	if(isset($_REQUEST["field_id"])){$exp5=$_REQUEST["field_id"];}
	if(isset($_REQUEST["maj_id"])){$exp6=$_REQUEST["maj_id"];}

	if(isset($submit2) and ($submit2=="Submit")){
	if($cp_no=="" || $exp4==0 || $exp5==0 || $exp6==0){
	echo "<script>alert(\"insert value in text box.\");</script>";
	} else {
	$sql = "SELECT * FROM `qualifications` WHERE `cp_no`='$cp_no' and `deg_id`='$exp4' and `field_id`='$exp5' and `maj_id`='$exp6'";
	$result1=mysql_query($sql);
	$number1 = mysql_num_rows ($result1);
	if ($number1>=1){
	echo "<script>alert(\"you are insert this data.\");</script>";}
	 else{ 
	 $qualification_id = get_max('qualifications','qul_id');
	 $qualification_id +=1;
	$sql = "INSERT INTO `qualifications` (`qul_id`,`cp_no`,`deg_id`,`field_id`,`maj_id`) VALUES ($qualification_id ,'$cp_no','$exp4','$exp5','$exp6')";
	
	$log=new log_proccess;

   $log->Project_name="User Profile ";

   $log->Function_name=" Add new Qualification";

   $log->Proccess_info=" qualification Id :$qualification_id  for IPO :$cp_no added with degree:$exp4 , field:$exp5 , Major field : $exp6 " ;
   $user_id =$loggedInUser->user_id;

   try

   {

       $result1=$mysqli->query($sql); 

       if($result1 === false) {

           throw new Exception('Wrong SQL: ' .$mysqli->escape_string($sql). ' Error: ' . $mysqli->error);

       }

       

       $log->Procces_result="Succesfull";

       $log->complate();

       echo "<script>alert(\"Data Inserted Successfully\");</script>";



    }

   catch (Exception $exception)

   {

       $log->Proccess_error = $exception->getMessage();

       $log->Procces_result="UnSuccesfull";

       $log->complate();

       echo "<script>alert(\"Data was not saved\");</script>";

   }

   header("Location:personaldata.php#tabs-1");

							}
	

	}
	}
	
	
        ?>  </td>  </tr>
  <tr>
    <?php
    $sql = "SELECT * FROM `qualifications`,`degrees`,`majors`,`fields` where `qualifications`.`cp_no`='$cp_no' and  `degrees`.`deg_id`=`qualifications`.`deg_id` and `majors`.`maj_id`=`qualifications`.`maj_id` and `fields`.`field_id`=`qualifications`.`field_id` order by `degrees`.`deg_id`";
	$result = mysql_query( $sql);
	if ($result){
while($row = mysql_fetch_array($result))
{  
   echo "<td  align=center >" . $row['deg_name'] . "</td>";
   echo "<td  align=center>" . $row['field_name'] . "</td>";
   echo "<td  align=center>" . $row['maj_name'] . "</td>";
   
   $holder=$row['qul_id'];
   $holder1 = encrypt($holder);
   $tname=encrypt('qualifications');
   $where=encrypt('qualifications.qul_id');
   echo "<td align=center ><a onclick=\"return confirm('Are you sure you want to delete??')\" href='Delete_pd_form.php?T_ID=$holder1&tname=$tname&where=$where#tabs-1'> <img                           																																				src='../style/images/ButtonBarDelete.gif' onmouseout=this.src='../style/images/ButtonBarDelete.gif' onmouseover=this.src='../style/images/ButtonBarDeleteOver.gif'> </a> </td>";	
   echo "<tr>";
}
}
?>
  </tr>
</table>
	  </p>
     </div>

    <div class="tabbertab">
	  <h2>Experience</h2>
	  <p>
	 <table width="100%" border="1">
  <tr>
    <th width="39%"  scope="col">ExperienceName</th>
    <th width="16%"  scope="col">Years </th>
    <th width="27%"  scope="col">Remarks</th>
  </tr>
<tr> 
    <td   scope="col"><select name="ExperienceID" id="ExperienceID" >
      <option value="0">-----------Select Experience-----------</option>
      <?php
        $sql1="select * from experience ORDER BY ExperienceID ";
       $sql_row1=mysql_query($sql1);
       while($sql_res1=mysql_fetch_assoc($sql_row1))
       {
       ?>
      <option value="<?php echo $sql_res1["ExperienceID"]; ?>" <?php if(isset($_REQUEST["ExperienceID"])) {if($sql_res1["ExperienceID"]==$_REQUEST["ExperienceID"]) { echo "Selected"; }} ?>><?php echo $sql_res1["ExperienceName"]; ?></option>
      <?php
        } 	
        ?>
    </select></td> 
    <td   scope="col"><input name="Exp_years3" type="text"   /></td>
    <td   scope="col"><input type="text" name="remarks3" size="50" /></td>
    <td scope="col"><input type="submit" name="SubmitExp" value="submit">
      <?php
      if(isset($_POST['SubmitExp'])){$submit=$_POST['SubmitExp'];} else {$submit = '';}
if(isset($_REQUEST["ExperienceID"])){$exp1=$_REQUEST["ExperienceID"];}
if(isset($_POST['Exp_years3'])){$exp2=$_POST['Exp_years3'];}
if(isset($_POST['remarks3'])){$exp3=$_POST['remarks3'];}
if(isset($submit) and  ($submit=="submit")){
if($cp_no=="" || $exp2=="" || $exp1===0 ){
echo "<script>alert(\"insert value in text box.\");</script>";
} else {
$sql = "SELECT * FROM `po_experience` WHERE `cp_no`='$cp_no' and `experience_id`='$exp1'";
$result1=mysql_query($sql);
$number = mysql_num_rows ($result1);
if ($number>=1){
echo "<script>alert(\"you have exp in this filed.\");</script>";
}
 else{
	 $po_experience_id = get_max('po_experience','po_ex_id');
      $sql = "INSERT INTO `po_experience` (`po_ex_id`,`cp_no`,`experience_id`,`Exp_years`,remarks) VALUES ($po_experience_id,'$cp_no','$exp1','$exp2','$exp3')";
$log=new log_proccess;
                    $log->Project_name="User Profile";
                    $log->Function_name=" Add new  Experience  ";
    
					$log->Proccess_info=" Experience Id :$po_experience_id  for IPO :$cp_no added with Experience :$exp1 , Years:$exp2 " ;
                    try
                    {
                        $result1=$mysqli->query($sql); 
                        if($result1 === false) {
                            throw new Exception('Wrong SQL: ' .$mysqli->escape_string($sql). ' Error: ' . $mysqli->error);
                        }
                        
                        $log->Procces_result="Succesfull";
                        $log->complate();
                        echo "<script>alert(\"Data Inserted Successfully\");</script>";
                        print "<script>";
                        print "self.location='personaldata.php#tabs-2'"; 
                        print "</script>";
                      
                    
                    }
                    catch (Exception $exception)
                    {
                        $log->Proccess_error = $exception->getMessage();
                        $log->Procces_result="UnSuccesfull";
                        $log->complate();
                        echo "<script>alert(\"Data was not saved\");</script>";
                    }
}
}
}

?></td>
</tr>
  <tr>
  <?php
    $sql = "SELECT * FROM `experience`,`po_experience` where `cp_no`='$cp_no' and  `experience`.`ExperienceID`=`po_experience`.`experience_id` order by `experience`.`ExperienceID`";
	$result = mysql_query( $sql);
	if ($result){
while($row = mysql_fetch_array($result))
{
echo "<td  align=center>" . $row['ExperienceName'] . "</td>";
   echo "<td  align=center>" . $row['Exp_years'] . "</td>";
   echo "<td  align=center>" . $row['remarks'] . "</td>";
    
	 $holder=$row['po_ex_id'];
   $holder1 = encrypt($holder);
   $tname=encrypt('po_experience');
   $where=encrypt('po_experience.po_ex_id');
   echo "<td align=center ><a onclick=\"return confirm('Are you sure you want to delete??')\" href='Delete_pd_form.php?T_ID=$holder1&tname=$tname&where=$where#tabs-2'> "
           . "<img	src='../style/images/ButtonBarDelete.gif' onmouseout=this.src='../style/images/ButtonBarDelete.gif' onmouseover=this.src='../style/images/ButtonBarDeleteOver.gif'> </a> </td>";	
	echo "<tr>";
}
}
?>
</tr>
</table> 
	 </p>
     </div>
	 
	 
     <div class="tabbertab">
	  <h2>skills</h2>
	  <p>
	  <table width="100%" border="1">
  <tr>
    <th width="35%" height="29"  scope="col">Skill Type</th>
    <th width="35%" height="29"  scope="col">Skill Name</th>
    <th width="30%"  scope="col">Level </th>
  </tr>
<tr> 
    <td   scope="col">
	<select name="skill_set_id" id="skill_set_id" onChange="show(this.value);">
        <option value="0">-----------Select Skills Type-----------</option>
        <?php
        $sql13="select * from skills_type ORDER BY skill_set_id ";
       $sql_row13=mysql_query($sql13);
       while($sql_res13=mysql_fetch_assoc($sql_row13))
       {
       ?>
        <option value="<?php echo $sql_res13["skill_set_id"]; ?>" <?php if(isset($_REQUEST["skill_set_id"])) { if($sql_res13["skill_set_id"]==$_REQUEST["skill_set_id"]) { echo "Selected";}} ?>><?php echo $sql_res13["skill_set_name"]; ?></option>
        <?php
        } 	
        ?>
      </select></th>
    <td   scope="col"><select name="skill_id" id="skill_id"   >
        <option value="0">-----------Select Skills-----------</option>
        <?php
        if (isset($_REQUEST['skill_set_id'])) { 
        $sql13="select * from skills where skill_set='$_REQUEST[skill_set_id]' ORDER BY skill_id ";
       $sql_row13=mysql_query($sql13);
       while($sql_res13=mysql_fetch_assoc($sql_row13))
       {
       ?>
        <option value="<?php echo $sql_res13["skill_id"]; ?>" <?php if(isset($_REQUEST["skill_id"])) {if($sql_res13["skill_id"]==$_REQUEST["skill_id"]) { echo "Selected"; }} ?>><?php echo $sql_res13["skill_name"]; ?></option>
        <?php
        } 	}
        ?>
      </select></td> 
    <td   scope="col"> <select name="selectlevel">
        <option value="0" selected>-----------Select Level-----------</option>
            <option>perfect</option>
            <option>exelant</option>
            <option>good</option>
      </select></td>
    <td width="22%" scope="col"><input type="submit" name="Submitskil" value="submit">
      <?php
if(isset($_POST['Submitskil'])){$submit22=$_POST['Submitskil'];}
if(isset($_REQUEST["skill_id"])){$skld=$_REQUEST["skill_id"];}
if(isset($_POST['selectlevel'])){$lev=$_POST['selectlevel'];}
if (isset($submit22) and ($submit22=="submit")){
if ($skld==0 ){
echo "<script>alert(\"insert value in skill box.\");</script>";}
elseif ($lev=="" ){
echo "<script>alert(\"insert value in level box.\");</script>";}
 else {
$sql = "SELECT * FROM `po_skills` WHERE `po_id`='$cp_no' and `Skill_id`='$skld'";
$result1=mysql_query($sql);
$number = mysql_num_rows ($result1);
if ($number>=1){
echo "<script>alert(\"you have exp in this filed.\");</script>";}
 else{
	 $po_skills_id = get_max('po_skills','poskill_id');
	 $po_skills_id +=1;
     $sql = "INSERT INTO `po_skills` (`poskill_id`, `po_id`, `Skill_id`, `level`) VALUES ($po_skills_id,'$cp_no','$skld','$lev')";
$log = new log_proccess;
    $log->Project_name="User Profile ";
    $log->Function_name="Add new Skill ";
	$log->Proccess_info=" Skill Id :$po_skills_id  for IPO :$cp_no added with Skill :$skld , Level:$lev " ;
	
	$user_id =$loggedInUser->user_id;
	try {
         
        $res = $mysqli->query($sql);
        if($res === false) {
            throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error);
        }
        
        $log->Proccess_result = "Succesfull";
        $log->complate();
        
    } catch (Exception $e) {
 
        $log->Proccess_result = "Unsuccesful";
        $log->Proccess_error = $e->getMessage();
        $log->complate();
		echo "<script>alert('error while inserting ');</script>";
	 
    }




header("Location:personaldata.php#tabs-3");

}
}
}
?></td>
</tr>
  <tr>
  <?php
   
	$sqlwe="SELECT skills_type.skill_set_name, skills.skill_name, po_skills.level,po_skills.poskill_id
         FROM   skills, skills_type, po_skills
         WHERE  skills_type.skill_set_id = skills.skill_set
         AND    skills.skill_id = po_skills.Skill_id
         AND    po_skills.po_id =  '$cp_no'
        ORDER BY skills.skill_id";
	$resultwe = mysql_query( $sqlwe);
	if ($resultwe){
while($rowwe = mysql_fetch_array($resultwe))
{
echo "<td  align=center>" . $rowwe['skill_set_name'] . "</td>";
echo "<td  align=center>" . $rowwe['skill_name'] . "</td>";
echo "<td  align=center>" . $rowwe['level'] . "</td>";
   $holder=$rowwe['poskill_id'];
   $holder1 = encrypt($holder);
   $tname=encrypt('po_skills');
   $where=encrypt('po_skills.poskill_id');
   echo "<td align=center ><a onclick=\"return confirm('Are you sure you want to delete??')\" href='Delete_pd_form.php?T_ID=$holder1&tname=$tname&where=$where&id=&ids=#tabs-3'> <img                           																																				src='../style/images/ButtonBarDelete.gif' onmouseout=this.src='../style/images/ButtonBarDelete.gif' onmouseover=this.src='../style/images/ButtonBarDeleteOver.gif'> </a> </td>";	
	echo "</td><tr>";
}
}
?>
  </tr>
</table>
	  </p>
     </div>


     <div class="tabbertab">
	  <h2>Mission Experience</h2>
	  <p>
	  <table width="100%" border="1">
  <tr>
    <th width="12%" height="29"  scope="col">Mission Name</th>
    <th width="16%"  scope="col">Start date</th>
    <th width="18%"  scope="col">End date</th>
    <th width="21%"  scope="col">Posts</th>
    <th width="27%"  scope="col">Duties performed</th>
  </tr>
  <tr>
    <td height="28"  ><select name="mission_id" id="mission_id" >
        <option value="0" selected>-----------Select Level-----------</option>
		    <?php
        $sql1="select * from un_missions  order by mission_id ";
       $sql_row1=mysql_query($sql1);
       while($sql_res1=mysql_fetch_assoc($sql_row1))
       {
       ?>
           <option value="<?php echo $sql_res1["mission_id"]; ?>" <?php if(isset($_REQUEST["mission_id"])) {if($sql_res1["mission_id"]==$_REQUEST["mission_id"]) { echo "Selected"; }} ?>><?php echo $sql_res1["mission_short"]; ?></option>
           <?php
        }
        ?>
      </select> </td>
        <td><input name="textfield1" type="text" id="datepicker" /></td>
        <td><input name="textfield2" type="text" id="datepicker1" /></td>
        <td><input type="text"  name="posts" value=""  /></td>
        <td><input type="text"  name="duties" value=""  /></td>
      <td width="6%" scope="col"><input type="submit" name="Submitunmiss" value="submit"> </td> 
  </tr>
  <tr>
  <?php
  if(isset($_POST['Submitunmiss'])){$submit23=$_POST['Submitunmiss'];} else {$submit23='';}
if(isset($_REQUEST["mission_id"])){$mssion_id=$_REQUEST["mission_id"];}
if(isset($_POST['textfield1'])){$strdate=$_POST['textfield1'];}
if(isset($_POST['textfield2'])){$enddate=$_POST['textfield2'];}
if(isset($_POST['posts'])){$post=$_POST['posts'];}
if(isset($_POST['duties'])){$duts=$_POST['duties'];}

if(isset($submit23) and ($submit23=="submit")){
if($cp_no=="" || $mssion_id==0 || $strdate=="" || $enddate==""|| $post==""|| $duts==""){
echo "<script>alert(\"insert value in text box.\");</script>";
} else {
$sql21 = "SELECT * FROM `mission_exp` WHERE `cp_no`='$cp_no' and `mission_id`='$mssion_id' and `start_date`='$strdate' ";
$result21=mysql_query($sql21);
$number21 = mysql_num_rows ($result21);
if ($number21>=1){
echo "<script>alert(\"you have exp un mission in this mission and same date.\");</script>";}
 else{
	 $mission_exp_id = get_max('mission_exp','mission_experience_id');
	 $mission_exp_id +=1;
$sql = "INSERT INTO `mission_exp` (`mission_experience_id`, `cp_no`, `mission_id`, `start_date`, `end_date`, `posts`, `duties`) 
VALUES ($mission_exp_id, '$cp_no', '$mssion_id', '$strdate', '$enddate', '$post', '$duts');";
//$result=mysql_query($sql);
$log = new log_proccess;
    $log->Project_name="User Profile";
    $log->Function_name="Add New Mission EXP ";
	$log->Proccess_info=" Mission experince Id :$mission_exp_id  for IPO :$cp_no added with Mission :$mssion_id , Started Date:$strdate ,Ended Date:$enddate ";
	
	
	$user_id =$loggedInUser->user_id;
	try {
         
        $res = $mysqli->query($sql);
        if($res === false) {
            throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error);
        }

    $log->Proccess_result = "Succesfull";
    $log->complate();
        
    } catch (Exception $e) {
        
        $log->Proccess_result = "Unsuccesful";
        $log->Proccess_error = $e->getMessage();
        $log->complate();
		echo "<script>alert('error while inserting ');</script>";
		
    }

header("Location:personaldata.php#tabs-4");
				



}
}
}
?>
</tr>
  <tr>
  <?php
    $sqlwe = "SELECT * FROM `un_missions`,`mission_exp` where `mission_exp`.`cp_no`='$cp_no' and `un_missions`.`mission_id`=`mission_exp`.`mission_id` order by `mission_exp`.`start_date`";
	$resultwe = mysql_query( $sqlwe);
	if ($resultwe){
while($rowwe = mysql_fetch_array($resultwe))
{
echo "<td  align=center>" . $rowwe['mission_short'] . "</td>";
   echo "<td  align=center>" . $rowwe['start_date'] . "</td>";
      echo "<td  align=center>" . $rowwe['end_date'] . "</td>";
	     echo "<td  align=center>" . $rowwe['posts'] . "</td>";
		    echo "<td  align=center> " . $rowwe['duties'] . "</td>";
    $holder=$rowwe['mission_experience_id'];
   $holder1 = encrypt($holder);
   $tname=encrypt('mission_exp');
   $where=encrypt('mission_exp.mission_experience_id');
   echo "<td align=center ><a onclick=\"return confirm('Are you sure you want to delete??')\" href='Delete_pd_form.php?T_ID=$holder1&tname=$tname&where=$where#tabs-4'> <img                           																																				src='../style/images/ButtonBarDelete.gif' onmouseout=this.src='../style/images/ButtonBarDelete.gif' onmouseover=this.src='../style/images/ButtonBarDeleteOver.gif'> </a> </td>";	
	echo "</td></tr>";
}
}
?>
</tr>
</table>
	  </p>
     </div>

</div>
</form>
</body>

</html>
