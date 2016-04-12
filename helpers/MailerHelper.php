<?php
class MailerHelper
{
	public static function mail($to, $subject, $body)
	{
		$headers = "from: Tiferes Rachamim <info@tiferesrachamim.com>";
		$headers .= "\r\n";
		$headers .= "Bcc: info@tiferesrachamim.com";

		if(!filter_var($to, FILTER_VALIDATE_EMAIL))
			throw new Exception($to.' is not a vlid email address');

		$success = mail($to, $subject, $body, $headers);

		$desc = $success ?'Sucessfuly ':'Unsuccessfuly ';
		$desc .= 'sent email to '.$to.': '.$body;			
		
		MysqlAccess::log($desc);

		return $success;
	}
}
?>
