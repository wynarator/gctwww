<?php
try{
require_once('lib/swift_required.php');

//Ustawienia polaczenia
$transport = Swift_SmtpTransport::newInstance()
				->setHost('smtp.gmail.com')
				->setPort(465)
				->setEncryption('ssl')
				->setUsername('gct.arma@gmail.com')
				->setPassword('cycki123');

//Ustawienia wysylki
$message = Swift_Message::newInstance('Nowa aplikacja')
			->setFrom(array('gct.arma@gmail.com' => 'Formularz aplikacji'))
			->setTo(array('gct.arma@gmail.com' => 'Odbiorca'));
			
//Dane z formularza
$elements = array(
	'Pseudonim' => isset($_POST['element_1']) ? $_POST['element_1'] : 'brak/pole nie uzupe³nione',
	'Nazwa Steam' => isset($_POST['element_2']) ? $_POST['element_2'] : 'brak/pole nie uzupe³nione',
	'Rok Urodzenia' => isset($_POST['element_6']) ? $_POST['element_6'] : 'brak/pole nie uzupe³nione',
	'Doœwiadczenie w ArmA2' => isset($_POST['element_3']) ? $_POST['element_3'] : 'brak/pole nie uzupe³nione',
	'Dlaczego GCT' => isset($_POST['element_4']) ? $_POST['element_4'] : 'brak/pole nie uzupe³nione',
	'Adres e-mail' => isset($_POST['element_5']) ? $_POST['element_5'] : 'brak/pole nie uzupe³nione',
	'Regulamin' => isset($_POST['element_7_1']) ? 'tak' : 'nie'
);

//Tresc wiadomosci
$body = '<h1>Formularz aplikacji</h1><dl>';
foreach($elements as $name=>$value){
	$body .= '<dt>' . $name . '</dt><dd>' . $value . '</dd>';
}
$body .= '</dl> <p><small>Wys³ano ' . date('d/m/y H:i') . '</small></p>';


$message->setBody($body, 'text/html');

//Wysylka maila
$mailer = Swift_Mailer::newInstance($transport);
$result = $mailer->send($message, $failure);

//Wyswietlenie rezultatu
if($result){
	header('Location: ../dolacz_sukces.html');
	die('<h1>TEST</h1>');
}else{
	header('Location: ../dolacz_blad.html');
	//var_dump($failure); // pokazuje adresy email na ktore nie moglo wyslac
	die('Problem z wysy³k¹ (101)');
}

}catch(Exception $e){
	header('Location: ../dolacz_blad.html');
	//var_dump($e); //jak cos nie dziala - odkomentowac
	die('Problem z wysy³k¹ (100)');
}