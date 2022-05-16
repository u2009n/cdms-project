

<?php
	require_once '../models/config.php';
  //  if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once 'classes/notice.class.php';
    require_once('js/noticas.js');
	$my_cp_no = encrypt($loggedInUser->cpnomber);
	$my_post_id = encrypt($loggedInUser->post_id);
	$page ='repatriated_display';
	$Repatriant_cp_no='';
	$authrized_cp_no='';
    $count1=0;
    $count2=0;
    
    
  
    
	if(isset($_POST['k'])){
		$key1 = $_POST['k'];
        $key2 = $_POST['r'];
		$conn = new db_rows();

		$key1 = " ipo.cp_no LIKE '%$key1%' OR ipo.IndexNo LIKE '%$key1%' OR ipo.FirstName LIKE '%$key1%' OR ipo.LastName LIKE '%$key1%' ";
        $key2 = " ipo.cp_no LIKE '%$key2%' OR ipo.IndexNo LIKE '%$key2%' OR ipo.FirstName LIKE '%$key2%' OR ipo.LastName LIKE '%$key2%' ";
		

		$table = "country LEFT JOIN 
								ipo LEFT JOIN 
										(positions LEFT 
												JOIN full_unit_name 
											ON positions.unit_id = full_unit_name.unit_id
										)
					            ON ipo.post_id = positions.post_id
					   
					  ON ipo.cntr_id = country.cntr_id
				 ";
        


		
		$fields = array(array('ipo.cp_no', 'cp_no'),
						array("UCASE(CONCAT (ipo.FirstName, ' ', ipo.LastName))", 'names'),
						array("UCASE (CONCAT(full_unit_name.full_name, '/',positions.post_name ))", 'position'),
						array('ipo.eom', 'eom'),
						array('ipo.doa', 'doa'),
						array('ipo.Gender', 'gender'),
						array('ipo.IndexNo', 'index_no'),
						array('ipo.post_id', 'post_id'),
						array('UCASE(country.cntr_name)', 'country')						
					  );
        
		$rows1 = $conn->get_rows($table, $fields, $key1);
        $rows2 = $conn->get_rows($table, $fields, $key2);
        $count1=count($rows1);
        $count2=count($rows2);							
        

		if((is_array($rows1)) && (is_array($rows2))) {
			
			//////////////////////////                     Repatriated Officer 
            
           
              
                $Repatriated_header = "<table> <tr><td>Checked Out Officer</td></tr></table>";
                $footer1="</table>";
                $header1 = "<table>";
                $item1 = '';
                
                foreach($rows1 as $row){
                    $eom = strtotime($row['eom']);
                    $doa = strtotime($row['doa']);
                    
                    
                    $today = time();
               
                    $Repatriant_cp_no = encrypt($row['cp_no']);
                    $ipo_index = $row['index_no'];
                    
                    $item1 .= "<tr><th>CP NO.</th>
                              <th colspan=\"4\">Names</th>
                              <th colspan=\"3\">Contingent</th>
                               <th>Date of Arrival</th>
                               <th> End of Mission</th>
                               </tr>
                               <tr>";
						$item1.="<td >".$row['cp_no']."</td>					
							     <td colspan=\"4\">".$row['names']."</td>    
                                 <td colspan=\"3\">".$row['country']."</td>
                                 <td>".date("d M Y", $doa)."</td>
                                 <td>".date("d M Y", $eom)."</td>
                                 </tr>";
                   }

                             
                //////////////////////////                     An Authrized Officer 
                
                $authrized_header="<table><tr><td> An Authrized Officer </td></tr></table>";
                $header2 = "<table>";
                $footer2 = "</table><p></p>";
               
			    $item2 = NULL;
                foreach($rows2 as $row){
			    	$eom = strtotime($row['eom']);
				    $doa = strtotime($row['doa']);
                    
                    
                    $today = time();
                    $item2 = "";
                    $authrized_cp_no = encrypt($row['cp_no']);
                    $ipo_index = $row['index_no'];
                    
                    
                    $item2.="<tr><th>CP NO.</th>
                              <th colspan=\"4\">Names</th>
                              <th colspan=\"3\">Contingent</th>
                               <th>Date of Arrival</th>
                               <th> End of Mission</th>
                               </tr>
                               <tr>";
                    $item2.="<td >".$row['cp_no']."</td>					
							     <td colspan=\"4\">".$row['names']."</td>    
                                 <td colspan=\"3\">".$row['country']."</td>
                                 <td>".date("d M Y", $doa)."</td>
                                 <td>".date("d M Y", $eom)."</td>
                                </tr>";
                  
                  }
           /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                 
                  $page_footer1="<table>";
                   $page_footer2="</table>";
                   $item3=null;
                    $item3 .= "<tr>
						 <span id=\"msg$Repatriant_cp_no\"></span>					
					</tr>";	
                    
                    $new_button =
                         "<button onclick = \"approve_authrization('$Repatriant_cp_no','$authrized_cp_no')\"> Submit</button>
                         <button onclick = \"unload_authoriztion ()\"> Close</button>"
					;				
                    
                    
                    $item3.="<tr><th colspan=\"10\">
									$new_button 
                                                                      
								</th></tr>
						  ";
                   // $item=null;
                   // $item = "<tr><th colspan=\"6\" id=\"repatriated_display$ipo_index\"></th></tr>";
                    $disply= (($count1<=1) && ($count2<=1))? "$page_footer1.$item3.$page_footer2":'';
                    echo $Repatriated_header;
                    echo $header1.$item1.$footer1;
                    echo $authrized_header;
                    echo $header2.$item2.$footer2;
                    echo $disply;
                

            }
            
            
            
        }
    
?>