<?php

namespace Trainner\Models;

use Trainner\Http\Requests\GroupRequest;
use Carbon\Carbon;
use Trainner\Traits\UsedByTeams;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Conteudo extends Model
{

    use UsedByTeams;
    use SoftDeletes;
    public const RULES = [
        // 'name'=>'required',
        // 'name'=>'required',
        // 'description'=> 'required',
        // 'local'=> 'required',
        // 'group_id'=> 'integer',
        // // 'group_id' => 'required|integer'
    ];

    protected static $organizationPerspective = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'token',
        'description',
        'local',
        'group_id',
        'token',
        'blocked_at',
        'is_active'
    ];

    protected $mappingProperties = array(

        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],

        'group_id' => [
            'type' => 'id',
            "analyzer" => "standard",
        ],

        'token' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],


        'is_active' => [
          'type' => 'string',
          "analyzer" => "standard",
        ],
    );

    public function getPlaylistToRun()
    {
        if ($this->group && $this->group->playlist) {
            return $this->group->playlist;
        }

        return null;
        
        // @todo Default
        if (!empty($playlists = Playlist::where('is_default', true)->get()) && !$playlists->isEmpty()) {
            return $playlists[0];
        }

        if (empty($playlists = Playlist::has('videos')->get()) || $playlists->isEmpty()) {
            return null;
        }

        $playlists[0]->is_default = true;
        $playlists[0]->save();
        return $playlists[0];
    }

    public function getVideosToPlay()
    {
        if (!$playlist = $this->getPlaylistToRun()) {
            return [];
        }

        return $playlist->videos;
    }
    
    /**
     * Get localized siblings of this model
     *
     * @param  Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeIsBlock($query)
    {
        return $query->where('blocked_at', null);
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group', 'group_id', 'id')->fromTeam($this->team_id);
    }


    public function acessos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Acesso');
    }

    // @todo
    public function validadeParams($params = [])
    {
        if (empty($params)) {
            return false;
        }

        return $this->group->validadeParams($params);
    }

    // @todo
    public function updateFromParams($params = []): void
    {
        if (empty($params)) {
            return ;
        }

        return ; // @todo$this->group->updateFromParams($params);
    }


    public static function getVideosViaParamsToken($request = null): array
    {
        $computer = self::getViaParamsToken($request);

        $acesso = Acesso::create([
            'computer_id' => $computer->id,
            'playlist_id' => $computer->getPlaylistToRun()?$computer->getPlaylistToRun()->id:null,
        ]);
        if ($computer->group) {
            $acesso->group_id = $computer->group->id;
        }
        $acesso->save();

        return $computer->getVideosToPlay();
    }

    public static function getViaParamsToken($request = null): Computer
    {
        return self::returnOrCreateByParams($request);
    }
    
    public static function returnOrCreateByParams($request = null): Computer
    {
        if (!$request) {
            $params = Request::all();
        } elseif (is_array($request)) {
            $params = $request;
        } else {
            $params = $request->all();
        }

        
        if (!$params || !is_array($params) || empty($params)) {
            $params = [
                'token' => self::generateToken()
            ];
        }

        if (
            (isset($params['token']) && $computer = Computer::allTeams()->where('token', $params['token'])->first()) ||
            $computer = Computer::allTeams()->where('token', md5(implode(',', $params)))->first()
        ) {
            if (!is_null($computer->blocked_at)) {
                $computer->blocked_at = null;
                $computer->is_active = 0;
                $computer->team_id = null;
            }
            $computer->updateFromParams($params);
            $computer->save();
            return $computer;
        }

        $computer = new Computer();
        $computer->blocked_at = null;
        $computer->is_active = 0;
        $computer->team_id = null; //\Config::get('teamwork.admin_is_cliente'); // @todo 
        $computer->token = md5(implode(',', $params));
        if (isset($params['token'])) {
            $computer->token = $params['token'];
        }
        $computer->updateFromParams($params);
        $computer->save();
        Log::info('Novo dispositivo registrado de token: '.$computer->token);
        return $computer;
    }


    public static function generateToken(): string
    {
        $params = [
            'ip' => Request::ip()
        ];

        return md5(implode(',', $params));
    }

    public function getDefaultPlaylist(): string
    {
        return '{"data":{"id":1,"name":"endotera defaout","is_active":true,"status":1,"videos":[{"id":16,"name":"endotera","description":null,"url":"https:\/\/media.endotera.com.br\/default.mp4","type":"video\/mp4","filename":"endotera","size":"1836047","last_modified":"1599077422","created_at":"2020-09-02 17:10:22","updated_at":"2020-09-02 17:10:22"}],"created_at":"2020-09-02 17:08:37","updated_at":"2020-09-02 19:10:52"},"success":true}';
    }
}
