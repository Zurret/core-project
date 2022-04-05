<?php

declare(strict_types=1);

namespace Core\Lib\Mail;

class Mailer
{
    private string $to;
    private string $from;
    private string $subject;
    private string $message;
    private array $templates = [
        'MailTextFileName',
    ];

    public function setTo(string $email): void
    {
        if (checkEmail($email)) {
            $this->to = $email;
        }
    }

    public function getTo(): ?string
    {
        return $this->to ?? null;
    }

    public function setFrom(string $email): void
    {
        if (checkEmail($email)) {
            $this->from = $email;
        }
    }

    public function getFrom(): ?string
    {
        return $this->from ?? null;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getSubject(): ?string
    {
        return $this->subject ?? null;
    }

    /**
     * TextFile.txt < Hello, {name}!
     * Example: $this->setMessage('TextFile', ['name' => 'John']);.
     *
     * @param array $variables
     */
    public function setMessage(string $templateName, array $variables): void
    {
        if (in_array($templateName, $this->templates)) {
            $template = file_get_contents(__DIR__.'/Text/'.$templateName.'.txt');
            $this->message = strip_tags(str_replace(array_keys($variables), array_values($variables), $template));
        }
    }

    public function getMessage(): ?string
    {
        return $this->message ?? null;
    }

    public function send(): bool
    {
        if (!is_null($this->getTo()) && !is_null($this->getSubject()) && !is_null($this->getMessage())) {
            if (!empty($this->getTo()) && !empty($this->getSubject()) && !empty($this->getMessage())) {
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-Type: text/plain; charset=utf-8';
                $headers[] = 'From: '.$this->from;
                $headers[] = 'X-Mailer: PHP/'.phpversion();

                return mail($this->getTo(), $this->getSubject(), $this->getMessage(), implode("\r\n", $headers));
            }

            return false;
        }

        return false;
    }
}
