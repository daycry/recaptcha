<?php

namespace Daycry\ReCaptcha\Cells;

use Daycry\ReCaptcha\Config\ReCaptcha2;

class ReCaptcha
{
    public function init_v2(array $params)
    {
        static $num = 0;

        $num++;

        $params['num'] = $num;

        $config = config('ReCaptcha2');

        assert($config ? true : false, ReCaptcha2::class);

        $params['key'] = $config->key;

        return view('Daycry\ReCaptcha\Views\init_v2', $params);
    }

    public function init_v3(array $params)
    {
        static $inited = [];

        if (array_search($params['key'], $inited) === false)
        {
            $params['init'] = true;

            $inited[] = $params['key'];
        }
        else
        {
            $params['init'] = false;
        }

        return view('Daycry\ReCaptcha\Views\init_v3', $params);
    }
}