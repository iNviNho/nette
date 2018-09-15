<?php
/**
 * Created by PhpStorm.
 * User: vladino
 * Date: 15.09.18
 * Time: 18:44
 */

namespace iNviNho;

use Nette\DI\CompilerExtension;

class SentryExtension extends CompilerExtension
{

    public function afterCompile($class)
    {
        if (method_exists($class, 'getMethod')) {
            $init = $class->getMethod('initialize');
        } else {
            $init = $class->methods['initialize'];
        }

        $code = '$config = ["dsn" => ?, "enabled" => ?];'.PHP_EOL;
        $code .= '\Tracy\Debugger::$onFatalError[] = function($e) use($config) {
            $sentry = \Sentry::getInstance($config);
            $sentry->logException($e);
        };'.PHP_EOL;

        $init->addBody($code, $this->getConfig());
    }

}