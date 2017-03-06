<?php
namespace App\System;

use \PHPMailer;

class Mailer extends PHPMailer {
    public function __construct() {
        parent::__construct();
        $this->isSMTP();
        $this->Host        = 'localhost';
        $this->Username    = null;
        $this->Password    = null;
        $this->Port        = 1025;
        $this->SMTPOptions = array(
            'ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            )
        );
    }
}