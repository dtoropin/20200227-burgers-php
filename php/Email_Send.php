<?php

class Email_Send
{
    private $smtp = 'smtp.mail.ru';
    private $user = 'test032020@mail.ru';
    private $pass = '2O$uXb6DcU@8';
    private $subject = 'Register to burgers.ru';
    private $from = 'test032020@mail.ru';

    public function send($mailTo, $mess)
    {
        $transport = (new \Swift_SmtpTransport($this->smtp, 465, 'ssl'))
            ->setUsername($this->user)
            ->setPassword($this->pass);
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message($this->subject))
            ->setFrom([$this->from => $this->user])
            ->setTo([$mailTo])
            ->setBody($mess);

        $mailer->send($message);
    }
}