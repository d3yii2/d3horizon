<?php

namespace d3yii2\d3horizon\interfaces;

interface ApiActiveRecordInterface
{
    public static function apiRequestQuery(): string;

    public static function apiRequest(): string;

    public static function apiRequestInsert(): string;

    public static function primaryKey(): array;

    public static function apiTableQueryPrefix(): string;

}
