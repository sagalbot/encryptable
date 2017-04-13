<?php

namespace Sagalbot\Encryptable;

use Crypt;

/**
 * Used to encrypt/decrypt Eloquent Model properties.
 * Any properties listed in the $encryptable array
 * will be automatically encrypted when set, and
 * decrypted when accessed, or when the model
 * is converted toJson() or toArray().
 *
 * Encryption is handled by the Crypt facade, which
 * uses the cipher/key defined in config/app.php.
 *
 * Class Encryptable
 * @package SC2
 */
trait Encryptable
{

    /**
     * @param $key
     *
     * @return bool
     */
    protected function isEncryptable($key)
    {
        return in_array($key, $this->encryptable);
    }


    /**
     * Decrypt a value.
     *
     * @param $value
     *
     * @return string
     */
    protected function decryptAttribute($value)
    {
        $value = Crypt::decrypt($value);

        return $value;
    }


    /**
     * Encrypt a value.
     *
     * @param $value
     *
     * @return string
     */
    protected function encryptAttribute($value)
    {
        $value = Crypt::encrypt($value);

        return $value;
    }


    /**
     * Extend the Eloquent method so properties present in
     * $encryptable are decrypted when directly accessed.
     *
     * @param $key  The attribute key
     *
     * @return string
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($this->isEncryptable($key)) {
            $value = $this->decryptAttribute($value);
        }

        return $value;
    }


    /**
     * Extend the Eloquent method so properties present in
     * $encryptable are encrypted whenever they are set.
     *
     * @param $key      The attribute key
     * @param $value    Attribute value to set
     *
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if ($this->isEncryptable($key)) {
            $value = $this->encryptAttribute($value);
        }

        return parent::setAttribute($key, $value);
    }


    /**
     * Extend the Eloquent method so properties in
     * $encryptable are decrypted when toArray()
     * or toJson() is called.
     *
     * @return mixed
     */
    public function getArrayableAttributes()
    {
        $attributes = parent::getArrayableAttributes();

        foreach ($attributes as $key => $attribute) {
            if ($this->isEncryptable($key)) {
                $attributes[$key] = $this->decryptAttribute($attribute);
            }
        }

        return $attributes;
    }
}