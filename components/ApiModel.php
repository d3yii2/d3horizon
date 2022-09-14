<?php

namespace d3yii2\d3horizon\components;

use Yii;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

/**
 * @property integer $COUNTER
 */
class ApiModel extends BaseActiveRecord
{

    /**
     * @var \d3yii2\d3horizon\components\RestConnection
     */
    private $_restConnection;

    public function attributes(): array
    {
        return ['COUNTER'];
    }

    public function rules(): array
    {
        return [
            ['COUNTER', 'integer']
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            return $this->insert($runValidation, $attributeNames);
        }

        return $this->update($runValidation, $attributeNames) !== false;
    }


    public function insert($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        return $this->insertInternal($attributes);
    }

    private function insertInternal($attributes = null)
    {
        if (!$this->beforeSave(true)) {
            return false;
        }
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $modelClass */
        $modelClass = static::class;
        $insertData = [];
        foreach ($this->getDirtyAttributes($attributes) as $attributeName => $attributeValue) {
            if ($attributeValue) {
                $insertData[$attributeName] = $attributeValue;
            }
        }
        $values = ['entity' => $insertData];
        $connection = $this->getRestConnection();
        if (!$response = $connection->request('POST', $modelClass::apiRequestInsert(), $values)) {
            return false;
        }
        $stream = $response->getBody();
        if (!$responseContent = $stream->getContents()) {
            return false;
        }
        $responseContentData = Json::decode($responseContent);
        if (!$href = ($responseContentData['link']['href'] ?? false)) {
            $this->addError('id', 'Can not get id from response');
            return false;
        }
        $id = substr($href, strrpos($href, '/') + 1);
        $primaryKey = $modelClass::primaryKey()[0];
        $this->$primaryKey = $id;

        $changedAttributes = array_fill_keys(array_keys($insertData), null);
        $this->setOldAttributes($insertData);
        $this->afterSave(true, $changedAttributes);

        return true;
    }

    /**
     * izmanto, ja jāapdeito ieraksts un iepriekš nav savakti dati un nav zināms counteris
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\httpclient\Exception
     */
    public function getCounterValue()
    {
        if ($this->COUNTER) {
            return $this->COUNTER;
        }
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $modelClass */
        $modelClass = static::class;
        $primaryKey = $this::primaryKey()[0];
        $model = $modelClass::findOne($this->$primaryKey);
        return $model->COUNTER;
    }

    public function updateInternal($attributes = null)
    {
        if (!$this->beforeSave(true)) {
            return false;
        }
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $modelClass */
        $modelClass = static::class;
        $primaryKey = $modelClass::primaryKey()[0];
        $oldValues = $this->attributes;
        $updateData = $this->getDirtyAttributes($attributes);
        $updateData[$primaryKey] = $this->$primaryKey;
        $updateData['COUNTER'] = $this->getCounterValue();
        $values = ['resource' => ['entity' => $updateData]];

        $path = $modelClass::apiRequest() . '/' . $this->$primaryKey;

        $connection = $this->getRestConnection();
        if (!$response = $connection->request('POST', $path, $values)) {
            return false;
        }
        $stream = $response->getBody();
        if (!$responseContent = $stream->getContents()) {
            return false;
        }
        $responseContentData = Json::decode($responseContent);
        if (!$href = ($responseContentData['link']['href'] ?? false)) {
            $this->addError('id', 'Can not get id from response');
            return false;
        }
        $id = substr($href, strrpos($href, '/') + 1);
        $primaryKey = $modelClass::primaryKey()[0];
        $this->$primaryKey = $id;

        $changedAttributes = array_fill_keys(array_keys($updateData), null);
        $this->setOldAttributes($oldValues);
        $this->afterSave(true, $changedAttributes);

        return true;
    }

    /**
     * @return \d3yii2\d3horizon\components\RestConnection
     */
    public function getRestConnection(): RestConnection
    {
        if (!$this->_restConnection) {
            $this->_restConnection = Yii::$app->horizonRest;
        }
        return $this->_restConnection;
    }


    public static function primaryKey()
    {
        // TODO: Implement primaryKey() method.
    }

    /**
     * {@inheritdoc}
     * @return ApiActiveQuery the newly created [[ActiveQuery]] instance.
     * @throws \yii\base\InvalidConfigException
     */
    public static function find(): ApiActiveQuery
    {
        return Yii::createObject(ApiActiveQuery::class, [static::class]);
    }


    /**
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception|\GuzzleHttp\Exception\GuzzleException
     */
    public static function findOne($condition)
    {
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $modelClass */

        if (!is_array($condition)) {
            $modelClass = static::class;
            $model = new $modelClass;
            $primaryKey = $model::primaryKey()[0];
            return $model::find()
                ->andWhere([$primaryKey => $condition])
                ->one();
        }
        $modelClass = static::class;
        return $modelClass::find()
            ->andWhere($condition)
            ->one();
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public static function findAll($condition): ?array
    {
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $modelClass */
        $modelClass = static::class;
        return $modelClass::find()
            ->andWhere($condition)
            ->all();
    }

    public static function getDb()
    {
    }

    /**
     * @throws \yii\httpclient\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \simialbi\yii2\rest\Exception
     */
    public function delete()
    {
        if (!$this->beforeDelete()) {
            return false;
        }
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $modelClass */
        $modelClass = static::class;
        $primaryKey = $this::primaryKey()[0];
        $connection = $this->getRestConnection();
        $path = $modelClass::apiRequest() . '/' . $this->$primaryKey;
        if (!$connection->request(
            'DELETE',
            $path
        )) {
            return null;
        }
        return 1;
    }

    /**
     * @throws \yii\httpclient\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \simialbi\yii2\rest\Exception
     */
    public function getDescription()
    {

        $connection = $this->getRestConnection();
        $modelClass = static::class;
        $path = $modelClass::apiRequest();
        if (!$connection->request('GET',$path)) {
            return null;
        }
        return $connection->getResponseData();
    }

    public function getDescriptionDetailed()
    {

        $connection = $this->getRestConnection();
        $modelClass = static::class;
        $path = $modelClass::apiRequest();
        if (!$connection->request('OPTIONS',$path)) {
            return null;
        }
        return $connection->getResponseRawData();
    }

    public function getDtata(string $method, string $request )
    {

        $connection = $this->getRestConnection();
        if (!$connection->request($method,$request)) {
            return null;
        }
        return $connection->getResponseRawData();
    }
}
