<?php

namespace Trainner\Models;

use Crypto;
use Trainner\Traits\UsedByTeams;

class Video extends Model
{
    use UsedByTeams;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'url',
        'path',
        'type',
        'filename',
        'size',
        'last_modified',
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    public static function boot() {
        parent::boot();
        static::creating(function (Video $video) {
            $video->name = \str_replace('.mp4', '', $video->name);
        });
    }
        
    // // /**
    // //  * Get all of the owning videoable models.
    // //  */
    // // @todo Verificar Depois
    // public function videoable()
    // {
    //     return $this->morphTo(); //, 'videoable_type', 'videoable_code'
    // }

    public function getLink()
    {
        return $this->url; // @todo
        // return route('asset.show', [
        //     'path' => Crypto::urlEncode($this->path),
        //     'contentType' => Crypto::urlEncode($this->type),
        // ]);
        // return route('asset.public', ['encFileName' => Crypto::urlEncode($this->path)]);
        // return url('public-preview/'.Crypto::urlEncode($this->path));
        // Crypto::urlEncode($this->url);
        // Crypto::urlEncode($this->path);
        // Crypto::urlEncode($this->type);
        // // Crypto::urlDecode($this->);
    }

    /**
     * Get all of the playlists for the post.
     */
    public function playlists() {
        return $this->morphedByMany(\App\Models\Playlist::class, 'videoable')
            ->withTimestamps();
    }
}
