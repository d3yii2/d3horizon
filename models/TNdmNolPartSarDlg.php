<?php

namespace d3yii2\d3horizon\models;

use d3yii2\d3horizon\components\ApiModel;
use d3yii2\d3horizon\interfaces\ApiActiveRecordInterface;
use yii\base\Exception;


/**
 *
 * Partijas(TNdmNolPartSarDlg)
 * @link https://horizon-rest-doc.visma.lv/en/ApiDoc?ServiceCode=TNdmNolPartSarDlg
 *
 * @property  string $DAT_PART datums
 * @property  integer $PK_NOMPART
 *
 * Nomenklatura - TNdmNolPartSarDlg_TNdmNom001Structure
 * @property  integer $N_PK_NOM
 * @property  string $N_KODS
 * @property  string $N_NOSAUK
 *
 *  brīvais atlikums - TNdmNolPartSarDlg_TdmBLData068Structure
 * @property  float $ATL_DAUDZ
 *
 * Uzskaites atlikums TNdmNolPartSarDlg_TNdmVOL067Structure
 * @property  float $FF_DAUDZ
 *
 * TNdmNolPartSarDlg_TNdmPart000Structure
 * @property  float $CENA_IEG  iegādes cena
 *
 */
class TNdmNolPartSarDlg extends ApiModel implements ApiActiveRecordInterface
{


    public function attributes(): array
    {

        return array_merge(
            parent::attributes(),
            [
                'DAT_PART',
                'PK_NOMPART',
                'CENA_IEG',

                /** nomenklatura */
                'N_PK_NOM','N_KODS','N_NOSAUK',

                /** brīvais atlikums */
                'ATL_DAUDZ',

                /** Uzskaites atlikums */
                'FF_DAUDZ',

            ]
        );
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [
                    [
                        'N_PK_NOM','PK_NOMPART'
                    ],
                    'integer'
                ],
                [['N_NOSAUK'], 'string', 'max' => 100],
                ['N_KODS', 'string', 'max' => 18],
                [['CENA_IEG','ATL_DAUDZ','FF_DAUDZ'],'number'],
                ['DAT_PART', 'date', 'format' => 'php:Y-m-d']
            ]
        );
    }

    public static function vismaRelations(): array
    {
        return [
            'TNdmNom' => [
                'parent' => 'NP',
                'prefix' => 'N',
                'fields' => ['PK_NOM','KODS','NOSAUK']
            ],
            'TdmBLData' => [
                'parent' => 'FF',
                'prefix' => 'ATL',
                'fields' => ['DAUDZ']
            ],
            'TNdmVOL' => [
                'parent' => 'NP',
                'prefix' => 'FF',
                'fields' => ['DAUDZ']
            ],
        ];
    }

    public static function apiRequestQuery(): string
    {
        return 'TNdmNolPartSarDlg/query';
    }

    public static function apiRequest(): string
    {
        return 'TNdmNolPartSarDlg';
    }

    public static function apiRequestRecord(): string
    {
        return '';
    }

    public static function primaryKey(): array
    {
        return ['PK_NOMPART'];
    }

    public static function apiRequestInsert(): string
    {
        return 'TNdmNolPartSarDlg/template/2';
    }

    public static function apiTableQueryPrefix(): string
    {
        return 'NP';
    }

    public static function prefixFieldSeparator(): string
    {
        return '_';
    }

    public function getDefault()
    {
        return 'TNdmNolPartSarDlg/default';
    }


}