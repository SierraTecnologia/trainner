<?php

namespace Trainner\Models;

use Support\Models\Base as Model;
use Trainner\Logic\Integrations\FraudAnalysis\Clearsale\Authentication;

class Auth extends Model
{
//    use Authentication;

    protected $fillable = ['name', 'password'];
}
