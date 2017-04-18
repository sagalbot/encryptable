<?php

namespace Tests\Framework;

use Sagalbot\Encryptable\Encryptable;

/**
 * Class EncryptableStub
 *
 * Instead of using PHPUnit's getMockForTrait,
 * use this Stub. That way it's easier to set
 * the protected $encryptable property.
 */
class EncryptableStub
{

    use Encryptable;

    protected $encryptable = [ 'secret' ];
}