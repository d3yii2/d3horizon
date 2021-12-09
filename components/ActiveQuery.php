<?php

namespace d3yii2\d3horizon\components;

use simialbi\yii2\rest\Command;
use yii\base\InvalidConfigException;


/**
 * Class RestQuery
 */
class ActiveQuery extends \simialbi\yii2\rest\ActiveQuery
{

    /**
     * Creates a DB command that can be used to execute this query.
     *
     * @param Connection $db the DB connection used to create the DB command.
     *                       If null, the DB connection returned by [[modelClass]] will be used.
     *
     * @return \simialbi\yii2\rest\Command the created DB command instance.
     * @throws InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\base\NotSupportedException
     */
    public function createCommand($db = null): Command
    {
        /**
         * @var ActiveRecord $modelClass
         */
        $modelClass = $this->modelClass;

        if ($db === null) {
            $db = $modelClass::getDb();
        }

        return parent::createCommand($db);
    }

    /**
     * {@inheritdoc}
     */
    public function all($db = null)
    {
        /**
         * @var ActiveRecord $modelClass
         */
        $modelClass = $this->modelClass;
        if ($this->from === null) {
            $this->from($modelClass::modelName() . '/query');
        }

        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    public function one($db = null)
    {
        /**
         * @var ActiveRecord $modelClass
         */
        $modelClass = $this->modelClass;
        if ($this->from === null) {
            $this->from($modelClass::modelName());
        }

        $row = parent::one($db);
        if ($row) {
            $models = $this->populate([$row]);
            return reset($models) ?: null;
        }

        return null;
    }

}
