<?php
declare(strict_types=1);

namespace NHDS\Jobs\Process;

use NHDS\Jobs\ProcessInterface;

interface ListenerInterface extends ProcessInterface
{
    public function processMessages(): ListenerInterface;

    public function hasMessages(): bool;
}