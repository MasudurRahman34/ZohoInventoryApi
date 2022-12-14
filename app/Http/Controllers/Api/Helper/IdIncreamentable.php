<?php

namespace App\Http\Controllers\Api\Helper;

trait IdIncreamentable
{

    public function maxNumber($model, $source)
    {
        $maxNumber = $model::withTrashed()->max($source);
        return $maxNumber + 1;
    }
    public static function bootIdIncreamentable()
    {
        static::creating(function ($model) {
            $settings = $model->IdIncreamentable();
            $generatedId = $model->generateId($model, $model->IdIncreamentable());
            $attrbute = substr($settings['attribute'], 0);
            $model->$attrbute = $generatedId;
        });
    }
    abstract public function IdIncreamentable(): array;

    public function generateId($model, array $settings)
    {
        $maxNumber = $model->maxNumber($model, $settings['source']);
        $prefix = $settings['prefix'];
        $generatedId = $prefix . str_pad($maxNumber, 0, '0', STR_PAD_LEFT);
        return $generatedId;
    }

    
}
