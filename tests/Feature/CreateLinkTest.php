<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateLinkForm;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_links_can_be_created()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(CreateLinkForm::class)
                    ->set(['state' => [
                        'teamUuid' => $user->currentTeam->uuid,
                        'role' => 'admin',
                        'type' => 'internal_link',
                        'target' => '_self',
                        'url' => 'https://example.com',
                        'title' => 'Example',
                        'label' => 'Example',
                        ]])
                    ->call('createLink');

        $this->assertCount(1, Link::all());
        $this->assertDatabaseHas('links', [
            'team_id' => $user->currentTeam->id,
            'user_id' => $user->id,
            'target' => '_self',
            'url' => 'https://example.com',
            'title' => 'Example',
            'label' => 'Example',
        ]);
    }

    public function test_creating_link_requires_validation()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(CreateLinkForm::class)
                    ->set(['state' => [
                        'teamUuid' => $user->currentTeam->uuid,
                        'role' => 'admin',
                        'type' => 'internal_link',
                        'target' => '_self',
                        'url' => '',
                        'title' => '',
                        'label' => '',
                        ]])
                    ->call('createLink')
                    ->assertHasErrors(['url']);

        $this->assertDatabaseMissing('links', [
            'target' => '_self',
            'url' => '',
            'title' => '',
            'label' => '',
        ]);
    }

    public function test_null_link_type_will_create_internal_link()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        Livewire::test(CreateLinkForm::class)
                    ->set(['state' => [
                        'teamUuid' => $user->currentTeam->uuid,
                        'role' => 'admin',
                        'type' => null,
                        'target' => '_self',
                        'url' => 'https://example.com',
                        'title' => 'Example',
                        'label' => 'Example',
                        ]])
                    ->call('createLink');

        $this->assertDatabaseHas('links', [
            'target' => '_self',
            'type' => 'internal_link',
            'url' => 'https://example.com',
            'title' => 'Example',
            'label' => 'Example',
        ]);
    }
}
