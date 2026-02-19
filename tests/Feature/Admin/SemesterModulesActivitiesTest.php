<?php

use App\Models\Module;
use App\Models\Semester;
use App\Models\User;
use Carbon\Carbon;

function adminUser(): User
{
    return User::factory()->create([
        'user_type' => User::TYPE_ADMIN,
    ]);
}

test('admin can create a module with multiple activities', function () {
    Carbon::setTestNow('2026-01-01 09:00:00');
    $admin = adminUser();
    $semester = Semester::create([
        'name' => 'Spring 2026',
        'starts_at' => '2026-01-05',
        'ends_at' => '2026-03-29',
        'is_active' => true,
    ]);

    $payload = [
        'week_number' => 1,
        'title' => 'Week 1 Module',
        'description' => 'Intro module',
        'activities' => [
            [
                'title' => 'Kickoff call',
                'description' => 'Zoom session',
                'occurs_at' => '2026-01-06T10:00',
            ],
            [
                'title' => 'Reflection circle',
                'description' => '',
                'occurs_at' => '2026-01-08T18:00',
            ],
        ],
    ];

    $response = $this->actingAs($admin)->post(route('admin.semesters.modules.store', $semester), $payload);

    $response->assertRedirect(route('admin.semesters.modules.index', $semester));
    $this->assertDatabaseHas('modules', [
        'semester_id' => $semester->id,
        'week_number' => 1,
        'title' => 'Week 1 Module',
    ]);

    $module = Module::where('semester_id', $semester->id)->where('week_number', 1)->firstOrFail();
    expect($module->activities()->count())->toBe(2);
    $this->assertDatabaseHas('module_activities', [
        'module_id' => $module->id,
        'title' => 'Kickoff call',
        'occurs_at' => '2026-01-06 10:00:00',
        'sort_order' => 1,
    ]);
    $this->assertDatabaseHas('module_activities', [
        'module_id' => $module->id,
        'title' => 'Reflection circle',
        'occurs_at' => '2026-01-08 18:00:00',
        'sort_order' => 2,
    ]);
});

test('admin update replaces module activities', function () {
    Carbon::setTestNow('2026-01-01 09:00:00');
    $admin = adminUser();
    $semester = Semester::create([
        'name' => 'Spring 2026',
        'starts_at' => '2026-01-05',
        'ends_at' => '2026-03-29',
        'is_active' => true,
    ]);
    $module = Module::create([
        'semester_id' => $semester->id,
        'week_number' => 2,
        'title' => 'Week 2 Module',
        'description' => 'Original',
    ]);
    $module->activities()->createMany([
        [
            'title' => 'Old activity 1',
            'description' => null,
            'occurs_at' => '2026-01-14 09:00:00',
            'sort_order' => 1,
        ],
        [
            'title' => 'Old activity 2',
            'description' => null,
            'occurs_at' => '2026-01-15 09:00:00',
            'sort_order' => 2,
        ],
    ]);

    $response = $this->actingAs($admin)->put(route('admin.semesters.modules.update', [$semester, $module]), [
        'title' => 'Week 2 Module Updated',
        'description' => 'Updated',
        'activities' => [
            [
                'title' => 'New activity',
                'description' => 'Replacement',
                'occurs_at' => '2026-01-16T11:30',
            ],
        ],
    ]);

    $response->assertRedirect(route('admin.semesters.modules.index', $semester));

    $module->refresh();
    expect($module->activities()->count())->toBe(1);
    $this->assertDatabaseHas('module_activities', [
        'module_id' => $module->id,
        'title' => 'New activity',
        'occurs_at' => '2026-01-16 11:30:00',
        'sort_order' => 1,
    ]);
    $this->assertDatabaseMissing('module_activities', [
        'module_id' => $module->id,
        'title' => 'Old activity 1',
    ]);
});

test('admin cannot create a module activity outside selected week window', function () {
    Carbon::setTestNow('2026-01-01 09:00:00');
    $admin = adminUser();
    $semester = Semester::create([
        'name' => 'Spring 2026',
        'starts_at' => '2026-01-05',
        'ends_at' => '2026-03-29',
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->from(route('admin.semesters.modules.create', $semester))
        ->post(route('admin.semesters.modules.store', $semester), [
            'week_number' => 2,
            'title' => 'Week 2 Module',
            'description' => 'Test module',
            'activities' => [
                [
                    'title' => 'Too early activity',
                    'description' => 'Outside the selected week',
                    'occurs_at' => '2026-01-07T11:00',
                ],
            ],
        ]);

    $response->assertRedirect(route('admin.semesters.modules.create', $semester));
    $response->assertSessionHasErrors(['activities.0.occurs_at']);
    $this->assertDatabaseMissing('modules', [
        'semester_id' => $semester->id,
        'week_number' => 2,
        'title' => 'Week 2 Module',
    ]);
});
