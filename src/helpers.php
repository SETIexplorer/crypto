<?php

if (!function_exists('string2hex')) {

    /**
     * 
     * @param string $string
     * @return string
     */
    function string2hex($string) {

        $result = '';
        foreach (str_split($string) as $letter) {
            $result .= sprintf("%02X", ord($letter));
        }

        return strtolower($result);
    }

}

if (!function_exists('gen_random_string')) {

    /**
     * 
     * @param int $length
     * @return string
     */
    function gen_random_string($length = 20) {

        $special = '!@#$%^&*()_+{}[]:"|<>?/.,\';';
        $ranges = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $chars = sprintf("%s%s", implode('', $ranges), $special);

        $results = [];
        for ($i = 0; $i < $length; $i++) {
            array_push($results, $chars[rand(0, strlen($chars) - 1)]);
        }

        return implode('', $results);
    }

}