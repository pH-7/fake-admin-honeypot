<?php
namespace PH7;
use PH7\Framework\Ip\Ip, PH7\Framework\Mail\Mail;

class Logger extends Core {

    private $fIp, $sContents;

    public function init(array $aData) {
        $this->fIp = Ip::get();
        extract($_POST);

        $this->sContents = t('[%0%] IP: %1% - LOGIN - Email: %2% - Username: %3% - Password: %4%', $this->dateTime->get()->dateTime(), $this->fIp, $mail, $username, $password) . "\n";

        $this->writeFile();

        if($this->config->values['module.setting']['report_email'])
            $this->sendMessage();
    }

    protected function writeFile() {
        $sFileName = $this->fIp . '.log';
        $sFilePath = $this->registry->path_module_inc . '_attackers/' . $sFileName;
        $iFlag = (is_file($sFilePath)) ? FILE_APPEND : 0;
        file_put_contents($sFilePath, $this->sContents, $iFlag);
    }

    protected function sendMessage() {
        $aInfo = [
          'to' => $this->config->values['logging']['bug_report_email'],
          'subject' => t('Reporting of the Fake Admin Honeypot')
        ];

        (new Mail)->send($aInfo, $this->sContents, false);
    }

}
