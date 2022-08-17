<?php
namespace App\Libs;

use Symfony\Component\Yaml\Yaml;

class ConfigUtil
{
    protected static $configPath = __DIR__ . '/../../config/constant/common.yml';

    protected static $messagePath = __DIR__ . '/../../config/constant/messages.yml';


    /**
     * Get message
     *
     * @param string $keyName message config keyname
     * @param array $params message placeholders value
     * @return string|null
     */
    public static function getMessage(string $keyName, array $params = []) {
        $messages = Yaml::parse(file_get_contents(self::$messagePath));

        foreach ($messages as $key => $message) {
            if ($key == $keyName) {
                // Set placeholder value for message
                foreach ($params as $i => $value) {
                    $message = str_replace("<$i>", $value, $message);
                }

                return $message;
            }
        }
    }

    /**
     * Get config value
     *
     * @param string $keyName config name
     * @return string|array|null
     */
    public static function get(string $keyName) {
        $configs = Yaml::parseFile(self::$configPath);
        $keys = explode('.', $keyName);
        $value = $configs;

        // follow the nested key to get value
        while($key = current($keys)) {
            $value = $value[$key] ?? null;
            next($keys);
        }

        return $value;
    }

    /**
     * Get config list value with the constant part of the value removed.
     *
     * Note: value of $keyName config must be type of array
     *
     * @param string $keyName config name
     * @return string|array|null
     */
    public static function getList(string $keyName) {
        // remove the <constant name> part of the value of each item in the list
        // before return the list
        return array_map(
            function($textWithConstant) {
                $constRemoved = explode('|', $textWithConstant)[0];
                return $constRemoved;
            },
            self::get($keyName)
        );
    }

    /**
     * Get the value of list item using CONSTANT part
     *
     * Note: value of $keyName config must be type of array
     *
     * @param string $keyName config name
     * @return string|null
     */
    public static function constToValue(string $const, $keyName) {
        $list = self::get($keyName);
        foreach($list as $value => $textWithConstant) {
            if ($const == explode('|', $textWithConstant)[1] ?? null) {
                return $value;
            }
        }
    }

    /**
     * Get the text of list item using CONSTANT part
     *
     * Note: value of $keyName config must be type of array
     *
     * @param string $keyName config name
     * @return string|null
     */
    public static function constToText(string $const, $keyName) {
        $list = self::get($keyName);
        foreach($list as $item) {
            list($text, $constant) = explode('|', $item);
            if ($const == $constant) {
                return $text;
            }
        }
    }
}
