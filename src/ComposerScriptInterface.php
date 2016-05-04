<?php

namespace Karriere\CodeQuality;

use Composer\Script\Event;

interface ComposerScriptInterface
{
    public static function run(Event $event);
}
