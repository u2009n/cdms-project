<script>
var myVar = setInterval(function () {myTimer()}, 1000);
function myTimer() {
    var d = new Date();
    document.getElementById("demo").innerHTML = d.toLocaleTimeString();
}
</script>



function get_notice_count(cp_no, post_id){
	var xmlhttp;
	if (cp_no==""){
		  document.getElementById("txtHint").innerHTML="";
		  return;
	 }
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{	// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function(){
	
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("notice_count").innerHTML=xmlhttp.responseText;
		}
	}
	
	xmlhttp.open("POST","get_notice_count.php?cp_no="+ cp_no +"&post_id="+ post_id,true);
	xmlhttp.send();
}


function newEEOM($button, $page){
    var xmlhttp;

   

    if ($button=="Cancel"){
        document.getElementById("new_eeom").innerHTML="";
        return;
    }
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{	// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
	
    if(button =="Submit"){
        xmlhttp.onreadystatechange=function(){
	
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("new_eeom").innerHTML=xmlhttp.responseText;
            }
        }
	
        xmlhttp.open("POST","index.php?p="+ $page,true);
        xmlhttp.send();
	
    }
}