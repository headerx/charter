<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalLink extends Link
{
    use HasFactory;
    use HasParent;

    public function url() : Attribute
    {
        return new Attribute(

            get: fn($value, $attributes) => '/'.$attributes['url'],
        );
    }
}
