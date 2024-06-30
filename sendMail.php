<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\task-rabs\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\task-rabs\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\task-rabs\PHPMailer\src\SMTP.php';



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    
    include "conn.php";

    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["num"];
    $msg = $_POST["msg"];

    $sql = "INSERT INTO `contacts` (`name`, `email`, `number`, `message`) VALUES ('$name', '$email', '$number', '$msg');";
    $result = mysqli_query($conn, $sql);

    if ($result) {


        $mail = new PHPMailer(true);

        $senderemail = 'ramforcoding@gmail.com';
        $senderemailpass = 'riyi tawq zfww mmzx';
        
        try {
            // Configure SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $senderemail;
            $mail->Password = $senderemailpass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 25;
        
            // Recipient information
            $mail->setFrom($senderemail, 'Abhyudya Developers');
            $mail->addAddress($email, $name);
            $mail->addReplyTo($senderemail, 'Abhyudya Developers');
        
            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Thank You for Contacting Us, ' . $name;
            $mail->Body    = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Thank You for Contacting Us!</title>
            </head>
            <body style="font-family: Arial, sans-serif;">
            
                <p style="font-size: 16px; line-height: 1.6;">
                    Dear ' . $name . ',<br><br>
            
                    Thank you for reaching out to us! 🌟 We sincerely appreciate your message and want to assure you that your inquiry is important to us. Our dedicated team is working diligently to provide you with the assistance you need.<br><br>
            
                    Rest assured, we will get back to you shortly. In the meantime, if you have any further questions or concerns, feel free to let us know. We are here to help!<br><br>
            
                    Warm regards,<br><br>
            
                    Abhyudya Developers<br>
                    ramforcoding@gmail.com
                </p>
            
            </body>
            </html>';
        
            $mail->send();
            


        header("location: Thankyou.html");
    }catch (Exception $e) {
        echo 'Failed to send email: ', $mail->ErrorInfo;
    }
 } else {
        header("location: ServerError.php");
    }
}
mysqli_close($conn);