<?php

namespace App\Mail;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client as GuzzleClient;
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

        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.key'));

        $apiInstance = new TransactionalEmailsApi(new GuzzleClient(), $config);

        $toRecipients = [];
        foreach ($email->getTo() as $to) {
            $toRecipients[] = ['email' => $to->getAddress(), 'name' => $to->getName() ?: $to->getAddress()];
        }

        $fromAddress = $email->getFrom()[0] ?? null;

        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => $email->getSubject(),
            'sender' => [
                'name' => $fromAddress ? $fromAddress->getName() : config('mail.from.name'),
                'email' => $fromAddress ? $fromAddress->getAddress() : config('mail.from.address'),
            ],
            'to' => $toRecipients,
            'htmlContent' => $email->getHtmlBody() ?: nl2br($email->getTextBody()),
            'textContent' => $email->getTextBody(),
        ]);

        $apiInstance->sendTransacEmail($sendSmtpEmail);
    }

    public function __toString(): string
    {
        return 'brevo-api';
    }
}
