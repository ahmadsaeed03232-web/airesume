<?php

use App\Services\GeminiService;

test('it initializes in fallback mode when api key is missing', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    expect($service->isFallback())->toBeTrue();
});

test('it generates realistic fallback summaries based on profile types', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    $studentSummary = $service->generateSummary('Software Developer', 'student', ['PHP', 'Laravel'], []);
    expect($studentSummary)->toContain('student specializing in Software Developer')
        ->toContain('PHP, Laravel');

    $gradSummary = $service->generateSummary('Frontend Engineer', 'fresh_graduate', ['React', 'CSS'], []);
    expect($gradSummary)->toContain('Recent graduate')
        ->toContain('React, CSS');

    $changerSummary = $service->generateSummary('Data Analyst', 'career_changer', ['SQL', 'Python'], [['position' => 'Sales Lead', 'company' => 'Target']]);
    expect($changerSummary)->toContain('transitioning into Data Analyst')
        ->toContain('Sales Lead at Target');
});

test('it polishes experience bullet points in fallback mode', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    $codeBullet = $service->improveBulletPoint('I wrote some code for the landing page', 'Frontend Developer', 'student');
    expect($codeBullet)->toContain('Spearheaded development and deployment');

    $dbBullet = $service->improveBulletPoint('worked on the sql database optimization', 'Backend Developer', 'fresh_graduate');
    expect($dbBullet)->toContain('Designed and optimized database schemas');

    $bugBullet = $service->improveBulletPoint('fixed various bugs in the checkout page', 'Full Stack Developer', 'job_seeker');
    expect($bugBullet)->toContain('Identified and resolved critical system performance');
});

test('it translates previous accomplishments for career changers', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    $translation = $service->translateCareerChange('Store Manager', 'Developer', 'Managed a team of 5, set schedules, and solved cashier issues.');
    expect($translation)->toContain('Store Manager')
        ->toContain('Developer')
        ->toContain('cross-functional communication')
        ->toContain('workflow bottlenecks');
});

test('it performs ATS analysis against job descriptions', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    $resumeData = [
        'target_role' => 'Laravel Developer',
        'skills' => [
            'technical' => 'PHP, Laravel, SQLite',
        ],
    ];

    $jobDescription = 'We need a Laravel developer who knows Vue.js, Tailwind CSS, Docker, and SQL databases.';
    $result = $service->analyzeAts($resumeData, $jobDescription);

    expect($result)->toBeArray()
        ->toHaveKeys(['score', 'missing_keywords', 'strengths', 'recommendations']);

    expect($result['score'])->toBeGreaterThanOrEqual(40)
        ->toBeLessThanOrEqual(95);

    expect($result['missing_keywords'])->toContain('Vue.js')
        ->toContain('Docker');
});

test('it generates fallback suggestions with correct structure', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    $result = $service->generateSuggestions('Laravel Developer', 'fresh_graduate');

    expect($result)->toBeArray()
        ->toHaveKeys(['technical_skills', 'soft_skills', 'tools', 'experience_bullets', 'projects']);

    expect($result['technical_skills'])->toBeArray()->not->toBeEmpty();
    expect($result['soft_skills'])->toBeArray()->not->toBeEmpty();
    expect($result['tools'])->toBeArray()->not->toBeEmpty();
    expect($result['experience_bullets'])->toBeArray()->not->toBeEmpty();
    expect($result['projects'])->toBeArray()->not->toBeEmpty();
});

test('it returns role-aware suggestions in fallback mode', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    $frontendResult = $service->generateSuggestions('React Frontend Developer', 'student');
    expect($frontendResult['technical_skills'])->toContain('React');

    $dataResult = $service->generateSuggestions('Data Analyst Python', 'job_seeker');
    expect($dataResult['technical_skills'])->toContain('Python');

    $devopsResult = $service->generateSuggestions('DevOps Cloud AWS Engineer', 'career_changer');
    expect($devopsResult['technical_skills'])->toContain('AWS');
});

test('it returns profile-aware soft skills in fallback suggestions', function () {
    config(['services.gemini.key' => null]);
    $service = new GeminiService();

    $studentSuggestions = $service->generateSuggestions('Developer', 'student');
    expect($studentSuggestions['soft_skills'])->toContain('Analytical Thinking');

    $changerSuggestions = $service->generateSuggestions('Developer', 'career_changer');
    expect($changerSuggestions['soft_skills'])->toContain('Cross-functional Leadership');
});
