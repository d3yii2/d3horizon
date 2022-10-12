<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;
use yii\base\Exception;


/**
 *
 * Ražošanas pavadzīme(TNdmPvzRaz)
 * @link https://horizon-rest-doc.visma.lv/lv/ApiDoc?ServiceCode=TNdmPvzRaz
 *
 * @property integer $PK_DOKT Dokumenta tips
 * @property integer $PAMV_ID Dokumenta veids
 * @property integer $PK_DOK Pavadzīme
 * @property integer $PK_IESTADE Iestāde
 * @property integer $STATUSS
 * @property integer $PK_ESPATS NOLIKTAVA
 * @property string $DAT_DOK dokumenta datums
 * @property int $PK_VAL valūta
 * @property string $DOK_NR Nummurs
 * @property int $TIPS Nummurs
 * @property int $PK_KLIENTS Cehs
 *
 */
class TNdmPvzRaz extends ApiModel implements ApiActiveRecordInterface
{

    public const STATUSS_APSTRADE = -2;
    public const STATUSS_GRAMATOTS = 3;
    public const STATUSS_IZPILDITS = 2;
    public const STATUSS_IZVEIDOTS = 0;
    public const STATUSS_SAGATAVE = 1;
    public const STATUSS_STORNETS = 4;

    public const TIPS_DOKUMENTS = 1;
    public const TIPS_REFORMACIJA = 5;
    public const TIPS_SAKUMA_ATLIKUMS = 2;
    //const findAll = ;

    /** @var \d3yii2\d3horizon\models\tblRindas[] izejvielas */
    public $tblRindas = [];

    /** @var \d3yii2\d3horizon\models\tblRindasR[] Razjojamais */
    public $tblRindasR = [];

    /** @var \d3yii2\d3horizon\models\TNdmPvzRazQrySubRindas[] izmatotas partijas nomenklatura */
    public $qrySubRindas = [];

    /**
     * @throws \yii\db\Exception
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function findByPkDok(int $pkDok): self
    {
        return parent::findOne($pkDok);
    }

    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'PK_DOKT',
                'PAMV_ID',
                'PK_DOK',
                'PK_IESTADE',
                'STATUSS',
                'PK_ESPATS',
                'DAT_DOK',
                'PK_VAL',
                'DOK_NR',
                'TIPS',
                'PK_KLIENTS',
            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['DAT_DOK', 'string', 'max' => 10],
                ['DOK_NR', 'string', 'max' => 25],
                [
                    [
                        'PK_DOKT', 'PAMV_ID', 'PK_DOK',
                        'PK_IESTADE', 'PK_ESPATS', 'PK_VAL',
                        'TIPS', 'PK_KLIENTS'
                    ],
                    'integer'
                ],
            ]
        );
    }

    public static function relatedEntities(): array
    {
        return [
            [
                'entityName' => 'tblRindas',
                'entityModelClass' => tblRindas::class
            ],
            [
                'entityName' => 'tblRindasR',
                'entityModelClass' => tblRindasR::class
            ],
            [
                'entityName' => 'qrySubRindas',
                'entityModelClass' => TNdmPvzRazQrySubRindas::class
            ],
        ];
    }

    /**
     * @throws \yii\base\Exception
     */
    public static function apiRequestQuery(): string
    {
        throw new Exception('Query not exist');
    }

    public static function apiRequest(): string
    {
        return 'TNdmPvzRaz';
    }

    public static function apiRequestRecord(): string
    {
        return 'TNdmPvzRaz';
    }

    public static function primaryKey(): array
    {
        return ['PK_DOK'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TNdmPvzRaz/template/37';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'NRAZ';
    }

    /**
     * sasumē izmantoto produktu izmaksas pēc partiju iepirkumu cenmas
     * darbojas, ja ir tikai viens produkts
     * @throws \yii\db\Exception
     * @throws \simialbi\yii2\rest\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \yii\base\Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function calcSarazotaSuma(): void
    {

        /** @var TNdmPvzSar $sarazots */
        $sarazots = TNdmPvzSar::findOne($this->PK_DOK);

        /**
         * Pavadzīmes ražojuma summas aizpilde
         * POST ../rest/TNdmPvzRaz/2543
         */
        $this->tblRindasR[0]->SUMMA = $sarazots->KOP_SUMMA_IZIEP2V;
        $this->tblRindasR[0]->SUMMA_IEP2V = $sarazots->KOP_SUMMA_IZIEP2V;
        $this->tblRindasR[0]->isNewRecord = true;
        if (!$this->save()) {
            throw new Exception('Neizdevās saglabāt ražojuma summu, TNdmPvzRaz.PK_DOK: ' . $this->PK_DOK);
        }
    }

    public function isQrySubrindasGramatots() : bool
    {
        $is = true;
        foreach ($this->qrySubRindas as $qrySubRinda) {
            $is = $is && $qrySubRinda->isStatusGramatots();
        }
        return $is;
    }

    /**
     * izpilde
     * @param string $gramDate
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \d3yii2\d3horizon\exceptions\RestException
     * @throws \yii\httpclient\Exception
     */
    public function executeFromKey(string $gramDate): void
    {
        $this->getDtata(
            'POST',
            'TNdmPvzRaz/ExecuteFromKey',
            [
                'aKey' => $this->PK_DOK,
                'CounterVal' => $this->COUNTER,
                'GramDate' =>$gramDate
            ]
        );
    }

    /**
     * Ģirts Juraševskis  |  10/10/2022 2:13 PM
     * DeleteDraft ir kontējumu sagataves dzēšana.
     * Tā kā veido dokumentu no nulles, šeit vari likt 0.
     */
    public function bookFromKey(int $pkShema, int $deleteDraft): void
    {
        $this->getDtata(
            'POST',
            'TNdmPvzRaz/BookFromKey',
            [
                'aKey' => $this->PK_DOK,
                'CounterVal' => $this->COUNTER,
                'aSchemaPk' =>$pkShema,
                'DeleteDraft' =>$deleteDraft,
            ]
        );
    }
}
