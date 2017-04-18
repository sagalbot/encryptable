<?php

use Illuminate\Encryption\Encrypter;

/**
 * These global functions are written here because they are
 * not available in an Illuminate package, and they are
 * used in the Encryptable::class trait. In a Laravel
 * context, the functions just resolve the Encrypter
 * singleton from the container like so:
 *
 *  function encrypt($value)
 *  {
 *      return app('encrypter')->encrypt($value);
 *  }
 *
 */

/**
 * Encrypt a value.
 *
 * @param $value
 *
 * @return string
 */
function encrypt($value)
{
    $key = base64_decode('/Z3mZaYdetRVCv9je5zF0ORhtol1si9zzv7H08oNQdk=');
    return ( new Encrypter($key, 'AES-256-CBC') )->encrypt($value);
}

/**
 * Decrypt a value.
 *
 * @param $value
 *
 * @return string
 */
function decrypt($value)
{
    $key = base64_decode('/Z3mZaYdetRVCv9je5zF0ORhtol1si9zzv7H08oNQdk=');
    return ( new Encrypter($key, 'AES-256-CBC') )->decrypt($value);
}