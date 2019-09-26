<?php
namespace Bredi\BrediDashboard\Traits;
use Vinkla\Hashids\Facades\Hashids;
/**
 * trait for create hash id in tables
 */ 
trait HashidTrait
{

    protected static function boot() {
        parent::boot();
        static::bootCodigo();
    }

    /**
     * Registra o evento created do eloquent para gerar o campo código a partir do id.
     */
    protected static function bootCodigo() {
        static::created(function ($model) {
            $model->attributes['hash'] = Hashids::encode($model->attributes['id'], 123);
            $model->save();
        });
    }
}
