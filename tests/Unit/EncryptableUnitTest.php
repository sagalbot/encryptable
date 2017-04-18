<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Framework\CustomEncryptionStub;
use Tests\Framework\EncryptableStub;

/**
 * Class EncryptableUnitTest
 */
class EncryptableUnitTest extends TestCase
{

    /** @test */
    public function it_can_determine_if_a_property_is_encrypted()
    {
        $stub = new EncryptableStub();
        $this->assertTrue($stub->encryptable('secret'));
    }

    /** @test */
    public function it_can_determine_if_a_property_is_not_encrypted()
    {
        $stub = new EncryptableStub();
        $this->assertFalse($stub->encryptable('email'));
    }
}