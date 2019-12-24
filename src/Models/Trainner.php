<?php

namespace Trainner\Models;

use Support\Models\Base;
use Population\Traits\HasServicesAndAccounts;

class Trainner extends Base
{
    use HasServicesAndAccounts;

    public $incrementing = false;
    protected $casts = [
        'code' => 'string',
    ];
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'code_top',
        'code_bot',
        'init_at'
    ];

}