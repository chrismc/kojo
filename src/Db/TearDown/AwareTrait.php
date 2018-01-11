<?php

namespace NHDS\Jobs\Db\TearDown;

use NHDS\Jobs\Db\TearDownInterface;

trait AwareTrait
{
    public function setDbTearDown(TearDownInterface $tearDown)
    {
        $this->_create(TearDownInterface::class, $tearDown);

        return $this;
    }

    protected function _getDbTearDown(): TearDownInterface
    {
        return $this->_read(TearDownInterface::class);
    }

    protected function _getDbTearDownClone(): TearDownInterface
    {
        return clone $this->_getDbTearDown();
    }
}