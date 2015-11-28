
<?php
    /*$config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'indiacom15@gmail.com';
    $config['smtp_pass'] = 'samplepassword';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';*/
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'indiacom15@gmail.com',
        'smtp_pass' => '!nd!@c0m',
        'charset'   => 'utf-8',
        'wordwrap'  => true,
        'wrapchars' => 50,
        'crlf' => "\r\n",
        'newline' => "\r\n",
        'mailtype' => "html"
    );
    /*$config = array(
        'protocol' => 'mail',
        'smtp_host' => 'mx1.hostinger.in',
        'smtp_port' => 2525,
        'smtp_user' => 'info@abcdvluprs.com',
        'smtp_pass' => 'CPAcc#4012',
        'charset'   => 'utf-8',
        'wordwrap'  => true,
        'wrapchars' => 50,
        'crlf' => "\r\n",
        'newline' => "\r\n",
        'mailtype' => "html"
    );*/
?>