<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;
use yii\db\Exception;

/**
 *
 * Receptes(TNdmRecSar)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmRecSar
 *
 * @property integer $PK_REC
 * @property string $KODS
 * @property string $NOSAUK
 *
 */
class TNdmRecept extends ApiModel implements ApiActiveRecordInterface
{

    /** @var \d3yii2\d3horizon\models\TdmNRecRows[] */
    public $dmNRecRows = [];

    /** @var \d3yii2\d3horizon\models\TdmNRecRows1[] */
    public $dmNRecRows1 = [];

    public static function relatedEntities()
    {
        return [
            [
                'entityName' => 'dmNRecRows',
                'entityModelClass' => TdmNRecRows::class
            ],
            [
                'entityName' => 'dmNRecRows1',
                'entityModelClass' => TdmNRecRows1::class
            ],
        ];
    }

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'KODS',
                'NOSAUK',
                'PK_REC',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['KODS', 'string', 'max' => 15],
                ['NOSAUK', 'string', 'max' => 50],
                ['PK_REC', 'integer'],
            ]
        );
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmRecSar/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmRecept';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNdmRecept';
    }

    public static function primaryKey(): array
    {
        return ['PK_REC'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TDdmCustomer/template/2';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'R';
    }

    /**
     * @param int $pkNom
     * @param int|null $cacheTime
     * @return \d3yii2\d3horizon\models\TNdmRecept|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \d3yii2\d3horizon\exceptions\RestException
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public static function findOneBySarazotasNomenklaturas(int $pkNom, int $cacheTime = null): ?TNdmRecept
    {
        /** @var TNdmRecept $recept */
        foreach (self::findAll([]) as $recept) {
            /** @var self $receptesEntity */
            $receptesEntity = self::findOneByPk($recept->PK_REC,$cacheTime);
            foreach ($receptesEntity->dmNRecRows as $row) {
                if ((int)$row->PK_NOM === $pkNom) {
                    return $receptesEntity;
                }
            }
        }
        return null;
    }


    /**
     * No receptes izveido razosanas pavadzimi
     * @param int $noliktava
     * @param string|null $pavadzimesNumurs
     * @return int
     * @throws \yii\db\Exception
     */
    public function razot(int $noliktava, string $pavadzimesNumurs = null): int
    {
        $pvzRazModel = new TNdmPvzRaz();
        /** @var TNdmPvzRaz $pvzRaz */
        $pvzRaz = $pvzRazModel->getTemplate(37);
        $pvzRaz->PK_ESPATS =$noliktava;
        $pvzRaz->DOK_NR = $pavadzimesNumurs;
        foreach ($this->dmNRecRows1 as $gatavais) {
            $tblRindasR = new tblRindasR();
            $tblRindasR->RN_VEIDS = $gatavais->RN_VEIDS;
            $tblRindasR->PK_NOM = $gatavais->PK_NOM;
            $tblRindasR->DAUDZ = $gatavais->DAUDZ;
            $tblRindasR->RAZ_VEIDS = 1; // neatradu skaidrojumu. panjemu no VISMAS piemera
            $pvzRaz->tblRindasR[] = $tblRindasR;
        }
        foreach ($this->dmNRecRows as $izejmateriali) {
            $tblRindas = new tblRindas();
            $tblRindas->RN_VEIDS = $izejmateriali->RN_VEIDS;
            $tblRindas->PK_NOM = $izejmateriali->PK_NOM;
            $tblRindas->DAUDZ = $izejmateriali->DAUDZ;
            $tblRindas->RAZ_VEIDS = 0; // neatradu skaidrojumu. panjemu no VISMAS piemera
            $pvzRaz->tblRindas[] = $tblRindas;
        }

        if (!$pvzRaz->save()) {
            throw new Exception('neizdevas saglabat TNdmPvzRaz izveidotu no TNdmRecept.PK_REC' . $this->PK_REC);
        }

        return $pvzRaz->PK_DOK;

    }

}
