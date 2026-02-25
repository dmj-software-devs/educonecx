<?php
// app/Http/Controllers/TranslationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationController extends Controller
{
    // Simple phrase dictionary for common terms (fallback)
    private $phraseDictionary = [
        'en' => [
            'es' => [
                'Question' => 'Pregunta',
                'of' => 'de',
                'answered' => 'respondidas',
                'remaining' => 'restantes',
                'Submit Quiz' => 'Enviar Examen',
                'Next Question' => 'Siguiente Pregunta',
                'Previous' => 'Anterior',
                'Time Remaining:' => 'Tiempo Restante:',
                'Questions Answered:' => 'Preguntas Respondidas:',
                'Total Points:' => 'Puntos Totales:',
                'Passing Score:' => 'Puntuación Mínima:',
                'Attempt:' => 'Intento:',
                'Question Navigator' => 'Navegador de Preguntas',
                'Quiz Information' => 'Información del Examen',
                'Quiz Completed!' => '¡Examen Completado!',
                'You have answered all questions. Click below to submit your quiz.' => 'Has respondido todas las preguntas. Haz clic abajo para enviar tu examen.',
                'Type your answer here...' => 'Escribe tu respuesta aquí...',
                'Any of the correct answers will be accepted.' => 'Cualquier respuesta correcta será aceptada.',
                'Match the items from the left column with the right column' => 'Empareja los elementos de la columna izquierda con la columna derecha',
                'Select match' => 'Seleccionar emparejamiento',
                'points' => 'puntos',
            ],
            'fr' => [
                'Question' => 'Question',
                'of' => 'de',
                'answered' => 'répondues',
                'remaining' => 'restantes',
                'Submit Quiz' => 'Soumettre le Quiz',
                'Next Question' => 'Question Suivante',
                'Previous' => 'Précédent',
                'Time Remaining:' => 'Temps Restant:',
                'Questions Answered:' => 'Questions Répondues:',
                'Total Points:' => 'Points Totaux:',
                'Passing Score:' => 'Score de Réussite:',
                'Attempt:' => 'Tentative:',
                'Question Navigator' => 'Navigateur de Questions',
                'Quiz Information' => 'Informations du Quiz',
                'Quiz Completed!' => 'Quiz Terminé!',
                'You have answered all questions. Click below to submit your quiz.' => 'Vous avez répondu à toutes les questions. Cliquez ci-dessous pour soumettre votre quiz.',
                'Type your answer here...' => 'Tapez votre réponse ici...',
                'Any of the correct answers will be accepted.' => 'Toute réponse correcte sera acceptée.',
                'Match the items from the left column with the right column' => 'Faites correspondre les éléments de la colonne de gauche avec la colonne de droite',
                'Select match' => 'Sélectionner la correspondance',
                'points' => 'points',
            ]
        ]
    ];

    public function translate(Request $request)
    {
        $request->validate([
            'q' => 'required|string',
            'source' => 'required|string|in:en,es,fr',
            'target' => 'required|string|in:en,es,fr',
        ]);

        $text = $request->q;
        $source = $request->source;
        $target = $request->target;

        // If source and target are the same, return original
        if ($source === $target) {
            return response()->json(['translatedText' => $text]);
        }

        // Check if it's a simple phrase we have in our dictionary
        if ($source === 'en' && isset($this->phraseDictionary['en'][$target][$text])) {
            return response()->json(['translatedText' => $this->phraseDictionary['en'][$target][$text]]);
        }

        // Try LibreTranslate first
        try {
            Log::info('Attempting LibreTranslate translation', ['text' => $text, 'source' => $source, 'target' => $target]);
            
            $response = Http::timeout(5)->post('https://libretranslate.de/translate', [
                'q' => $text,
                'source' => $source,
                'target' => $target,
                'format' => 'text'
            ]);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('LibreTranslate success', ['result' => $result]);
                return response()->json($result);
            }

            Log::warning('LibreTranslate failed', ['status' => $response->status(), 'body' => $response->body()]);
            
        } catch (\Exception $e) {
            Log::error('LibreTranslate exception', ['error' => $e->getMessage()]);
        }

        // Try Google Translate as fallback (using a public proxy)
        try {
            Log::info('Attempting Google Translate fallback');
            
            $googleResponse = Http::timeout(5)->get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => $source,
                'tl' => $target,
                'dt' => 't',
                'q' => $text
            ]);

            if ($googleResponse->successful()) {
                $data = $googleResponse->json();
                if (isset($data[0][0][0])) {
                    $translated = $data[0][0][0];
                    Log::info('Google Translate success', ['translated' => $translated]);
                    return response()->json(['translatedText' => $translated]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Google Translate exception', ['error' => $e->getMessage()]);
        }

        // If all else fails, return original text
        Log::warning('All translation methods failed, returning original text');
        return response()->json(['translatedText' => $text]);
    }
}