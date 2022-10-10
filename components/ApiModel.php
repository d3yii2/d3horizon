<?php

namespace d3yii2\d3horizon\components;

use Yii;
use yii\base\Exception;
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

    /**
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception|\GuzzleHttp\Exception\GuzzleException
     * @throws \d3yii2\d3horizon\exceptions\RestException
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
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \d3yii2\d3horizon\exceptions\RestException
     * @throws \yii\httpclient\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function findOneByPk(int $pkId, int $cacheSeconds = null)
    {
        $modelClass = static::class;
        $model = new $modelClass;
        $primaryKey = $model::primaryKey()[0];
        return $model::find()
            ->setFindOneByPkCachingTime($cacheSeconds)
            ->andWhere([$primaryKey => $pkId])
            ->one();
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

    public function update($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        return $this->updateInternal($attributes);
    }

    private function insertInternal($attributes = null)
    {
        if (!$this->beforeSave(true)) {
            return false;
        }
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $modelClass */
        $modelClass = static::class;
        $insertData = $this->getVismaData();

        $connection = $this->getRestConnection();
        if (!$response = $connection->request(
            'POST',
            $modelClass::apiRequestInsert(),
            ['entity' => $insertData]
        )) {
            throw new Exception('Nevar pieslegties REST (insertt)');

        }
        $responseContentData = $connection->getResponseData();
        if (!$href = ($responseContentData['link']['href'] ?? false)) {
            throw new Exception('Can not get id from response');
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
        return $modelClass::findOne($this->$primaryKey)->COUNTER;
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
        $updateData = $this->getVismaData();
        $updateData[$primaryKey] = $this->$primaryKey;
        $updateData['COUNTER'] = $this->getCounterValue();
        $values = ['resource' => ['entity' => $updateData]];

        $path = $modelClass::apiRequest() . '/' . $this->$primaryKey;

        $connection = $this->getRestConnection();
        if (!$response = $connection->request(
            'POST',
            $path,
            $values
        )) {
            throw new Exception('Nevar pieslegties REST (update)');
        }

        if ($responseContentData = $connection->getResponseData()) {
            throw new Exception('Update error: ' . Json::encode($responseContentData));
        }
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

    public static function prefixFieldSeparator(): string
    {
        return '_';
    }

    public function getXsd()
    {
        $modelClass = static::class;
        $apiRequest = $modelClass::apiRequest();
        return $this->getDtata('GET', $apiRequest . '/' . $apiRequest . '.xsd');
    }

    public function getWadl()
    {
        $modelClass = static::class;
        $apiRequest = $modelClass::apiRequest();
        return $this->getDtata('GET', $apiRequest . '/' . $apiRequest . '.wadl');
    }

    public function getDefault()
    {
        $modelClass = static::class;
        $apiRequest = $modelClass::apiRequest();
        return $this->getDtata('GET', $apiRequest . '/default');
    }

    public function getTemplatesList()
    {
        $modelClass = static::class;
        $apiRequest = $modelClass::apiRequest();
        return $this->getDtata('GET', $apiRequest . '/template');
    }

    public function getTemplate(int $id)
    {
        $modelClass = static::class;
        $apiRequest = $modelClass::apiRequest();
       // return $this->getDtata('GET', $apiRequest . '/template/' . $id);
        $responseData =  Json::decode($this->getDtata('GET', $apiRequest . '/template/' . $id));
        if (!$entityData = $responseData['entity']??null) {
            return null;
        }
        $models = self::find()->populate([$entityData]);
        $model = reset($models);
        $model->oldAttributes = null;
        return $model;
    }

    /**
     * atgriezj relaciju tabulu laukus. Lauki ar prefixiem
     * [
     * 'relacijutabula1' => ['lauks11', 'lauks12'],
     * 'relacijutabula2' => ['lauks21', 'lauks22'],
     * ]
     * izmanto, lai neliktu bazes tabulas prefixus
     * @return array
     */
    public static function vismaRelations(): array
    {
        return [];
    }

    /**
     * related tabulām atributiem ir jau prefixi un neliek klāt jaunu
     * @param string $attribute
     * @return string
     */
    public static function addPrefixToAttribute(string $attribute): string
    {
        $modelClass = static::class;
        foreach ($modelClass::vismaRelations() as $relList) {
            foreach ($relList['fields'] as $fieldName) {
                if ($relList['prefix'] . '_' . $fieldName === $attribute) {
                    return $attribute;
                }
            }
        }
        return $modelClass::apiTableQueryPrefix()
            . $modelClass::prefixFieldSeparator()
            . $attribute;
    }

    /**
     * @return array
     */
    private function getVismaData(): array
    {
        $modelClass = static::class;
        $insertData = $this->dirtyAttributes;
//        foreach ($this->dirtyAttributes as $attributeName => $attributeValue) {
//            if ($attributeValue) {
//                $insertData[$attributeName] = $attributeValue;
//            }
//        }

        if (method_exists($modelClass, 'relatedEntities')) {
            foreach ($modelClass::relatedEntities() as $entityDef) {
                $entityName = $entityDef['entityName'];
                if (!$this->$entityName) {
                    continue;
                }
                $entityRecords = [];
                /** @var \yii\base\Model $entityRecords */
                foreach ($this->$entityName as $entityRecord) {
                    if ($entityRecord->dirtyAttributes) {
                        $entityRecords[] = $entityRecord->dirtyAttributes;
                    }
                }
                if ($entityRecords) {
                    $insertData[$entityName]['row'] = $entityRecords;
                }
            }
        }
        return $insertData;
    }
}
