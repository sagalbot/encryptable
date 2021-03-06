# Encryptable Eloquent Model Properties [![Build Status](https://travis-ci.org/sagalbot/encryptable.svg?branch=master)](https://travis-ci.org/sagalbot/encryptable)
> A Laravel 5 package that allows you to store Eloquent model properties encrypted in your database, and automatically decrypts them when you need to access them.

![example](https://cloud.githubusercontent.com/assets/692538/25161465/f7c82b6e-2470-11e7-8b41-f23c09115e7d.png)
 
## Install

```bash
composer require sagalbot/encryptable
```

## Usage

This package is really just a simple trait and property that you can add to your Eloquent models. Usage is simple:

1. Before using Laravel's encrypter, you must set a key option in your config/app.php configuration file. 
    ```bash
    artisan key:generate
    ```
    **note:** *If you already have `APP_KEY` set in your `.env`, you should skip this step.*

2. Use the `Sagalbot\Encryptable\Encryptable` trait:
    
    ```php
    use \Sagalbot\Encryptable\Encryptable;
    ```  
    
3. Set the `$encryptable` array on your Model.

    ```php
    protected $encryptable = ['my_encrypted_property'];
    ```
    
4. That's it! Here's a complete example:

    ```php
    <?php
    
    namespace App;
    
    use Illuminate\Database\Eloquent\Model;
    use Sagalbot\Encryptable\Encryptable;
    
    class MyEncryptedModel extends Model
    {
    
        use Encryptable;
    
        /**
         * The attributes that should be encrypted when stored.
         *
         * @var array
         */
        protected $encryptable = [ 'my_encrypted_property', 'another_secret' ];
    }
    ```
    
## Encryption Options

By default, the package uses the global `encrypt()` and `decrypt()` Laravel functions, which are just aliases to resolve the `Illuminate\Encryption\Encrypter::class` out of the container. Laravel's encrypter uses OpenSSL to provide AES-256 and AES-128 encryption, which you can read more about at the [Laravel Docs](https://laravel.com/docs/5.4/encryption). 

If you need to adjust how a specific model encrypts and decrypts its properties, you can override the `decryptAttribute` and `encryptAttribute` methods on your model:  

```php
/**
 * @param $value
 */
protected function encryptAttribute($value)
{
    //  encrypt the value
}


/**
 * @param $value
 */
protected function decryptAttribute($value)
{
    //  decrypt the value
}
```

## Keep It Secret, Keep It Safe

![Keep it Secret, Keep it Safe](http://s2.quickmeme.com/img/65/65eed5fd6adc52ed940f76b91d507693b43aecb09b6133e0b7e3f01947e5144a.jpg)

Don't lose your encryption key - you can't decrypt your stored data without it.