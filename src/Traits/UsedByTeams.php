<?php

namespace Trainner\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class UsedByTeams.
 */
trait UsedByTeams
{
    /**
     * Boot the global scope.
     *
     * @return void
     */
    protected static function bootUsedByTeams(): void
    {
        static::addGlobalScope('team', function (Builder $builder) {
            if (!app()->runningInConsole() /*&& (auth()->guest() || !auth()->user()->isAdmin())*/) {
                static::teamGuard();

                $builder->where($builder->getQuery()->from.'.team_id', auth()->user()->currentTeam->getKey());
            }
        });

        static::saving(function (Model $model) {
            if (!isset($model->team_id) || is_null($model->team_id)) {
                if (auth()->user() && auth()->user()->currentTeam) {
                    static::teamGuard();
                    $model->team_id = auth()->user()->currentTeam->getKey();
                } else {
                    if (!$trainnerTeam = \Trainner\Models\Team::first()) {
                        $trainnerTeam = \Trainner\Models\Team::create(
                            [
                                'name' => 'Teste'
                            ]
                        );
                    }
                    $model->team_id = $trainnerTeam->id;
                }
            }
        });
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeAllTeams(Builder $query)
    {
        return $query->withoutGlobalScope('team');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromTeam(Builder $query, $teamId): self
    {
        return $query->withoutGlobalScope('team')->where($query->getQuery()->from.'.team_id', $teamId);
    }

    /**
     * @return mixed
     */
    public function team()
    {
        return $this->belongsTo(Config::get('teamwork.team_model'));
    }

    /**
     * @throws Exception
     *
     * @return void
     */
    protected static function teamGuard(): void
    {
        if (!app()->runningInConsole() && (auth()->guest() || !auth()->user()->currentTeam)) {
            throw new Exception('No authenticated user with selected team present.');
        }
    }
}