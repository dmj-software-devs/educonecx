<?php

namespace Database\Seeders;

use App\Models\AcademyCategory;
use App\Models\AcademyScenario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EduconecxAcademySeeder extends Seeder
{
    public function run(): void
    {
        $scenarios = [
            ['title' => 'At the Restaurant', 'level' => 'Beginner', 'description' => 'Ordering food and interacting with restaurant staff.', 'practice_text' => 'You are at a restaurant and need to order a meal, ask for recommendations, and request the bill politely.', 'avatar_instructions' => 'Focus on practical ordering phrases and polite expressions.', 'sample_questions' => ['What would you like to drink?', 'Would you like to see today\'s specials?', 'How would you ask for the bill politely?']],
            ['title' => 'Traveling', 'level' => 'Intermediate', 'description' => 'Handling travel communication at airports and hotels.', 'practice_text' => 'You are traveling abroad. Practice check-in, asking directions, and solving simple travel problems.', 'avatar_instructions' => 'Encourage clear travel-related vocabulary and confidence.', 'sample_questions' => ['Can you show me your passport?', 'How do I get to the city center?', 'Can I change my reservation?']],
            ['title' => 'Self Introduction', 'level' => 'Beginner', 'description' => 'Introducing yourself in social and professional settings.', 'practice_text' => 'Introduce your name, background, hobbies, and goals in clear English.', 'avatar_instructions' => 'Help learner produce fluent short introduction.', 'sample_questions' => ['Can you introduce yourself?', 'What are your hobbies?', 'What is one goal you have this year?']],
            ['title' => 'Job Interview', 'level' => 'Advanced', 'description' => 'Practicing common interview questions and answers.', 'practice_text' => 'You are in a job interview. Respond confidently about your experience, skills, and motivation.', 'avatar_instructions' => 'Ask one interview question at a time and provide constructive correction.', 'sample_questions' => ['Tell me about yourself.', 'Why do you want this position?', 'What are your strengths?']],
            ['title' => 'Customer Service', 'level' => 'Intermediate', 'description' => 'Helping customers and resolving issues politely.', 'practice_text' => 'You are a customer service representative. Greet customers, understand problems, and offer solutions.', 'avatar_instructions' => 'Promote polite and solution-oriented communication.', 'sample_questions' => ['How can I help you today?', 'Can you describe the issue?', 'What solution can you offer?']],
            ['title' => 'Daily Conversation', 'level' => 'Beginner', 'description' => 'Simple everyday small talk and interaction.', 'practice_text' => 'Practice talking about weather, routine, plans, and preferences in everyday English.', 'avatar_instructions' => 'Keep conversation natural and beginner-friendly.', 'sample_questions' => ['How was your day?', 'What do you usually do in the morning?', 'What are your plans for the weekend?']],
            ['title' => 'Beginner English', 'level' => 'Beginner', 'description' => 'Basic sentence building and essential expressions.', 'practice_text' => 'Practice basic grammar and useful phrases for greetings, requests, and simple responses.', 'avatar_instructions' => 'Keep pace slow, clear, and supportive for new learners.', 'sample_questions' => ['How do you greet someone politely?', 'Can you make a simple present tense sentence?', 'How do you ask for help in English?']],
        ];

        foreach ($scenarios as $index => $scenarioData) {
            $category = AcademyCategory::updateOrCreate(
                ['slug' => Str::slug($scenarioData['title'])],
                [
                    'title' => $scenarioData['title'],
                    'description' => $scenarioData['description'],
                    'level' => $scenarioData['level'],
                    'status' => 'active',
                    'sort_order' => $index + 1,
                ]
            );

            AcademyScenario::updateOrCreate(
                ['slug' => Str::slug($scenarioData['title']) . '-scenario'],
                [
                    'academy_category_id' => $category->id,
                    'title' => $scenarioData['title'] . ' Practice',
                    'level' => $scenarioData['level'],
                    'description' => $scenarioData['description'],
                    'practice_text' => $scenarioData['practice_text'],
                    'avatar_instructions' => $scenarioData['avatar_instructions'],
                    'sample_questions' => $scenarioData['sample_questions'],
                    'status' => 'active',
                    'sort_order' => 1,
                ]
            );
        }
    }
}
