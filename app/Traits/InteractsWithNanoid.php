<?php

namespace App\Traits;

use App\Services\NanoId\Client;

trait InteractsWithNanoid
{
    /**
     * Get the nanoid length.
     */
    protected function getNanoidLength(): ?int
    {
        if (is_array($this->nanoidLength)) {
            return random_int($this->nanoidLength[0], $this->nanoidLength[1]);
        }

        return $this->nanoidLength;
    }

    /**
     * Generate a nanoid.
     */
    public function generateNanoid($length): string
    {
        $client = new Client();

        return $this->nanoidPrefix . $client->generateId($length, Client::MODE_DYNAMIC);
    }
}
