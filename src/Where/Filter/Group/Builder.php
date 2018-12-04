<?php

namespace Neighborhoods\Kojo\Where\Filter\Group;

use Neighborhoods\Kojo\Where\Filter\GroupInterface;
use Neighborhoods\Kojo\Where;

class Builder implements BuilderInterface
{
    use Where\Filter\Group\Factory\AwareTrait;
    use Where\Filter\Map\Builder\Factory\AwareTrait;

    protected $from;

    public function build(): GroupInterface
    {
        $from = $this->getFrom();
        $group = $this->getWhereFilterGroupFactory()->create();
        $builder = $this->getWhereFilterMapBuilderFactory()->create();
        $group->setWhereFilterMap($builder->setFrom($from['filters'])->build());

        return $group;
    }

    protected function getFrom(): array
    {
        if ($this->from === null) {
            throw new \LogicException('Builder from has not been set.');
        }

        return $this->from;
    }

    public function setFrom(array $from): BuilderInterface
    {
        if ($this->from !== null) {
            throw new \LogicException('Builder from is already set.');
        }

        $this->from = $from;

        return $this;
    }
}