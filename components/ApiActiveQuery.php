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
        if (count($this->where) === 1 && isset($this->where[$primaryKey])) {

            if (!$db->request('GET', $class::apiRequest() . '/' . $this->where[$primaryKey])) {
                return null;
            }
            $responseContentData = $db->getResponseData();

            if (!$row = $responseContentData['entity'] ?? false) {
                return null;
            }

            $models = $this->populate([$row]);
            return reset($models) ?: null;
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
        return $this->populate([reset($rows)]);
    }

    private function getDb()
    {
        $class = $this->modelClass;
        $model = new $class();
        return $model->getRestConnection();
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
            $tableRow = $row[$tablePrefix];
            $rows[$rowKey] = $tableRow;
        }
        return $rows;
    }


    private function buildQuery()
    {
        /** @var \d3yii2\d3horizon\interfaces\ApiActiveRecordInterface $class */
        $class = $this->modelClass;
        $model = new $class();

        $get = [];
        $tablePrefix = $class::apiTableQueryPrefix();
        $columns = [];
        if (!$this->select) {
            $selectColumns = $model->attributes();
        } else {
            $selectColumns = $this->select;
        }
        foreach ($selectColumns as $attribute) {
            $columns[] = $tablePrefix . '_' . $attribute;
        }
        $get['columns'] = implode(',', $columns);

        if ($this->where) {
            $filter = [];
            foreach ($this->where as $field => $value) {
                $filter[] = '(' . $tablePrefix . '_' . $field . ' eq ' . $value . ')';
            }
            $get['filter'] = implode(' and ', $filter);
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
