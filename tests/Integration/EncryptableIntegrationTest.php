<?php

namespace Tests\Integration;

use Tests\Framework\CustomEncryptionModel;
use Tests\Framework\EncryptableModel;

/**
 * Class EncryptableIntegrationTest
 * @package Tests\Integration
 */
class EncryptableIntegrationTest extends IntegrationTestCase
{

    /** @test */
    public function it_should_encrypt_properties_listed_in_the_encryptable_array_when_persisting_data()
    {
        EncryptableModel::create([ 'secret' => 'foo' ]);
        $this->assertNotContains('foo', $this->getSavedSecret());
    }


    /** @test */
    public function it_should_return_the_encrypted_string_when_calling_get_attribute_value()
    {
        $model = EncryptableModel::create([ 'secret' => 'foo' ]);
        $this->assertNotContains('foo', $model->getAttributeValue('secret'));
    }


    /** @test */
    public function it_should_decrypt_properties_listed_in_the_encryptable_array_when_accessing_them_directly(
    )
    {
        $model = EncryptableModel::create([ 'secret' => 'foo' ]);
        $this->assertEquals('foo', $model->secret);
    }


    /** @test */
    public function it_should_decrypt_properties_when_calling_to_array()
    {
        $model = EncryptableModel::create([ 'secret' => 'foo' ]);
        $this->assertEquals('foo', $model->toArray()['secret']);
    }


    /** @test */
    public function it_should_decrypt_properties_when_calling_to_json()
    {
        $model = EncryptableModel::create([ 'secret' => 'foo' ]);
        $this->assertEquals('foo', json_decode($model->toJson())->secret);
    }


    /** @test */
    public function it_can_store_arrays_as_serialized_and_encrypted_strings()
    {
        EncryptableModel::create([ 'secret' => [ 'foo' => 'bar' ] ]);
        $this->assertNotContains(serialize([ 'foo' => 'bar' ]), $this->getSavedSecret());
    }


    /** @test */
    public function it_should_decrypt_array_properties()
    {
        $model  = EncryptableModel::create([ 'secret' => [ 'foo' => 'bar' ] ]);
        $fromDB = EncryptableModel::find($model->id);

        $this->assertEquals($fromDB->secret, [ 'foo' => 'bar' ]);
    }


    /** @test */
    public function it_can_use_a_custom_encryption_method()
    {
        $model = CustomEncryptionModel::create([ 'secret' => 'foo' ]);
        $this->assertEquals('encrypted', $this->getSavedSecret());
    }


    /** @test */
    public function it_can_use_a_custom_decryption_method()
    {
        $model = CustomEncryptionModel::create([ 'secret' => 'foo' ]);
        $this->assertEquals('decrypted', $model->secret);
    }


    /**
     * Get the secret of the first model in the DB.
     * DB is reset between tests, so we can just
     * grab the first one.
     *
     * @return mixed
     */
    private function getSavedSecret()
    {
        return $this->db()
                    ->getConnection('default')
                    ->table('encryptable_models')
                    ->select('secret')
                    ->first()->secret;
    }
}