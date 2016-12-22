<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;

interface ComposerScriptInterface
{
    /**
     * OK.
     *
     * @var int
     */
    const EXIT_CODE_OK = 0;

    /**
     * Generic/unknown error code.
     *
     * @var int
     */
    const EXIT_CODE_ERROR = 1;

    /**
     * Script argument to let commands fail.
     */
    const FLAG_FAIL = 'fail';

    /**
     * Run a script.
     *
     * @param  \Composer\Script\Event $event
     * @return mixed
     */
    public static function run(Event $event);
}
