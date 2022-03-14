<?php

namespace App\Aggregates;

use App\StorableEvents\LinkCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class LinkAggregate extends AggregateRoot
{
    public function createLink(
        string $teamUuid,
        string $role,
        ?string $type = null,
        ?string $target = null,
        string $url,
        ?string $title = null,
        ?string $label = null,
    ) {
        $this->recordThat(new LinkCreated(
            $this->uuid(),
            $teamUuid,
            $role,
            $type,
            $target,
            $url,
            $title,
            $label,
        ));

        return $this;
    }
}
