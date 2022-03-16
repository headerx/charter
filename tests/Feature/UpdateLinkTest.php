<?php

namespace Tests\Feature;

use App\Http\Livewire\UpdateLinkForm;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_links_can_be_updated()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $link = Link::factory()->create([
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com',
        ]);

        Livewire::test(UpdateLinkForm::class, ['link' => $link])
                    ->set(['state' => array_merge($link->withoutRelations()->toArray(), [
                        'url' => 'https://example.com/updated',
                        'title' => 'Example Updated',
                        'label' => 'Example Updated',
                        'view' => 'navigation-menu',
                    ])])
                    ->call('updateLink');

        $this->assertDatabaseHas('links', [
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'url' => 'https://example.com/updated',
            'title' => 'Example Updated',
            'label' => 'Example Updated',
            'view' => 'navigation-menu',
        ]);
    }
}
