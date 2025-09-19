<?php

namespace App\Helpers;

class ArabicSearchHelper
{
    /**
     * Normalize Arabic text for better search results
     * Removes diacritics and normalizes common Arabic characters
     */
    public static function normalizeArabicText(string $text): string
    {
        // Remove Arabic diacritics (تشكيل) using actual Unicode characters
        $diacritics = [
            'ً', // فتحتان (Fathatan) U+064B
            'ٌ', // ضمتان (Dammatan) U+064C
            'ٍ', // كسرتان (Kasratan) U+064D
            'َ', // فتحة (Fatha) U+064E
            'ُ', // ضمة (Damma) U+064F
            'ِ', // كسرة (Kasra) U+0650
            'ّ', // شدة (Shadda) U+0651
            'ْ', // سكون (Sukun) U+0652
            'ٓ', // مدة (Maddah) U+0653
            'ٔ', // همزة علوية (Hamza above) U+0654
            'ٕ', // همزة سفلية (Hamza below) U+0655
            'ٖ', // سكون منصوب (Subscript Alef) U+0656
            'ٗ', // إعراب (Inverted Damma) U+0657
            '٘ ', // نون (Mark Noon Ghunna) U+0658
            'ٙ', // زور (Zwarakay) U+0659
            'ٚ', // ترقيق (Vowel Sign Small V Above) U+065A
            'ٛ', // تفخيم (Vowel Sign Inverted Small V Above) U+065B
            'ٜ', // مصوت (Vowel Sign Dot Below) U+065C
            'ٝ', // معكوس (Reversed Damma) U+065D
            'ٞ', // فتحة مقلوبة (Fatha With Two Dots) U+065E
            'ٟ', // واو صغيرة (Wavy Hamza Below) U+065F
            'ٰ', // ألف صغيرة (Superscript Alef) U+0670
        ];

        // Remove all diacritics
        $text = str_replace($diacritics, '', $text);

        // Normalize common Arabic characters
        $replacements = [
            // Normalize Alef variations
            'أ' => 'ا', // Alef with Hamza above
            'إ' => 'ا', // Alef with Hamza below
            'آ' => 'ا', // Alef with Madda above
            'ٱ' => 'ا', // Alef Wasla

            // Normalize Yeh variations
            'ي' => 'ى', // Yeh
            'ى' => 'ي', // Alef Maksura - bidirectional normalization
            'ئ' => 'ي', // Yeh with Hamza above

            // Normalize Teh variations
            'ة' => 'ه', // Teh Marbuta
            'ه' => 'ة', // Heh - bidirectional normalization

            // Remove standalone Hamza
            'ء' => '', // Remove standalone Hamza
        ];

        // Apply all replacements
        $text = str_replace(array_keys($replacements), array_values($replacements), $text);

        // Trim whitespace
        return trim($text);
    }

    /**
     * Create search query that handles Arabic text variations
     * Returns array of search terms to use in OR conditions
     */
    public static function createSearchTerms(string $searchTerm): array
    {
        $terms = [$searchTerm]; // Always include original term

        // First normalize the search term (remove diacritics)
        $normalized = self::normalizeArabicText($searchTerm);

        // Add normalized version if different
        if ($normalized !== $searchTerm) {
            $terms[] = $normalized;
        }

        // Create variations based on the normalized term (without diacritics)
        $baseForVariations = $normalized;
        $variations = [];

        // Handle Alef variations at the beginning of words using mb_substr
        if (mb_substr($baseForVariations, 0, 1) === 'ا') {
            $variations[] = 'أ'.mb_substr($baseForVariations, 1);
            $variations[] = 'إ'.mb_substr($baseForVariations, 1);
        }
        if (mb_substr($baseForVariations, 0, 1) === 'أ') {
            $variations[] = 'ا'.mb_substr($baseForVariations, 1);
            $variations[] = 'إ'.mb_substr($baseForVariations, 1);
        }
        if (mb_substr($baseForVariations, 0, 1) === 'إ') {
            $variations[] = 'ا'.mb_substr($baseForVariations, 1);
            $variations[] = 'أ'.mb_substr($baseForVariations, 1);
        }

        // Handle Yeh/Alef Maksura variations at the end
        if (mb_substr($baseForVariations, -1) === 'ي') {
            $variations[] = mb_substr($baseForVariations, 0, -1).'ى';
        }
        if (mb_substr($baseForVariations, -1) === 'ى') {
            $variations[] = mb_substr($baseForVariations, 0, -1).'ي';
        }

        // Handle Teh Marbuta variations at the end
        if (mb_substr($baseForVariations, -1) === 'ة') {
            $variations[] = mb_substr($baseForVariations, 0, -1).'ه';
        }
        if (mb_substr($baseForVariations, -1) === 'ه') {
            $variations[] = mb_substr($baseForVariations, 0, -1).'ة';
        }

        // Add unique variations
        foreach ($variations as $variation) {
            if (! in_array($variation, $terms)) {
                $terms[] = $variation;
            }
        }

        return array_unique($terms);
    }
}
