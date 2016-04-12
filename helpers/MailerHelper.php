<?php
class MailerHelper
{
	const header = 'from: Tiferes Rachamim <info@tiferesrachamim.com>'."\r\n".'Bcc: info@tiferesrachamim.com';

	public static function mail($to, $subject, $body)
	{
		$to ='shmuelyarmush@gmail.com';
		if(!filter_var($to, FILTER_VALIDATE_EMAIL))
			throw new Exception($to.' is not a vlid email address');

		$success = mail($to, $subject, $body, self::header);

		$desc = $success ?'Sucessfuly ':'Unsuccessfuly ';
		$desc .= 'sent email to '.$to.': '.$body;			
		
		MysqlAccess::log($desc);

		return $success;
	}
}
?>
