<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class ModelBase extends Model
{
    public static function filterParams($defaults, array $params)
    {
        $out = [];

        foreach ($defaults as $name => $default) {
            if (array_key_exists($name, $params)) {
                $out[$name] = $params[$name];
            } else {
                $out[$name] = $default;
            }
        }

        return $out;
    }
}