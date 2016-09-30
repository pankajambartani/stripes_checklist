<!doctype <!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>
    <form action="" method="post">
        <input type="submit" value="Send" />
        <input type="hidden" name="button_pressed" value="1" />
    </form>

    <?php

    if(isset($_POST['button_pressed']))
    {
        $to      = 'kiz@hp.com';
        $subject = 'Email';
        $message = 'hello Email testing';
        $headers = 'From: kiz@hp.com' . "\r\n" .
        'Reply-To: kiz@kiz.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        // echo 'Email Sent.';
    }
    ?>
</body>
</html>

