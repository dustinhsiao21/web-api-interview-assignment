<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const RADIO = 'radio';
    const CHECKBOX = 'checkbox';
    const SELECT = 'select';
    const TYPE = [
        self::RADIO,
        self::CHECKBOX,
        self::SELECT,
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'type',
    ];

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }
}
