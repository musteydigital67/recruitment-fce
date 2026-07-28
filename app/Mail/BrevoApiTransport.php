<?php

namespace App\Mail;

use Brevo\Brevo;
use Brevo\TransactionalEmails\Requests\SendTransacEmailRequest;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestSender;
use Brevo\TransactionalEmails\Types\SendTransacEmailRequestToItem;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;

class BrevoApiTransport extends AbstractTransport
{
    protected function doSend(SentMessage $message): void
    {
        $email = $message->getOriginalMessage();

        if (!$email instanceof Email) {
            return;
        }

        $brevo = new Brevo(config('services.brevo.key'));

        $toRecipients = [];
        foreach ($email->getTo() as $to) {
            $toRecipients[] = new SendTransacEmailRequestToItem([
                'email' => $to->getAddress(),
                'name' => $to->getName() ?: $to->getAddress(),
            ]);
        }

        $fromAddress = $email->getFrom()[0] ?? null;

        $request = new SendTransacEmailRequest([
            'sender' => new SendTransacEmailRequestSender([
                'name' => $fromAddress ? $fromAddress->getName() : config('mail.from.name'),
                'email' => $fromAddress ? $fromAddress->getAddress() : config('mail.from.address'),
            ]),
            'to' => $toRecipients,
            'subject' => $email->getSubject(),
            'htmlContent' => $email->getHtmlBody() ?: nl2br($email->getTextBody()),
            'textContent' => $email->getTextBody(),
        ]);

        $brevo->transactionalEmails->sendTransacEmail($request);
    }

    public function __toString(): string
    {
        return 'brevo-api';
    }
}