<?php

namespace Daycry\ReCaptcha\Config;

class ReCaptcha2 extends \CodeIgniter\Config\BaseConfig
{
    public $key;

    public $secret;

    public $expectedHostname;

    public $challengeTimeout;
}