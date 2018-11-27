<?php

namespace Neighborhoods\Kojo\Where\Filter\Group\Map;

use Neighborhoods\Kojo\Where\Filter\Group\MapInterface;

interface BuilderInterface
{
    public function build(): MapInterface;

    public function setRecords(array $record): BuilderInterface;
}
