<?php

namespace App\Entity;

class IncidentUpdate
{
    protected string $platform;

    protected string $title;

    protected string $message;

    protected string $formattedTitle;

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

    public function getFormattedTitle(): string
    {
        return "{$this->platform}: {$this->title}";
    }
}
