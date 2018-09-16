<?php

namespace App\Presenters;

use Gelf\Publisher;
use Gelf\Transport\IgnoreErrorTransportWrapper;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\WebProcessor;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{

    public function actionDefault() {

        $prefix = "nette";

        $log = new Logger($prefix);
        // 2. Graylog handler.
        $transport = new IgnoreErrorTransportWrapper(
            new UdpTransport(
                "graylog",
                12201,
                UdpTransport::CHUNK_SIZE_LAN
            )
        );

        $publisher = new Publisher($transport);
        $handler = new GelfHandler($publisher);
        $log->pushHandler($handler);

        // 3. Add extra data to the log entries.
        $log->pushProcessor(new WebProcessor());
        $log->pushProcessor(new MemoryUsageProcessor());

        $log->pushProcessor(new PsrLogMessageProcessor());
        $log->info("Nice, he is here");
    }

    public function actionError() {

        $this->vyhodError();

    }

}
