<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class LinkCreated extends ShouldBeStored
{
    public function __construct(
        public string $linkUuid,
        public string $teamUuid,
        public string $role,
        public ?string $type = null,
        public ?string $target = null,
        public string $url,
        public ?string $title = null,
        public ?string $label = null,
    )
    {
    }
}
