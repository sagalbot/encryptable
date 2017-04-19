# Encryptable Eloquent Model Properties
This Laravel 5 package allows you to store Eloquent model properties encrypted in your database, and automatically decrypts them when you need to access them.
 
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
    protected $encryptable = ['myEncryptedProperty'];
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
        protected $encryptable = [ 'something_secret', 'another_secret' ];
    }
    ```
    
## Encryption Options

By default, the package uses the global `encrypt()` and `decrypt()` Laravel functions, which are just aliases to resolve the `Illuminate\Encryption\Encrypter::class` out of the container. 
If you need to adjust how a specific model `encrypts` and `decrypts` its encryptable properties, you can override the `decryptAttribute` and `encryptAttribute` methods on your model.  

By default, Laravel's encrypter uses OpenSSL to provide AES-256 and AES-128 encryption.

## Keep It Secret, Keep It Safe

Don't lose your encryption key - you can't decrypt your stored data without it.