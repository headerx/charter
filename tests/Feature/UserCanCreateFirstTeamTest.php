<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserCanCreateFirstTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_team_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test('teams.create-team-form')->set('state.name', 'First Team')->call('createTeam');

        $this->assertDatabaseHas('teams', [
            'name' => 'First Team',
        ]);

        $this->assertTrue(auth()->user()->isMemberOfATeam());
    }
}
