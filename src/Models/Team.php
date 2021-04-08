<?php namespace Trainner\Models;

use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    protected $fillable = [
        'name',
        'fantasia',
        'cnpj',
        'cep',
        'endereco',
        'cep',
        'rua',
        'bairro',
        'cidade',
        'estado',
        'telefone_1',
        'telefone_1',
        'telefone_3',
        'email_1',
        'email_2',
        'owner_id'
    ];
}