<?php
namespace PH7;
defined('PH7') or exit('Restricted access');

class LoginAdminFormProcessing extends Form {

    public function __construct() {
        parent::__construct();

        sleep(6); // Security against brute-force attack and this will irritate the hacker
        $this->session->set('captcha_admin_enabled',1); // Enable Captcha
        \PFBC\Form::setError('form_admin_login', t('"Email", "Username" or "Password" is Incorrect'));
    }

}
