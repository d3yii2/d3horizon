<?php

namespace d3yii2\d3horizon\components;

use yii\db\ActiveQuery;


/**
 * Class RestQuery
 */
class ApiActiveQuery extends ActiveQuery
{

    /**
     * @param null $db
     * @return array|false|mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function one($db = null)
    {
        if (!$db) {
            $db = $this->getDb();
        }

        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $class */
        $class = $this->modelClass;
        $primaryKey = $class::primaryKey()[0];
        $apiRequestRecord = $class::apiRequestRecord();
        if ($apiRequestRecord
            && count($this->where) === 1
            && isset($this->where[$primaryKey])
        ) {


            if (!$db->request('GET', $apiRequestRecord . '/' . $this->where[$primaryKey])) {
                return null;
            }
            $responseContentData = $db->getResponseData();
            if (!$row = $responseContentData['entity'] ?? false) {
                return null;
            }

            $models = $this->populate([$row]);
            $model = reset($models);
            if (method_exists($class,'relatedEntities')) {
                foreach ($class::relatedEntities() as $entityDef) {
                    $entityName = $entityDef['entityName'];
                    $model->$entityName = [];
                    if ($entityRows = $row[$entityName]['row']??null) {
                        $entityModelClass = $entityDef['entityModelClass'];
                        foreach ($entityRows as $eRow) {
                            foreach ($eRow as $eRowKey => $eRowValue) {
                                if (is_array($eRowValue)) {
                                    preg_match('#/(\d+)$#',$eRowValue['href'], $match);
                                    $eRow[$eRowKey] = $match[1];
                                }
                            }
                            $entityModel = new $entityModelClass();
                            $entityModel->load($eRow,'');
                            $entityModel->isNewRecord = false;
                            $model->$entityName[] = $entityModel;
                        }
                    }
                }
            }

            return $model;
        }

        $this->limit(1);
        $get = $this->buildQuery();
        $path = $class::apiRequestQuery();
        if (!$db->request('GET', $path, [], $get)) {
            return null;
        }
        $responseContentData = $db->getResponseData();
        if (!$rows = $this->getResponseRows($responseContentData)) {
            return null;
        }
        $responseRows = [reset($rows)];
        $models = $this->populate($responseRows);

        return reset($models) ?: null;
    }

    private function getDb()
    {
        $class = $this->modelClass;
        return (new $class())->getRestConnection();
    }

    public function all($db = null)
    {
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $class */
        $class = $this->modelClass;
        if (!$db) {
            $db = $this->getDb();
        }


        $get = $this->buildQuery();
        $path = $class::apiRequestQuery();
        if (!$db->request('GET', $path, [], $get)) {
            return null;
        }
        $responseContentData = $db->getResponseData();
        if (!$rows = $this->getResponseRows($responseContentData)) {
            return null;
        }
        return $this->populate($rows);
    }

    public function getResponseRows(array $data)
    {
        if (!$rows = $data['collection']['row'] ?? false) {
            return null;
        }
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $class */
        $class = $this->modelClass;
        $tablePrefix = $class::apiTableQueryPrefix();
        foreach ($rows as $rowKey => $row) {
            $rows[$rowKey] = $this->getResponseRowAttributes($tablePrefix, $row[$tablePrefix], true);
        }
        return $rows;
    }

    private function getResponseRowAttributes(string $prefix, array $row, bool $isBase = false): array
    {

        $class = new $this->modelClass;
        $attributes = [];
        $childRelations = [];
        foreach ($class::vismaRelations() as $relTable) {
            if ($relTable['parent'] === $prefix) {
                $childRelations[$relTable['prefix']] = $relTable['fields'];
            }
        }

        $modelAttributes = $class->attributes();

        foreach ($row as $name => $value) {

            if ($isBase && in_array($name, $modelAttributes, true)) {
                $attributes[$name] = $value;
                continue;
            }
            if (!$isBase) {
                $relName = $prefix . '_' . $name;
                if (in_array($relName, $modelAttributes, true)) {
                    $attributes[$relName] = $value;
                    continue;
                }
            }
            if (isset($childRelations[$name])) {
                foreach ($this->getResponseRowAttributes($name, $value) as $rName => $rvalue) {
                    $attributes[$rName] = $rvalue;
                }
            }

        }
        return $attributes;
    }

    private function buildQuery()
    {
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $class */
        $class = $this->modelClass;
        $model = new $class();

        $get = [];
        $columns = [];
        if (!$this->select) {
            $selectColumns = $model->attributes();
        } else {
            $selectColumns = $this->select;
        }
        foreach ($selectColumns as $attribute) {
            $columns[] = $class::addPrefixToAttribute($attribute);
        }
        $get['columns'] = implode(',', $columns);

        if ($this->where) {
            $filter = [];
            foreach ($this->where as $field => $value) {
                if (is_int($field)) {
                    $filter[] = $value;
                    continue;
                }
                $filter[] = '(' . $class::addPrefixToAttribute($field) . ' eq ' . $value . ')';
            }
            $get['filter'] = implode(' and ', $filter);
        }
        if ($this->orderBy) {
            $orderBy = [];
            foreach ($this->orderBy as $fieldName => $direction) {
                $orderBy[] = $class::addPrefixToAttribute($fieldName)
                    . ' '
                    . ($direction === SORT_ASC?'asc':'desc');
            }
        }
        $get['limit'] = $this->limit;

        return $get;
    }

    /**
     * {@inheritDoc}
     */
    protected function createModels($rows): array
    {
        if ($this->asArray) {
            return $rows;
        }
        $models = [];
        /* @var $class \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface */
        $class = $this->modelClass;
        foreach ($rows as $row) {
            foreach ($row as $attributeName => $attributeValue) {
                if (strpos($attributeName, 'PK_') !== 0) {
                    continue;
                }
                if (!is_array($attributeValue)) {
                    continue;
                }
                if (!$href = ($attributeValue['href'] ?? false)) {
                    continue;
                }
                $row[$attributeName] = substr($href, strrpos($href, '/') + 1);
            }
            $model = $class::instantiate($row);
            /** @var $modelClass \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface */
            $modelClass = get_class($model);
            $modelClass::populateRecord($model, $row);

//            if (!empty($this->join)) {
//                foreach ($this->join as $join) {
//                    if (isset($join[1], $row[$join[1]])) {
//                        if ($relation = $model->getRelation($join[1])) {
//                            $rows = (ArrayHelper::isAssociative($row[$join[1]])) ? [$row[$join[1]]] : $row[$join[1]];
//                            $relations = $relation->populate($rows);
//                            $model->populateRelation($join[1], $relation->multiple ? $relations : $relations[0]);
//                        }
//                    }
//                }
//            }
            $models[] = $model;
        }
        return $models;
    }
}
