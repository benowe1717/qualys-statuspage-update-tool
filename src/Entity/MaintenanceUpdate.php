<?php

namespace App\Entity;

class MaintenanceUpdate
{
    private const TICKET_NUMBER_REGEX = "/^\w{3}\-\d+$/";

    private const REF_LINK_REGEX = "/^(?P<url>(http|https)\:.*?)(http|https|$)/";

    protected string $platform;

    protected string $title;

    protected string $message;

    protected string $ticketNumber;

    protected string $referenceLink;

    protected string $formattedTitle;

    protected string $formattedMessage;

    private function validateTicketNumber(string $ticketNumber): bool
    {
        if (!preg_match(self::TICKET_NUMBER_REGEX, $ticketNumber)) {
            return false;
        }
        return true;
    }

    private function validateReferenceLink(string $referenceLink): bool
    {
        if (!preg_match(self::REF_LINK_REGEX, $referenceLink)) {
            return false;
        }
        return true;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): void
    {
        $this->platform = $platform;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getTicketNumber(): string
    {
        return $this->ticketNumber;
    }

    public function setTicketNumber(string $ticketNumber): void
    {
        $this->ticketNumber = '';
        if ($this->validateTicketNumber($ticketNumber)) {
            $this->ticketNumber = $ticketNumber;
        }
    }

    public function getReferenceLink(): string
    {
        return $this->referenceLink;
    }

    public function setReferenceLink(string $referenceLink): void
    {
        $this->referenceLink = '';
        if ($this->validateReferenceLink($referenceLink)) {
            $this->referenceLink = $referenceLink;
        }
    }

    public function getFormattedTitle(): string
    {
        return "{$this->platform}: {$this->title}";
    }

    public function getFormattedMessage(): string
    {
        $msg = '<div class="scheduled_maintenance">';
        $msg .= '<p class="ticket_no">' . $this->ticketNumber . '</p>';
        $msg .= '<p class="message">' . $this->message . '</p>';
        $msg .= '<p class="reference_link">' . $this->referenceLink . '</p>';
        $msg .= '</div>';
        return $msg;
    }
}
