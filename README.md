[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate?business=SYC5XDT23UZ5G&no_recurring=0&item_name=Thank+you%21&currency_code=EUR)

# Encryption Library [![](https://github.com/daycry/encryption/workflows/PHP%20Tests/badge.svg)](https://github.com/daycry/encryption/actions?query=workflow%3A%22PHP+Tests%22)

ReCaptcha for Codeigniter 4

## Installation via composer

Use the package with composer install

	> composer require daycry/recaptcha

## Manual installation

Download this repo and then enable it by editing **app/Config/Autoload.php** and adding the **Daycry\ReCaptcha**
namespace to the **$psr4** array. For example, if you copied it into **app/ThirdParty**:

```php
$psr4 = [
    'Config'      => APPPATH . 'Config',
    APP_NAMESPACE => APPPATH,
    'App'         => APPPATH,
    'Daycry\ReCaptcha' => APPPATH .'Libraries/recaptcha/src',
];

```
## Configuration

In the .env file you need to add your personal ReCaptcha keys.

```
# --------------------------------------------------------------------
# ReCaptcha 2
# --------------------------------------------------------------------
recaptcha2.key = 'XXXXXXXX-XXXXXXXX'
recaptcha2.secret = 'XXXXXXXX-XXXXXXXX'

# --------------------------------------------------------------------
# ReCaptcha 3
# --------------------------------------------------------------------
recaptcha3.key = 'XXXXXXXX-XXXXXXXX'
recaptcha3.secret = 'XXXXXXXX-XXXXXXXX'
recaptcha3.scoreThreshold = 0.5

In the /app/Config/Validation.php file you need to add settings for validator:

```
public $ruleSets = [
    ...
    \Daycry\ReCaptcha\Validation\ReCaptchaRules::class
];
```

### Rendering ReCaptcha v2

```
helper(['form', 'reCaptcha']);

echo form_open();

echo reCaptcha2('reCaptcha2', ['id' => 'recaptcha_v2'], ['theme' => 'dark']);

echo form_submit('submit', 'Submit');

echo form_close();
```

### Rendering ReCaptcha v3

```
helper(['form', 'reCaptcha']);

echo form_open();

echo reCaptcha3('reCaptcha3', ['id' => 'recaptcha_v3'], ['action' => 'contactForm']);

echo form_submit('submit', 'Submit');

echo form_close();
```


If you are using Twig: https://github.com/daycry/twig

add helper in array of helpers in the controller
```
helper(['form', 'reCaptcha']);
```

add **'reCaptcha3'** in **functions_safe** in config file and call the helper funcion.
```
public $functions_safe = [ 'form_hidden', 'form_open', 'form_close', 'csrf_token', 'csrf_hash', 'url_title', 'reCaptcha3' ];
```
and call the function in twig file.

```
{{ reCaptcha3( 'reCaptcha', {'id' : 'recaptcha_v3'}, {'action' : 'signup'} ) | raw }}
```



### Checking ReCaptcha in a model:

```
public $validationRules = [
    'reCaptcha2' => 'required|reCaptcha2[]'
    'reCaptcha3' => 'required|reCaptcha3[contactForm,0.9]'
    ....
];
```