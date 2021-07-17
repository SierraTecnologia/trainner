<?php

namespace Trainner\Models;

// use OwenIt\Auditing\Auditable;
// use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Trainner\Traits\UsedByTeams;

class Playlist extends Model// implements AuditableContract //, Auditable;
{
    use UsedByTeams;

    public const RULES = [
        'name'=>'required',
        // 'description'=> 'required',
        // 'group_id' => 'required|integer'
    ];

    /**
     * Reprovado pelo Operadora
     */
    public static $STATUS_REPROVED = 0;

    /**
     * Aprovado pelo Operadora
     */
    public static $STATUS_APPROVED = 1;

    /**
     * Status de Em analise (O pagamento foi recebido porém ainda não foi aprovado)
     */
    public static $STATUS_ANALYSIS = 2;

    /**
     * Aguardando Processamento
     */
    public static $STATUS_NOT_PROCESSED = 4;


    protected static function paramsForOldVersionZeroPointOne(Array $params)
    {
        // Será feita em versẽs futuras
        // if ($params['status']==0) {
        //     $params['status'] = 
        // }
    }

    protected $casts = [
        'collaborator_info' => 'json',
        'fraud_analysis' => 'json',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
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
        
    );

    public function groups()
    {
        return $this->hasMany('Trainner\Models\Group')->fromTeam($this->team_id); //, 'group_id', 'id');
    }

    /**
     * Get all of the medias for the post.
     */
    public function medias()
    {
        return $this->videos();
    }

    /**
     * Get all of the videos for the post.
     */
    public function videos() {
        return $this->morphToMany(\Trainner\Models\Video::class, 'videoable')
            ->withTimestamps()
            ->fromTeam($this->team_id)
            ->withPivot('position')
            ->orderBy('videoables.position');
    }
    public function orderVideosUp($positionToUpdate)
    {
        return $this->videoUp($positionToUpdate);
    }
    public function videoUp($positionToUpdate)
    {
        $position = 0;
        foreach ($this->videos()->get() as $video) {
            if ($position == $positionToUpdate) {
                $this->videos()->updateExistingPivot($video->id, ['position' => $position-1]);
            } else if ($position+1 == $positionToUpdate) {
                $this->videos()->updateExistingPivot($video->id, ['position' => $position+1]);
            }
            ++$position;
        }
    }
    public function orderVideosDown($positionToUpdate)
    {
        return $this->videoDown($positionToUpdate);
    }
    public function videoDown($positionToUpdate)
    {
        $position = 0;
        foreach ($this->videos()->get() as $video) {
            if ($position == $positionToUpdate) {
                $this->videos()->updateExistingPivot($video->id, ['position' => $position+1]);
            } else if ($position-1 == $positionToUpdate) {
                $this->videos()->updateExistingPivot($video->id, ['position' => $position-1]);
            }
            ++$position;
        }
    }
    public function updateOrderVideos()
    {
        $position = 0;
        foreach ($this->videos()->get() as $video) {
            $this->videos()->updateExistingPivot($video->id, ['position' => $position]);
            ++$position;
        }
    }

    public function acessos()
    {
        return $this->hasMany('Trainner\Models\Acesso');
    }


    public function getStatusSpan()
    {
        return '<span class="label label-'.$this->getStatusColor().'">'.$this->getStatusName().'</span>';
    }

    /**
     * Responde uma string da Forma de Pagamento
     */
    public function getStatusName()
    {
        if ($this->status==self::$STATUS_ANALYSIS) {
            return 'Em analise';
        }

        if ($this->status==self::$STATUS_APPROVED) {
            return 'Aprovado';
        }

        if ($this->status==self::$STATUS_REPROVED) {
            return 'Reprovado';
        }

        return 'Outro';
    }

    /**
     * Responde uma string da Forma de Pagamento
     */
    public function getStatusColor()
    {
        if ($this->status==self::$STATUS_ANALYSIS) {
            return 'warning';
        }

        if ($this->status==self::$STATUS_APPROVED) {
            return 'success';
        }

        if ($this->status==self::$STATUS_REPROVED) {
            return 'danger';
        }

        return 'danger';
    }

    public function getStatusNameForApi()
    {
        // @todo Descobrir todos os códigos

        if ($this->status == Playlist::$STATUS_APPROVED){
            return 'approved';
        }

        if ($this->status == self::$STATUS_ANALYSIS){
            return 'review';
        }

        if ($this->status == self::$STATUS_REPROVED){
            return 'declined';
        }

        if ($this->status == self::$STATUS_PEDDING_PAYMENT) {
            return 'pedding';
        }

        if ($this->status == self::$STATUS_NOT_PROCESSED) {
            return 'pedding';
        }


        return 'paid';
    }


    public function getIp()
    {
        // @todo
        return Request::ip();
    }

    protected function determineOrderColumnName(): string
    {

        return 'created_at';
    }
}