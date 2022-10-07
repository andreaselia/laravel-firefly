<?php

namespace Firefly;

use BadMethodCallException;

class Features
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        $features = config('firefly.features', []);

        if (! in_array($feature, $features) || ! array_key_exists($feature, $features)) {
            return false;
        }

        if (is_array($features[$feature])) {
            return $features[$feature]['enabled'];
        }

        return $features[$feature];
    }

    /**
     * Get a specified option from a feature.
     *
     * @param  string  $feature
     * @param  string  $option
     * @return bool
     */
    public static function option(string $feature, string $option)
    {
        if (! static::enabled($feature)) {
            return false;
        }

        return config("firefly.features.{$feature}.{$option}");
    }

    /**
     * Magic method to check any feature with a has[FeatureName]Feature method call.
     *
     * @param $method
     * @param $arguments
     * @return bool
     *
     * @throws BadMethodCallException
     */
    public static function __callStatic($method, $arguments)
    {
        if (preg_match('/has(.+?)Feature/', $method, $matches)) {
            return static::enabled(strtolower($matches[1]));
        }

        throw new BadMethodCallException;
    }
}
