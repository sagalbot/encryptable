<?php

namespace Tests\Framework;

use Illuminate\Database\Eloquent\Model;
use Sagalbot\Encryptable\Encryptable;

/**
 * Class EncryptableModel
 */
class EncryptableModel extends Model
{

    use Encryptable;

    protected $fillable = [ 'secret' ];

    protected $encryptable = [ 'secret' ];
}