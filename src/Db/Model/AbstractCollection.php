<?php

namespace NHDS\Jobs\Db\Model;

use NHDS\Jobs\Db\Connection\ContainerInterface;
use NHDS\Jobs\Db\Model;
use NHDS\Toolkit\Data\Property\Crud;
use NHDS\Jobs\Db;
use Zend\Db\Sql\Select;

abstract class AbstractCollection implements CollectionInterface
{
    use Crud\AwareTrait;
    use Model\AwareTrait;
    use Db\Connection\Container\AwareTrait;
    const PROP_SELECT  = 'select';
    const PROP_MODELS  = 'objects';
    const PROP_RECORDS = 'records';

    public function getSelect(): Select
    {
        if (!$this->_exists(self::PROP_SELECT)) {
            $select = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB);
            $select->select($this->_getModel()->getTableName());
            $this->_create(self::PROP_SELECT, $select);
        }

        return $this->_read(self::PROP_SELECT);
    }

    public function &getModelsArray(): array
    {
        if (!$this->_exists(self::PROP_MODELS)) {
            $models = [];
            foreach ($this->getRecords() as $record) {
                $model = $this->_getModelClone();
                $model->setPersistentProperties($record);
                $models[] = $model;
            }
            $this->_create(self::PROP_MODELS, $models);
        }

        return $this->_read(self::PROP_MODELS);
    }

    public function getRecords(): array
    {
        if (!$this->_exists(self::PROP_RECORDS)) {
            $select = $this->getSelect();
            $statement = $this->_getDbConnectionContainer(ContainerInterface::NAME_JOB)->getStatement($select);
            $records = $statement->execute()->current();
            if ($records === false) {
                $this->_create(self::PROP_RECORDS, []);
            }else {
                $this->_create(self::PROP_RECORDS, $statement->execute()->current());
            }
        }

        return $this->_read(self::PROP_RECORDS);
    }
}