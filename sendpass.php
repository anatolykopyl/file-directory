<?php
    $to      = $_POST['inputEmail'];
    $subject = 'the subject';
    $message = 'hello';
    $headers = array(
        'From' => 'no-reply@radner.ru',
        'X-Mailer' => 'PHP/' . phpversion()
    );

    mail($to, $subject, $message, $headers);

    header('Location: index.php');
?>