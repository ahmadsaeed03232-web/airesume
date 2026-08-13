<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory, HasUuids;

    /**
     * Supported template styles and their user-friendly labels.
     *
     * @var array<string, string>
     */
    public static array $templates = [
        'modern' => 'Impact Modern',
        'classic' => 'Classic Executive',
        'minimal' => 'Minimalist Tech',
        'slate' => 'Professional Slate',
        'creative' => 'Creative Teal',
        'emerald' => 'Emerald Professional',
        'royal' => 'Royal Executive',
        'border' => 'Minimalist Border',
        'warm' => 'Warm Editorial',
        'ruby' => 'Ruby Elite',
        'sidebar' => 'Modern Sidebar',
        'double' => 'Double Column',
        'corporate' => 'Compact Corporate',
        'charcoal' => 'Elegant Charcoal',
        'startup' => 'Tech Startup',
        'bold' => 'Bold Header',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_info' => 'array',
            'experience' => 'array',
            'education' => 'array',
            'projects' => 'array',
            'skills' => 'array',
            'section_order' => 'array',
            'hidden_sections' => 'array',
        ];
    }

    /**
     * Get the user that owns the resume.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, $this>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
