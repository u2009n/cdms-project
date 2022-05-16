<?php
ob_start();
require_once("../models/config.php");
require_once 'classes/ipo_bank.class.php';
require_once 'classes/time_combo.class.php';
require_once 'classes/luggage.class.php';
require_once 'classes/contingent.class.php';
require_once 'classes/db_combo.class.php';
require_once 'classes/ipo.class.php';
//if (!securePage($_SERVER['PHP_SELF'])){die();}
 
 $cp_no = ($_REQUEST['C']);
 $cp_check = strtoupper(substr($cp_no,0,2));
 $cp_no = ($cp_check =='CP')? $cp_no:$loggedInUser->cpnomber;
 
 $logged_in_user_details='';
 $encrypted = $encrypted = encrypt( $cp_no ); 
 $logged_in_user_details = unserialize($_SESSION['my_details']);
  
 $ipo=new ipo($cp_no);
 $mybank_details = new ipoBankdetails($cp_no);
// $mybank_details->getBankdetails($cp_no);
 $action_page = encrypt('bank_datails');

 
 $key = decrypt($_REQUEST['k']);
 $edit_mode = ($mybank_details->rec_id == '') ? 'a' : 'e';
 $time_bject = new _time();
 $my_contingent_id = $logged_in_user_details->contingent_id;
 
 //this part for luggageDeclration
 
 
 $my_luggage = new luggageDeclaration($cp_no);
 $destinations= array();
 $destinations = $logged_in_user_details->contingent->destinations;
 $my_travel_date = null;
 $edit_lmode =($my_luggage->declaration_id == '') ? 'a' : 'e'; 
 $action_page1 = encrypt('luggage_datails');
 
 
 
/* if($my_luggage->travel_date !=''){
	 $lmode = 'e';
	 $my_travel_date = strtotime($my_luggage->travel_date);
 }
 else{
     $my_travel_date = strtotime( $logged_in_user_details->eom);
 }*/
 
 $my_travel_date =$my_luggage->travel_date !='' ? strtotime($my_luggage->travel_date) : strtotime($ipo->eom);
 $my_travel_day = !is_null($my_travel_date) ? date('d', $my_travel_date) : NULL;
 $my_travel_month = !is_null($my_travel_date) ? date('m', $my_travel_date) : NULL;
 $my_travel_year = !is_null($my_travel_date) ? date('Y', $my_travel_date) : NULL;
 

 
 
//print_r ($loggedInUser);

$mhq_date = date_format(date_add(date_create(date ('d M Y', strtotime($ipo->eom)) ),date_interval_create_from_date_string("-10 days")), "d M Y") ; 


?>

