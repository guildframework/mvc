<?php
/**
 *
 */

namespace Guild\Filter\Word;


class CamelCase
{
    /**
     * @param $input string
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

    /**
     * @param $input string
     * @return string
     */
    public function camelCaseToDash($input)
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $input));
    }
}