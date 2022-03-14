<?php

namespace App\Projectors;

use App\Models\Link;
use App\Models\LinkType;
use App\Models\Team;
use App\Models\User;
use App\StorableEvents\LinkCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class LinkProjector extends Projector
{
    public function onLinkCreated(LinkCreated $event)
    {

        $teamId = (Team::where('uuid', $event->teamUuid)->first())->id ?? null;
        $userId = (User::where('uuid', $event->userUuid)->first())->id ?? null;

        Link::forceCreate([
            'uuid' => $event->linkUuid,
            'team_id' => $teamId,
            'user_id' => $userId,
            'type' => $event->type ?? LinkType::InternalLink->value,
            'target' => $event->target,
            'url' => $event->url,
            'title' => $event->title,
            'label' => $event->label,
            'role' => $event->role,
        ]);
    }
}
