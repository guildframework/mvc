<?php
/**
 *
 */

namespace Guild\Filter\Word;


class CamelCase
{
    /**
     * @param $input
     * @param bool $capitalizeFirstCharacter
     * @return string
     */
    public function dashToCamelCase($input, $capitalizeFirstCharacter = true)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $input)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }
}