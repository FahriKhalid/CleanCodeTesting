<?php

namespace App\Domain\Shared\Traits;

use Illuminate\Http\Request;

trait FormRequestTrait
{
    public static function fromRequest(Request $request): self
    {
        $instance = new static();

        foreach ($request->all() as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }

        return $instance;
    }
}
