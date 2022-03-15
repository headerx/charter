<?php

namespace App\Aggregates;

use App\StorableEvents\LinkCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class LinkAggregate extends AggregateRoot
{
    public function createLink(
        string $teamUuid,
        string $url,
        ?string $role = null,
        ?string $userUuid = null,
        ?string $type = null,
        ?string $target = null,
        ?string $title = null,
        ?string $label = null,
        ?string $view = null
    ) {
        $this->recordThat(new LinkCreated(
            $this->uuid(),
            teamUuid:  $teamUuid,
            userUuid:  $userUuid,
            role:  $role,
            type:  $type,
            target:  $target,
            url:  $url,
            title:  $title,
            label:  $label,
            view:  $view,
        ));

        return $this;
    }
}
