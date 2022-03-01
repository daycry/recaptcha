<?php

namespace Daycry\ReCaptcha\Config;

class ReCaptcha3 extends \CodeIgniter\Config\BaseConfig
{
    public $key;

    public $secret;

    public $expectedHostname;

    public $scoreThreshold = 0.5;

    public $challengeTimeout;
}