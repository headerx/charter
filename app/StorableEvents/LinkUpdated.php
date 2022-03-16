<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class LinkUpdated extends ShouldBeStored
{
    public function __construct()
    {
    }
}
