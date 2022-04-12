<?php



// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$phone = $_POST['phone'];

// Формирование самого письма
$title = "Заявка с сайта gzblok.ru";
$body = "
<h2>Заявка с сайта gzblok.ru</h2>
<b>Имя:</b> $name<br>
<b>Телефон:</b> $phone<br><br>
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'ssl://smtp.mail.ru'; // SMTP сервера вашей почты
    $mail->Username   = 'Gazoblok2022'; // Логин на почте
    $mail->Password   = 'Zy8Y33j1N4zScxGzwy6J'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('Gazoblok2022@mail.ru', 'Газоблок'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('Gazoblok2022@mail.ru');  

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;    

    // Проверяем отравленность сообщения
    if ($mail->send()) {$result = "success";} 
    else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "status" => $status]);

?>