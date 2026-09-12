<?php

namespace Tests\Feature;

use App\Models\Experience;
use App\Models\User;
use Tests\TestCase;

class ExperienceReorderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Experience::query()->delete();
        User::query()->delete();
    }

    public function test_reorder_updates_sort_order(): void
    {
        $admin = User::factory()->create(['email' => 'admin@portfolio.local', 'password' => bcrypt('password'), 'is_admin' => true]);

        $a = Experience::create(['title' => 'A', 'period' => '2020', 'description' => 'desc A', 'sort_order' => 1]);
        $b = Experience::create(['title' => 'B', 'period' => '2021', 'description' => 'desc B', 'sort_order' => 2]);
        $c = Experience::create(['title' => 'C', 'period' => '2022', 'description' => 'desc C', 'sort_order' => 3]);

        $this->actingAs($admin);

        $this->post('/admin/experiences/reorder', [
            'order' => [$c->id, $a->id, $b->id],
        ], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson(['status' => 'ok']);

        $this->assertSame([$c->id, $a->id, $b->id], Experience::orderBy('sort_order')->pluck('id')->all());
        $this->assertSame([2, 3, 1], Experience::orderBy('id')->pluck('sort_order')->all());
    }

    public function test_index_page_renders_admin_experiences(): void
    {
        $admin = User::factory()->create(['email' => 'admin2@portfolio.local', 'password' => bcrypt('password'), 'is_admin' => true]);
        Experience::create(['title' => 'UI Designer', 'period' => '2023', 'description' => "Poin 1\nPoin 2", 'sort_order' => 1]);

        $this->actingAs($admin);
        $this->get('/admin/experiences')
            ->assertStatus(200)
            ->assertSee('UI Designer')
            ->assertSee('experienceList');
    }
}