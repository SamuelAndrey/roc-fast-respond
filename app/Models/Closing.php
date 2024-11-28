<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closing extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'ticket_id',
        'group_name',
        'requester_identity',
        'category',
        'ticket',
        'witel',
        'reason',
        'status',
        'solver',
        'action',
        'duration',
        'created_at',
        'updated_at',
        'solved_at',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($model) {
            if (empty($model->ticket_id)) {
                $timestamp = now()->format('YmdHis');
                $model->ticket_id = 'ROC4' . $timestamp . $model->id;

                $model->save();
            }
        });
    }

}
