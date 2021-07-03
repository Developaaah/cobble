<?php

namespace App\Component\Mailer;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Mailer
 * @package App\Component\Mailer
 */
class Mailer
{

    /**
     * @var string|mixed
     */
    private string $sender;

    /**
     * @var string|mixed
     */
    private string $senderName;

    /**
     * @var string
     */
    private string $reciever;

    /**
     * @var string
     */
    private string $recieverName;

    /**
     * @var string
     */
    private string $subject;

    /**
     * @var string
     */
    private string $body;

    /**
     * @var string|mixed
     */
    private string $smtpHost;

    /**
     * @var string|mixed
     */
    private string $smtpUser;

    /**
     * @var string|mixed
     */
    private string $smtpPass;

    /**
     * @var bool
     */
    private bool $isHTML = true;

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     */
    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }

    /**
     * @return string
     */
    public function getReciever(): string
    {
        return $this->reciever;
    }

    /**
     * @param string $reciever
     */
    public function setReciever(string $reciever): void
    {
        $this->reciever = $reciever;
    }

    /**
     * @return string
     */
    public function getRecieverName(): string
    {
        return $this->recieverName;
    }

    /**
     * @param string $recieverName
     */
    public function setRecieverName(string $recieverName): void
    {
        $this->recieverName = $recieverName;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return mixed|string
     */
    public function getSmtpHost()
    {
        return $this->smtpHost;
    }

    /**
     * @param mixed|string $smtpHost
     */
    public function setSmtpHost($smtpHost): void
    {
        $this->smtpHost = $smtpHost;
    }

    /**
     * @return mixed|string
     */
    public function getSmtpUser()
    {
        return $this->smtpUser;
    }

    /**
     * @param mixed|string $smtpUser
     */
    public function setSmtpUser($smtpUser): void
    {
        $this->smtpUser = $smtpUser;
    }

    /**
     * @return mixed|string
     */
    public function getSmtpPass()
    {
        return $this->smtpPass;
    }

    /**
     * @param mixed|string $smtpPass
     */
    public function setSmtpPass($smtpPass): void
    {
        $this->smtpPass = $smtpPass;
    }

    /**
     * @return bool
     */
    public function isHTML(): bool
    {
        return $this->isHTML;
    }

    /**
     * @param bool $isHTML
     */
    public function setIsHTML(bool $isHTML): void
    {
        $this->isHTML = $isHTML;
    }

    /**
     * Mailer constructor.
     */
    public function __construct()
    {
        $this->smtpHost = $_ENV['SMTP_HOST'];
        $this->smtpUser = $_ENV['SMTP_USER'];
        $this->smtpPass = $_ENV['SMTP_PASS'];
        $this->sender = $_ENV['MAIL_SENDER'];
        $this->senderName = $_ENV['MAIL_SENDER_NAME'];
    }


    /**
     * @return bool
     */
    public function send(): bool
    {
        $mail = new PHPMailer();

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $this->smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtpUser;
            $mail->Password = $this->smtpPass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($this->sender, $this->senderName);
            $mail->addAddress($this->reciever, $this->recieverName);

            $mail->isHTML($this->isHTML);
            $mail->Subject = $this->subject;
            $mail->Body = $this->body;

            $mail->send();
            return true;

        }
        catch (\Exception $e) {
            return false;
        }

    }

}