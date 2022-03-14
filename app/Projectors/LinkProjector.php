<?php

namespace App\Projectors;

use App\Models\Link;
use App\Models\LinkType;
use App\Models\Team;
use App\StorableEvents\LinkCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class LinkProjector extends Projector
{
    public function onLinkCreated(LinkCreated $event)
    {
        $teamId = null;

        $team = Team::whereUUid($event->teamUuid)->first();

        if ($team) {
            $teamId = $team->id;
        }

        Link::forceCreate([
            'uuid' => $event->linkUuid,
            'type' => isset($event->type) ? $event->type : LinkType::InternalLink->value,
            'target' => $event->target,
            'url' => $event->url,
            'title' => $event->title,
            'label' => $event->label,
            'team_id' => $teamId,
            'role' => $event->role,
        ]);
    }

}
