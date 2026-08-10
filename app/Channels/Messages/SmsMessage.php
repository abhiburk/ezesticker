<?php

namespace App\Channels\Messages;

class SmsMessage{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;
    public $url;

    /**
     * Create a new message instance.
     *
     * @param string|null $content
     */
    public function __construct($content = '' , $url = '', $dlt_id = '', $dev_mode = 0, $alter_phone = '')
    {
        $this->content = $content;
        $this->url = $url;
        $this->dlt_id = $dlt_id;
        $this->dev_mode = $dev_mode;
        $this->alter_phone = $alter_phone;
    }    /**
     * Set the message content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = trim($content);
        return $this;
    }

    public function url(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function dlt_id(string $dlt_id)
    {
        $this->dlt_id = $dlt_id;
        return $this;
    }

    public function dev_mode(string $dev_mode)
    {
        $this->dev_mode = $dev_mode;
        return $this;
    }

    public function alter_phone(string $alter_phone)
    {
        $this->alter_phone = $alter_phone;
        return $this;
    }
}
