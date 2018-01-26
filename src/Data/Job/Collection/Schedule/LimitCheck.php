<?php
declare(strict_types=1);

namespace NHDS\Jobs\Data\Job\Collection\Schedule;

use NHDS\Jobs\Data\Job\CollectionAbstract;
use NHDS\Jobs\Data\JobInterface;
use NHDS\Jobs\State;
use NHDS\Jobs\Db;
use Zend\Db\Sql\Expression;

class LimitCheck extends CollectionAbstract implements LimitCheckInterface
{
    protected function _prepareCollection(): Db\Model\CollectionAbstract
    {
        $select = $this->getSelect();
        $select->where(
            [
                JobInterface::FIELD_NAME_NEXT_STATE_REQUEST => State\ServiceInterface::STATE_SCHEDULE_LIMIT_CHECK,
                JobInterface::FIELD_NAME_ASSIGNED_STATE     => State\ServiceInterface::STATE_WAITING,
            ]
        );
        $select->columns(
            [
                JobInterface::FIELD_NAME_ID,
                JobInterface::FIELD_NAME_TYPE_CODE,
                JobInterface::FIELD_NAME_PRIORITY,
                JobInterface::FIELD_NAME_CAN_WORK_IN_PARALLEL,
                JobInterface::FIELD_NAME_ASSIGNED_STATE,
                JobInterface::FIELD_NAME_NEXT_STATE_REQUEST,
                JobInterface::FIELD_NAME_PREVIOUS_STATE,
            ]
        );
        $this->getSelect()->where->and->lessThanOrEqualTo(
            JobInterface::FIELD_NAME_WORK_AT_DATE_TIME, new Expression('utc_timestamp()')
        );
        $select->order(
            [
                JobInterface::FIELD_NAME_WORK_AT_DATE_TIME
            ]
        );
        $this->_logSelect();

        return $this;
    }
}