<table border="2">

		<tr>   
		   <th  ><h1>Notice of Check-out</h1></th>	
		   <th  >Downloads</th>
		</tr>
		<tr>
			
			<td>Your Mission ends on <?php echo date ('d M Y', strtotime($ipo->eom) ); ?>. 
				 <br>You are to proceed to MHQ and commence your check-out by <?php echo $mhq_date; ?>.
			
				 <br>Please provide the travel and home bank details below.
				 <br>You  can then download the appropriate forms on the download section of this page. 
				 
			</td>
			<td >
                         
                
				<a target="_blank" href="index.php?p=<?php echo encrypt('cits_checkout_form_pdf');?>.'&i='<?php echo encrypt($cp_no);?>">CITS Checkout Form</a>"
				<p>
					<a target="_blank" href="index.php?p=<?php echo encrypt('checkout_form_pdf'); ?>.'&i='<?php echo encrypt($cp_no);?>">MHQ Check-out Form</a>
				</p>
				<p>
					<a target="_blank" href="index.php?p=<?php echo encrypt('luggage_form_pdf'); ?>.'&i='<?php echo encrypt($cp_no);?>">Luggage Declaration</a>
				</p>
			 </td>
		</tr>


		<tr>
		  <th   >Bank Account Details</th>
		  <th   >Travel Details</th>
		  
		</tr>
		<tr>
			<td>
				<table border="2">
					<tr>
                        	<input type="hidden" id="IPO_CP<?php echo $key;?>" 
									value="<?php echo $cp_no ;?>">
						<td colspan="2">Bank Name*</td>
						<td colspan="2">Branch Name*</td>
					</tr>
					<tr>
						<td colspan="2">
							<input size="40" type="text" id="bankname<?php echo $key; ?>" 
									value="<?php echo $mybank_details->bank_name; ?>">
						</td>
						<td colspan="2">
							<input size="42" type="text" id="branchname<?php echo $key; ?>" 
									value="<?php echo $mybank_details->branch_name; ?>">
						</td>

					</tr>
					
					<tr>
						<td colspan="4">Mailing Address</td>
					</tr>							
						
					<tr>
						<td colspan="4">
							<textarea cols="75" id="address<?php echo $key; ?>" rows="2"><?php echo $mybank_details->branch_address; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>Routing/ABN (US Banks)</td>
						<td>Swift Code(Non US)</td>
						<td>IBAN (EU Banks)</td>
						<td>Account Number*</td>
					</tr>
					<tr>
						<td>
							<input type="text" size="15" id="routing<?php echo $key; ?>" value="<?php echo $mybank_details->routing_abn; ?>">
                           
                            
                             <input type="hidden"  id="mode<?php echo $key; ?>" value="<?php echo $edit_mode; ?>">
						</td>
						<td>
							<input type="text" size="12" id="swiftcode<?php echo $key; ?>" value="<?php echo $mybank_details->swiftcode; ?>">
						</td>
						<td>
							<input type="text" size="16"id="iban<?php echo $key; ?>" value="<?php echo $mybank_details->iban; ?>">
						</td>
						<td>
							<input type="text" id="account<?php echo $key; ?>" value="<?php echo $mybank_details->account_no; ?>">
						</td>
					</tr>
					<tr>
						<td colspan="4" id="msg<?php echo $key; ?>"></td>
					</tr>				
					<tr>
						<td colspan="4"><button onclick="bank_details(<?php echo "'$key'"; ?>, mode<?php echo $key; ?>.value)"> Submit Bank Details</button></td>
					</tr>
				</table>
			</td>
			<td>
				<table border="2">
					<tr>
						<td>Travel Date</td>
					</tr>
					<tr>
						<td><?php echo $time_bject->date_box("lday$key", "lmonth$key", "lyear$key", 
														$my_travel_day, $my_travel_month, $my_travel_year);?></td>
					</tr>
					<tr>
						<td>Final Destination</td>
					</tr>							
					<tr>
						
						<td>
							
                          
                           
							<input type="hidden" id="IPO_CP<?php echo $key;?>" 
									value="<?php echo $cp_no ;?>">
							<input type="hidden"  id="lmode<?php echo $key; ?>" value="<?php echo $edit_lmode; ?>">	
                            	
							<input type="hidden" id="l_id<?php echo $key;?>" 
									value="<?php echo $my_luggage->declaration_id ;?>">
									
							<input type="hidden" id="l_eom<?php echo $key;?>" 
									value="<?php echo $ipo->eom ;?>">
									
							<select id="town<?php echo $key; ?>">
							
								<option></option>
								 <?php

									foreach($destinations as $d){
										extract($d);
										$selected = $id == $my_luggage->destination_id ? "selected=\"selected\"" : '';
										echo "<option  value=\"$id\" $selected>$town_name</option>";
									}
								 ?>
			
							</select>
						</td>
					</tr>
					<tr>
						<td>Forwarding Address</td>
					</tr>							
					<tr>
						<td>
							<textarea cols="35" rows="5" id="laddress<?php echo $key; ?>"><?php echo $my_luggage->forwarding_address; ?></textarea>
						</td>
					</tr>
					
					<tr>
						<td>Luggage Description</td>
					</tr>
					<tr>
						<td><textarea cols="35" rows="5" id="ldescription<?php echo $key; ?>"><?php echo $my_luggage->luggage_description; ?></textarea></td>
					</tr>
					<tr>
						<td id="lmsg<?php echo $key; ?>" class="error"></td>
					</tr>
					<tr>
						
                       <td><button onclick="luggage_details(<?php echo "'$key'"; ?>, lmode<?php echo $key; ?>.value)"> Submit Luggage Details</button></td>
					</tr>
				</table>
			</td>
			
		
		</tr>
		<tr>
			<th colspan="2">&nbsp;</th>
		</tr>
</table>