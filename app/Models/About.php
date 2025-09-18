<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class About extends Model
{
    /** @use HasFactory<\Database\Factories\AboutFactory> */
    use HasFactory, HasTranslations;

    public static bool $skipConstraints = false;

    public array $translatable = [
        'title',
        'content',
        'board_section_title',
        'board_section_description',
    ];

    protected $fillable = [
        'title',
        'content',
        'show_board_section',
        'board_section_title',
        'board_section_description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'show_board_section' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        // Prevent creating more than one About record
        static::creating(function ($about) {
            if (! static::$skipConstraints && static::count() > 0) {
                throw new \Exception('Only one About page is allowed. Please edit the existing one.');
            }
        });

        // Prevent deleting the About record if it's the only one
        static::deleting(function ($about) {
            if (! static::$skipConstraints && static::count() <= 1) {
                throw new \Exception('Cannot delete the About page. At least one About page must exist.');
            }
        });
    }

    /**
     * Scope to get only active about sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get about sections with board section enabled
     */
    public function scopeWithBoardSection($query)
    {
        return $query->where('show_board_section', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get the main active about page
     */
    public static function getMainAboutPage()
    {
        return static::active()->ordered()->first();
    }

    /**
     * Get or create the single About page instance
     */
    public static function getSingleInstance()
    {
        $about = static::first();

        if (! $about) {
            $about = static::create([
                'title' => [
                    'en' => 'About Us',
                    'ar' => 'معلومات عنا',
                ],
                'content' => [
                    'en' => '<p>Welcome to our organization.</p>',
                    'ar' => '<p>مرحباً بكم في منظمتنا.</p>',
                ],
                'show_board_section' => false,
                'is_active' => true,
                'sort_order' => 1,
            ]);
        }

        return $about;
    }

    /**
     * Get translatable attributes for Filament
     */
    public function getTranslatableAttributes(): array
    {
        return $this->translatable;
    }
}
