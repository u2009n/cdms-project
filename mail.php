
<?php
$to = "kahampacollins@gmail.com, unamid-pol-hq-cdbp1@un.org";
$subject = "HTML email";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <ck@rmail.com>' . "\r\n";
$headers .= 'Cc: collinskahampa@zambiapolice.org.zm' . "\r\n";

if(mail($to,$subject,$message,$headers)) 
  echo "Mail Sent!";
 else
   "Error Sending Mail!";
?> 


