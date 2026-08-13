<?php

use App\Models\Resume;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it lists resumes on the dashboard index page', function () {
    $resume = Resume::create([
        'title' => 'Jane Doe Portfolio',
        'target_profile' => 'student',
        'target_role' => 'Data Scientist',
    ]);

    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Jane Doe Portfolio');
    $response->assertSee('Data Scientist');
});

test('it can create a new resume with dynamic profiles', function () {
    $payload = [
        'title' => 'Software Engineer Resume',
        'target_profile' => 'fresh_graduate',
        'target_role' => 'Junior Web Dev',
        'template_style' => 'minimal',
    ];

    $response = $this->post(route('resumes.store'), $payload);

    $this->assertDatabaseHas('resumes', [
        'title' => 'Software Engineer Resume',
        'target_profile' => 'fresh_graduate',
        'template_style' => 'minimal',
    ]);

    $resume = Resume::where('title', 'Software Engineer Resume')->first();

    $response->assertRedirect(route('resumes.show', $resume->id));
});

test('it can show the resume builder workspace', function () {
    $resume = Resume::create([
        'title' => 'Marketing Specialist Draft',
        'target_profile' => 'job_seeker',
    ]);

    $response = $this->get(route('resumes.show', $resume->id));

    $response->assertSuccessful();
    $response->assertSee('Marketing Specialist Draft');
    $response->assertSee('ATS Match Check');
});

test('it can update/autosave resume data via AJAX', function () {
    $resume = Resume::create([
        'title' => 'Original Title',
        'target_profile' => 'student',
        'personal_info' => ['name' => 'Original Name'],
    ]);

    $payload = [
        'title' => 'Autosaved Title',
        'personal_info' => ['name' => 'John Doe', 'email' => 'john@example.com'],
        'summary' => 'This is my new summary.',
        'skills' => ['technical' => 'PHP, JS'],
    ];

    $response = $this->putJson(route('resumes.update', $resume->id), $payload);

    $response->assertSuccessful();
    $response->assertJsonPath('success', true);

    $resume->refresh();
    expect($resume->title)->toBe('Autosaved Title');
    expect($resume->personal_info['name'])->toBe('John Doe');
    expect($resume->personal_info['email'])->toBe('john@example.com');
    expect($resume->summary)->toBe('This is my new summary.');
    expect($resume->skills['technical'])->toBe('PHP, JS');
});

test('it can delete a resume', function () {
    $resume = Resume::create([
        'title' => 'To Be Deleted',
        'target_profile' => 'student',
    ]);

    $response = $this->delete(route('resumes.destroy', $resume->id));

    $response->assertRedirect(route('resumes.index'));
    $this->assertDatabaseMissing('resumes', ['id' => $resume->id]);
});

test('it exposes AI summary generation endpoint', function () {
    $resume = Resume::create([
        'title' => 'Resume for AI Summary',
        'target_profile' => 'student',
    ]);

    $payload = [
        'target_role' => 'QA Engineer',
        'target_profile' => 'student',
        'skills' => ['PHPUnit', 'Pest'],
    ];

    $response = $this->postJson(route('resumes.ai.summary', $resume->id), $payload);

    $response->assertSuccessful();
    $response->assertJsonStructure(['summary']);
    
    $data = $response->json();
    expect($data['summary'])->toContain('QA Engineer');
});

test('it exposes AI bullet point polishing endpoint', function () {
    $resume = Resume::create([
        'title' => 'Resume for AI Bullet',
        'target_profile' => 'fresh_graduate',
    ]);

    $payload = [
        'bullet' => 'I optimization sql select queries',
        'target_role' => 'Database Admin',
        'target_profile' => 'fresh_graduate',
    ];

    $response = $this->postJson(route('resumes.ai.improve-bullet', $resume->id), $payload);

    $response->assertSuccessful();
    $response->assertJsonStructure(['improved']);
    
    $data = $response->json();
    expect($data['improved'])->toContain('database schemas');
});

test('it exposes AI career translation endpoint', function () {
    $resume = Resume::create([
        'title' => 'Resume for Career Change',
        'target_profile' => 'career_changer',
    ]);

    $payload = [
        'previous_role' => 'Sales Associate',
        'target_role' => 'Web Developer',
        'experience_description' => 'I worked at cash register and helped customers fix register problems.',
    ];

    $response = $this->postJson(route('resumes.ai.career-translate', $resume->id), $payload);

    $response->assertSuccessful();
    $response->assertJsonStructure(['translated']);
});

test('it exposes AI ATS compatibility review endpoint', function () {
    $resume = Resume::create([
        'title' => 'Resume for ATS',
        'target_profile' => 'job_seeker',
        'skills' => ['technical' => 'PHP, Laravel'],
    ]);

    $payload = [
        'job_description' => 'Looking for a Laravel engineer who knows Vue.js.',
    ];

    $response = $this->postJson(route('resumes.ai.ats-analyze', $resume->id), $payload);

    $response->assertSuccessful();
    $response->assertJsonStructure(['score', 'missing_keywords', 'strengths', 'recommendations']);
});

test('it exposes AI content suggestions endpoint with correct structure', function () {
    $resume = Resume::create([
        'title' => 'Resume for AI Suggestions',
        'target_profile' => 'fresh_graduate',
        'target_role' => 'Laravel Developer',
    ]);

    $payload = [
        'target_role' => 'Laravel Developer',
        'target_profile' => 'fresh_graduate',
    ];

    $response = $this->postJson(route('resumes.ai.suggestions', $resume->id), $payload);

    $response->assertSuccessful();
    $response->assertJsonStructure([
        'technical_skills',
        'soft_skills',
        'tools',
        'experience_bullets',
        'projects',
    ]);

    $data = $response->json();
    expect($data['technical_skills'])->toBeArray()->not->toBeEmpty();
    expect($data['experience_bullets'])->toBeArray()->not->toBeEmpty();
    expect($data['projects'])->toBeArray()->not->toBeEmpty();
});

test('it validates required fields on the suggestions endpoint', function () {
    $resume = Resume::create([
        'title' => 'Resume for Validation',
        'target_profile' => 'student',
    ]);

    $response = $this->postJson(route('resumes.ai.suggestions', $resume->id), []);

    $response->assertUnprocessable();
    $response->assertJsonStructure(['errors' => ['target_role', 'target_profile']]);
});
