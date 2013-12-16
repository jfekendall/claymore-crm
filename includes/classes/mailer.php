<?php

/**
 * Description of mailer
 *
 * @author Justin Kendall
 * 
 * Send to one recipient:
 * 
 * require_once "mailer.php";
 * $to_justin = new mailer();
 * $to_justin->to = 'jkendall@gmail.com';
 * $to_justin->subject = 'Mailer Test';
 * $to_justin->content = "Your html or some variable for the message goes here.";
 * $to_justin->common();
 * $to_justin->mail_one();
 * $to_justin->send();
 * 
 * Send to many at once via BCC:
 * 
 * $to_justin = new mailer();
 * $to_justin->to = 'jkendall@gmail.com';
 * $to_justin->bcc = 'other.address@gmail.com, some.other.address@gmail.com';
 * $to_justin->subject = 'Mailer Test';
 * $to_justin->content = 'Your html or some variable for the message goes here.';
 * $to_justin->common();
 * $to_justin->mass_mail(); 
 * $to_justin->send();
 */
class mailer {

    public $to = '';
    public $bcc;
    public $subject;
    public $content;
    public $sender;
    public $sender_name;
    private $headers;
    private $smtpinfo = array();
    public $password;
    
    function common(){
        include('../../config.php');
        if(!isset($this->sender) || !isset($this->password)){
            $this->sender = $config['smtp_default_sender'];
            $this->password = $config['smtp_default_password'];
        }
        $this->headers = array(
            'From' => "$this->sender_name <$this->sender>",
            'To' => $this->to,
            'Subject' => $this->subject
        );
        $mime = new Mail_mime();
        $mime->setHTMLBody($this->content);
        $this->body = $mime->get();
        $this->headers = $mime->headers($this->headers);
        $this->smtpinfo["host"] = $config['smtp_server'];
        $this->smtpinfo["port"] = $config['smtp_port'];
        $this->smtpinfo["auth"] = true;
        $this->smtpinfo["username"] = "$this->sender";
        $this->smtpinfo["password"] = "$this->password";
    }

    function send() {
        $smtp = & Mail::factory("smtp", $this->smtpinfo);
        return $smtp->send($this->to, $this->headers, $this->body);
    }

    function mail_one() {
        $this->to = $this->to;
    }

    function mass_mail() {
        $this->to = "{$this->to}, {$this->bcc}";
    }

}

?>
