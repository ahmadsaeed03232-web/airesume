<?php

use App\Models\Resume;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it initializes with a default section order', function () {
    $payload = [
        'title' => 'Software Engineer Resume',
        'target_profile' => 'fresh_graduate',
        'target_role' => 'Junior Web Dev',
        'template_style' => 'minimal',
    ];

    $response = $this->post(route('resumes.store'), $payload);

    $resume = Resume::where('title', 'Software Engineer Resume')->first();
    expect($resume->section_order)->toBe(['summary', 'experience', 'projects', 'education', 'skills']);
});

test('it can update/autosave section_order', function () {
    $resume = Resume::create([
        'title' => 'Original Resume',
        'target_profile' => 'student',
        'section_order' => ['summary', 'experience', 'projects', 'education', 'skills'],
    ]);

    $newOrder = ['education', 'experience', 'summary', 'projects', 'skills'];

    $response = $this->putJson(route('resumes.update', $resume->id), [
        'section_order' => $newOrder,
    ]);

    $response->assertSuccessful();

    $resume->refresh();
    expect($resume->section_order)->toBe($newOrder);
});
