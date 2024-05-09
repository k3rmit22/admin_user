<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "/vendor/autoload.php";

// Function to send email notification
function sendEmailNotification($datetime) {
    try {
        // Set the timezone to Asia/Manila
        $timezone = new DateTimeZone('Asia/Manila');
        
        // Create a DateTime object with the UTC time
        $utc_time = new DateTime($datetime, new DateTimeZone('UTC'));
        
        // Convert the UTC time to the Asia/Manila timezone
        $utc_time->setTimezone($timezone);
        
        // Format the date and time
        $formatted_datetime = $utc_time->format('Y-m-d h:i:s A');

        // Email configuration
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'deveraxkayeaika@gmail.com';
        $mail->Password = '4LIRvkdG9hJ3S0jt';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('snapprint@gmail.com', 'Reports | SnapPrint');
        $mail->addAddress('deveraxkayeaika@gmail.com');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Report Notification';
        $mail->Body = 'A new report has been submitted on ' . $formatted_datetime . '.<br>Status: Pending<br>PLEASE LOG IN TO THE REPORT DASHBOARD TO VIEW IT.';

        // Send email
        $mail->send();
    } catch (Exception $e) {
        // Handle exception
    }
}

// Get the current date and time in UTC
$datetime = gmdate('Y-m-d H:i:s');
sendEmailNotification($datetime);
?>
