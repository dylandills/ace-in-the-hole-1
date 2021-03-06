<?php
$msg = '';
//Don't run this unless we're handling a form submission
if (isset($_POST['myRName']) AND empty($_POST['honeypot'])) {
    /*Since the form has been submitted, let's capture the submission values so we can display them to the user on the success page*/
    $role = implode(' | ', $_POST['role']);
    $myRName = $_POST['myRName'];
    $myAge = $_POST['myAge'];
    $myREmail = $_POST['myREmail'];
    $gender = implode(' | ', $_POST['gender']);
    $myEName = $_POST['myEName'];
    $myENumber = $_POST['myENumber'];
    $event = implode(' | ', $_POST['checkEvent']);
    $myAccomendate = $_POST['myAccomendate'];
    date_default_timezone_set('Etc/UTC');

    require '../PHPMailer/PHPMailerAutoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP - requires a local mail server
    //Faster and safer than using mail()
    $mail->isSMTP();
    $mail->Host = 'mail.dylandills.webhostingforstudents.com';
    $mail->Port = 587;
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth=true;
    // Provide username and password
    $mail->Username='phpmailer@dylandills.webhostingforstudents.com';
    $mail->Password='0Fq8X50^Uzqe';

    // Use a fixed address in your own domain as the from address
    // **DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks
    $mail->setFrom('phpmailer@dylandills.webhostingforstudents.com', 'Dylan Dills');
    //Send the message to yourself, or whoever should receive contact for submissions
    $mail->addAddress('dylan.dills@pcc.edu', 'Dylan Dills');
    //Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
    $mail->addReplyTo($myREmail, $myRName);
    $mail->Subject = 'Ace In The Hole Register Form';
    //Keep it simple - don't use HTML
    $mail->isHTML(true);
    //Build a simple message body
    $mail->Body = <<<EOT
Role: $role <br />
Name: $myRName<br />
Age: $myAge<br />
Email: $myREmail<br />
Gender: $gender<br />
Emergency Contact: $myEName<br />
Emergency Contact Phone Number: $myENumber<br />
Event(s) Registering For: $event <br />
Any Accomendations?: $myAccomendate<br />
EOT;

    //Send the message, check for errors
    if (!$mail->send()) {
    //The reason for failing to send will be in $mail->ErrorInfo
    //but you shouldn't display errors to users - process the error, log it on your server.
        echo 'Mailer error: ' . $mail->ErrorInfo;
    } else {
      include 'success.html.php';
    }
    } else {
      include 'register.html.php';
    }
?>
