<?php
/**
 * Remover @todo
 */

namespace Trainner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Model extends EloquentModel
{
    public function hasAttribute($attr): bool
    {
        return array_key_exists($attr, $this->attributes);
    }

    public static function boot()
    {
        parent::boot();
    }

    public function validateAndSetFromRequestAndSave(Request $request): bool
    {
        try {
            $request->validate(static::RULES);
        } catch (\ArgumentCountError $th) {
            Log::warning('Não era pra ter essa treta aqui, enquanto validava. '.static::class);
            Log::warning($th);
        }
        return $this->setFromRequestAndSave($request);
    }

    public function setFromRequestAndSave(Request $request): bool
    {
        $this->setFromRequest($request);
        return $this->save();
    }

    public function setFromRequest(Request $request): void
    {
        foreach ($this->fillable as $field) {
            if ($request->has($field) && $request->get($field)!='/') {
                $this->$field = $request->get($field);
            }
        }
    }
}
