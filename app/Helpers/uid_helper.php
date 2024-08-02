<?php

//namespace App\Helpers\uid_helper;

if (!function_exists('generate_uid')) {
    /**
     * Generate a unique identifier (UID)
     *
     * @param int $length Length of the UID to generate
     * @return string Generated UID
     */
    function generate_uid()
    {
        // Generate a random 20-character UID
        return bin2hex(random_bytes(10));
    }
}