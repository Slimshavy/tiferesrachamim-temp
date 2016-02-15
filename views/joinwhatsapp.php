<?php
	if(isset($_POST['phone']) && $_POST['phone'])
	{
		$success = MailerHelper::mail(	'info@tiferesrachamim.com',
						'New request to join whatsapp group',
						$_POST['phone'].' requested to join the Tiferes Rachamim WhatsApp group.');
		echo json_encode(['successful'=>$success]);
	}
	else
	{
		echo json_encode(['successful'=>false]);
	}
?>
