<?php

namespace App\Projectors;

use App\Models\Link;
use App\Models\LinkType;
use App\Models\Team;
use App\Models\User;
use App\StorableEvents\LinkCreated;
use App\StorableEvents\LinkDeleted;
use App\StorableEvents\LinkUpdated;
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
            'view' => $event->view,
            'icon' => $event->icon,
        ]);
    }

    public function onLinkUpdated(LinkUpdated $event)
    {
        $link = Link::where('uuid', $event->linkUuid)->first();

        $link->forceFill([
            'team_id' => (Team::where('uuid', $event->teamUuid)->first())->id ?? $link->team_id,
            'user_id' => (User::where('uuid', $event->userUuid)->first())->id ?? $link->user_id,
            'type' => $event->type,
            'target' => $event->target,
            'url' => $event->url,
            'title' => $event->title,
            'label' => $event->label,
            'role' => $event->role,
            'view' => $event->view,
            'icon' => $event->icon,
        ])->save();
    }

    public function onLinkDeleted(LinkDeleted $event)
    {
        $link = Link::where('uuid', $event->linkUuid)->first();
        $link->delete();
    }
}
