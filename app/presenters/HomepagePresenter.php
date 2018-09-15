<?php

namespace App\Presenters;

use Gelf\Logger;
use Gelf\Message;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Nette;
use Psr\Log\LogLevel;


class HomepagePresenter extends Nette\Application\UI\Presenter
{

    public function actionDefault() {

        // We need a transport - UDP via port 12201 is standard.
        $transport = new UdpTransport("127.0.0.1", 12201, Gelf\Transport\UdpTransport::CHUNK_SIZE_LAN);
// While the UDP transport is itself a publisher, we wrap it in a real Publisher for convenience.
// A publisher allows for message validation before transmission, and also supports sending
// messages to multiple backends at once.
        $publisher = new Publisher();
        $publisher->addTransport($transport);
// Now we can create custom messages and publish them
        $message = new Message();
        $message->setShortMessage("Foobar!")
            ->setLevel(LogLevel::ALERT)
            ->setFullMessage("There was a foo in bar")
            ->setFacility("example-facility")
        ;
        $publisher->publish($message);
// The implementation of PSR-3 is encapsulated in the Logger-class.
// It provides high-level logging methods, such as alert(), info(), etc.
        $logger = new Logger($publisher, "example-facility");
// Now we can log...
        $logger->alert("Foobaz!");

        dd($logger);

    }

    public function actionError() {

        $this->vyhodError();

    }

}
