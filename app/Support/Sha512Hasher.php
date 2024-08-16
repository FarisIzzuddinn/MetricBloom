<?php

namespace App\Support;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class Sha512Hasher implements HasherContract
{
    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @return array|string
     */
    public function make($value, array $options = [])
    {
        return hash('sha512', $value);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return $hashedValue === $this->make($value);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }

    /**
     * Get information about the given hashed value.
     *
     * @param  string  $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }
}
