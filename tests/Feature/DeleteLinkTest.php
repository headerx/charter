<?php

namespace Tests\Feature;

use App\Http\Livewire\DeleteModal;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_links_can_be_deleted()
    {
        // $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $link = Link::factory()->create([
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ]);

        Livewire::test(DeleteModal::class)
            ->call('showDeleteModal', 'App\\Contracts\\DeletesLink', 'App\\Models\\Link', $link->uuid)->call('destroy');

        $this->assertDatabaseMissing('links', [
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ]);
    }
}
