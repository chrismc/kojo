<?php

namespace NHDS\Jobs\Data\Job\Collection\Schedule\LimitCheck;

use NHDS\Jobs\Data\Job\Collection\Schedule\LimitCheckInterface;

trait AwareTrait
{
    public function setJobCollectionScheduleLimitCheck(LimitCheckInterface $jobCollectionScheduleLimitCheck)
    {
        $this->_create(LimitCheckInterface::class, $jobCollectionScheduleLimitCheck);

        return $this;
    }

    protected function _getJobCollectionScheduleLimitCheck(): LimitCheckInterface
    {
        return $this->_read(LimitCheckInterface::class);
    }

    protected function _getJobCollectionScheduleLimitCheckClone(): LimitCheckInterface
    {
        return clone $this->_getJobCollectionScheduleLimitCheck();
    }
}