<!DOCTYPE html>
<html>
   
   <head>
      <title>Sending HTML email using PHP</title>
   </head>
   
   <body>
	<?php
		$to      = 'camagru_sp@hotmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: webmaster@example.com' . "\r\n" .
			'Reply-To: webmaster@example.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		$test = mail($to, $subject, $message, $headers);
		if ($test)
			echo 'ok';
		else
			echo 'fail';
	?>
      
   </body>
</html>