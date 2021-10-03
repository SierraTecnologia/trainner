<?php

namespace Trainner\Models;

use Carbon\Carbon;
use Exception;

class Acesso extends Model
{

    public const RULES = [
        'playlist_id' => 'required|integer',
        'computer_id' => 'required|integer',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'playlist_id',
        'computer_id'
    ];

    protected $mappingProperties = array(

        'group_id' => [
            'type' => 'id',
            "analyzer" => "standard",
        ],
        'playlist_id' => [
            'type' => 'id',
            "analyzer" => "standard",
        ],
        'computer_id' => [
            'type' => 'id',
            "analyzer" => "standard",
        ],
    );
    public function scopeActivityOlderThan($query, $interval)
    {
        return $query->where('created_at', '>=', Carbon::now()->subMinutes($interval)->toDateTimeString());
    }
    public function playlist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Playlist', 'playlist_id', 'id');
    }
    
    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Group', 'group_id', 'id');
    }
    
    public function computer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Computer', 'computer_id', 'id');
    }

}