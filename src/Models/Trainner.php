<?php

namespace Trainner\Models;

use Pedreiro\Models\Base;
use Telefonica\Traits\HasServicesAndAccounts;

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
        // 'name',
        'code',
        'code_top',
        'code_bot',
        'init_at'
    ];

    public $formFields = [
        // [
        //     'name' => 'name',
        //     'label' => 'name',
        //     'type' => 'text'
        // ],
        // [
        //     'name' => 'agencia',
        //     'label' => 'agencia',
        //     'type' => 'text'
        // ],
        [
            'name' => 'code',
            'label' => 'code',
            'type' => 'text'
        ],
        [
            'name' => 'code_top',
            'label' => 'code_top',
            'type' => 'text'
        ],
        [
            'name' => 'code_bot',
            'label' => 'code_bot',
            'type' => 'text'
        ],
        // [
        //     'name' => 'slug',
        //     'label' => 'slug',
        //     'type' => 'text'
        // ],
        // [
        //     'name' => 'status',
        //     'label' => 'Status',
        //     'type' => 'checkbox'
        // ],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        ['name' => 'init_at', 'label' => 'init_at', 'type' => 'date'],
        // ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'code',
        'code_top',
        'code_bot',
        'init_at',
        // 'description',
        // 'slug',
        // 'status'
    ];
}