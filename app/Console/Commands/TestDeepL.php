<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DeepLService;

class TestDeepL extends Command
{
    protected $signature = 'deepl:test {text? : Text to translate}';
    protected $description = 'Test DeepL translation service';

    public function handle(DeepLService $deepL)
    {
        $text = $this->argument('text') ?? 'Hello, how are you?';
        
        $this->info('Testing DeepL translation...');
        $this->line('Original: ' . $text);
        
        // Test Spanish
        $translated = $deepL->translate($text, 'en', 'es');
        $this->line('Spanish: ' . $translated);
        
        // Test French
        $translated = $deepL->translate($text, 'en', 'fr');
        $this->line('French: ' . $translated);
        
        // Test German
        $translated = $deepL->translate($text, 'en', 'de');
        $this->line('German: ' . $translated);
        
        // Get usage
        $usage = $deepL->getUsage();
        if ($usage) {
            $this->newLine();
            $this->info('API Usage:');
            $this->line('Characters used: ' . number_format($usage['character_count']));
            $this->line('Characters limit: ' . number_format($usage['character_limit']));
            $this->line('Percentage: ' . number_format($usage['percentage_used'], 2) . '%');
        }
        
        return Command::SUCCESS;
    }
}