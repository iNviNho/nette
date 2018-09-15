<?php
/**
 * Created by PhpStorm.
 * User: vladino
 * Date: 15.09.18
 * Time: 18:35
 */

class Sentry
{

    /** @var Raven_Client */
    private $client;
    private $enabled;

    public static function getInstance($config) {

        $self = new self();
        $self->enabled = $config["enabled"];
        $self->client = new Raven_Client($config["dsn"]);

        return $self;
    }

    public function logException($e) {

        if ($this->enabled) {
            $this->client->captureException($e);
        }

    }

}