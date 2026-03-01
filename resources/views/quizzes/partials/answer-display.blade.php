@php
$question = $question ?? null;
$answerData = $answerData ?? null;
$type = $type ?? 'user'; // 'user' or 'correct'
@endphp

@if(!$question)
    <span>No question data</span>
    
@elseif(in_array($question->question_type, ['single_choice', 'multiple_choice', 'true_false']))
    <div style="display: flex; flex-direction: column; gap: 10px;">
        @foreach($question->options as $option)
            @php
            // Check if this option is correct
            $isCorrectOption = $option->is_correct;
            
            // Check if user selected this option
            $userSelected = false;
            if ($type === 'user' && $answerData) {
                if (is_array($answerData)) {
                    $userSelected = in_array($option->id, $answerData);
                } else {
                    $userSelected = $option->id == $answerData;
                }
            }
            
            // Determine styling
            $bgColor = '';
            $borderColor = '';
            $icon = '';
            
            if ($type === 'user') {
                if ($userSelected && $isCorrectOption) {
                    // User correctly selected this option
                    $bgColor = 'rgba(6, 214, 160, 0.1)';
                    $borderColor = '#06d6a0';
                    $icon = '<i class="fas fa-check-circle" style="color: #06d6a0; margin-right: 8px;"></i>';
                } elseif ($userSelected && !$isCorrectOption) {
                    // User incorrectly selected this option
                    $bgColor = 'rgba(239, 71, 111, 0.1)';
                    $borderColor = '#ef476f';
                    $icon = '<i class="fas fa-times-circle" style="color: #ef476f; margin-right: 8px;"></i>';
                } elseif (!$userSelected && $isCorrectOption) {
                    // User missed this correct option
                    $bgColor = 'rgba(255, 209, 102, 0.1)';
                    $borderColor = '#ffd166';
                    $icon = '<i class="fas fa-exclamation-circle" style="color: #ffd166; margin-right: 8px;"></i>';
                }
            }
            @endphp
            
            <div style="display: flex; align-items: center; padding: 12px 15px; background: {{ $bgColor }}; border: 1px solid {{ $borderColor ?: 'rgba(0,0,0,0.05)' }}; border-radius: 12px; {{ $borderColor ? 'border-width: 2px;' : '' }} class="rs-option-item">
                {!! $icon !!}
                
                <div style="flex: 1;">
                    <span style="font-weight: {{ ($type === 'user' && $userSelected) || $isCorrectOption ? '600' : '400' }};">
                        {{ $option->option_text }}
                    </span>
                    
                    @if($isCorrectOption)
                        <span class="rs-badge rs-badge-correct">
                            CORRECT
                        </span>
                    @endif
                    
                    @if($type === 'user' && $userSelected)
                        <span class="rs-badge {{ $isCorrectOption ? 'rs-badge-correct' : 'rs-badge-incorrect' }}">
                            YOUR ANSWER
                        </span>
                    @endif
                </div>
                
                @if($isCorrectOption)
                    <i class="fas fa-check" style="color: #06d6a0; margin-left: 10px;"></i>
                @endif
            </div>
        @endforeach
    </div>
    
@elseif($question->question_type === 'image_selection')
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;">
        @foreach($question->options as $option)
            @php
            // Check if this option is correct
            $isCorrectOption = $option->is_correct;
            
            // Check if user selected this option
            $userSelected = false;
            if ($type === 'user' && $answerData) {
                if (is_array($answerData)) {
                    $userSelected = in_array($option->id, $answerData);
                } else {
                    $userSelected = $option->id == $answerData;
                }
            }
            
            // Determine styling
            $borderColor = 'rgba(0,0,0,0.1)';
            $borderWidth = '2px';
            $overlay = '';
            
            if ($type === 'user') {
                if ($userSelected && $isCorrectOption) {
                    // User correctly selected this option
                    $borderColor = '#06d6a0';
                    $overlay = '<div style="position: absolute; top: 10px; right: 10px; background: #06d6a0; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-check" style="font-size: 0.8rem;"></i></div>';
                } elseif ($userSelected && !$isCorrectOption) {
                    // User incorrectly selected this option
                    $borderColor = '#ef476f';
                    $overlay = '<div style="position: absolute; top: 10px; right: 10px; background: #ef476f; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-times" style="font-size: 0.8rem;"></i></div>';
                } elseif (!$userSelected && $isCorrectOption) {
                    // User missed this correct option
                    $borderColor = '#ffd166';
                    $overlay = '<div style="position: absolute; top: 10px; right: 10px; background: #ffd166; color: white; width: 25px; height: 25px; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-exclamation" style="font-size: 0.8rem;"></i></div>';
                }
            }
            @endphp
            
            <div style="position: relative; border: {{ $borderWidth }} solid {{ $borderColor }}; border-radius: 12px; overflow: hidden; background: white; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                @if($option->image)
                    <img src="{{ Storage::url($option->image) }}" alt="Option" style="width: 100%; height: 120px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 120px; background: #f0f3ff; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                    </div>
                @endif
                
                {!! $overlay !!}
                
                <div style="padding: 10px; text-align: center;">
                    <div style="font-size: 0.9rem; font-weight: 500; margin-bottom: 5px;">{{ $option->option_text ?: 'Option' }}</div>
                    
                    @if($isCorrectOption)
                        <span class="rs-badge rs-badge-correct" style="display: inline-block; margin: 0 auto;">
                            CORRECT
                        </span>
                    @endif
                    
                    @if($type === 'user' && $userSelected)
                        <span class="rs-badge {{ $isCorrectOption ? 'rs-badge-correct' : 'rs-badge-incorrect' }}" style="display: inline-block; margin: 5px auto 0;">
                            YOUR ANSWER
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
@elseif($question->question_type === 'fill_blank')
    <div style="background: #f8f9fa; padding: 20px; border-radius: 16px;">
        @php
        // Get fill blanks data
        $fillBlanks = $question->fillBlanks ?? collect();
        $hasFillBlanks = $fillBlanks->count() > 0;
        
        // Get correct answers (using correct_answer field from FillBlank model)
        $correctAnswers = $hasFillBlanks ? $fillBlanks->pluck('correct_answer')->toArray() : [];
        
        // Get user answer
        $userAnswer = $answerData ?? '';
        
        // Check if user answer is correct using the model's validation method
        $isCorrect = false;
        if ($userAnswer && $hasFillBlanks) {
            $isCorrect = $question->validateFillBlank($userAnswer);
        }
        
        // Debug info (remove in production)
        $debug = [
            'fillBlanks_count' => $fillBlanks->count(),
            'correctAnswers' => $correctAnswers,
            'userAnswer' => $userAnswer,
            'isCorrect' => $isCorrect
        ];
        @endphp
        
        <!-- User's Answer Section -->
        <div style="margin-bottom: 25px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <div style="width: 36px; height: 36px; background: {{ $isCorrect ? '#06d6a0' : ($userAnswer ? '#ef476f' : '#ffd166') }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <i class="fas {{ $isCorrect ? 'fa-check' : ($userAnswer ? 'fa-times' : 'fa-minus') }}" style="color: white; font-size: 1rem;"></i>
                </div>
                <span style="font-weight: 600; color: #1e1e2f; font-size: 1.1rem;">Your Answer</span>
            </div>
            
            <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 6px solid {{ $isCorrect ? '#06d6a0' : ($userAnswer ? '#ef476f' : '#ffd166') }};">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 15px; flex: 1;">
                        <div style="font-size: 2rem; color: {{ $isCorrect ? '#06d6a0' : ($userAnswer ? '#ef476f' : '#ffd166') }};">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <div style="flex: 1;">
                            @if($userAnswer)
                                <div style="font-size: 1.3rem; font-weight: 500; color: #1e1e2f; margin-bottom: 5px; word-break: break-word;">
                                    "{{ $userAnswer }}"
                                </div>
                                <div style="font-size: 0.85rem; color: #6c757d;">
                                    Length: {{ strlen($userAnswer) }} characters
                                </div>
                            @else
                                <div style="font-size: 1.1rem; color: #6c757d; font-style: italic; padding: 10px 0;">
                                    <i class="fas fa-minus-circle"></i> No answer provided for this question
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($userAnswer)
                        <div>
                            @if($isCorrect)
                                <span style="background: rgba(6, 214, 160, 0.15); color: #06d6a0; padding: 8px 24px; border-radius: 30px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-check-circle"></i> Correct
                                </span>
                            @else
                                <span style="background: rgba(239, 71, 111, 0.15); color: #ef476f; padding: 8px 24px; border-radius: 30px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-times-circle"></i> Incorrect
                                </span>
                            @endif
                        </div>
                    @else
                        <div>
                            <span style="background: rgba(255, 209, 102, 0.15); color: #b85e00; padding: 8px 24px; border-radius: 30px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                                <i class="fas fa-minus-circle"></i> Not Answered
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Correct Answers Section -->
        <div style="margin-top: 25px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                <div style="width: 36px; height: 36px; background: #06d6a0; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <i class="fas fa-check" style="color: white; font-size: 1rem;"></i>
                </div>
                <span style="font-weight: 600; color: #1e1e2f; font-size: 1.1rem;">Correct Answer{{ $hasFillBlanks && count($correctAnswers) > 1 ? 's' : '' }}</span>
                @if($hasFillBlanks)
                    <span style="background: rgba(6, 214, 160, 0.1); color: #06d6a0; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                        {{ count($correctAnswers) }} possible answer{{ count($correctAnswers) > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>
            
            @if($hasFillBlanks)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
                    @foreach($fillBlanks as $index => $blank)
                        @php
                        $isUserAnswerMatch = $userAnswer && (
                            $blank->case_sensitive 
                                ? $blank->correct_answer === $userAnswer
                                : strtolower(trim($blank->correct_answer)) === strtolower(trim($userAnswer))
                        );
                        @endphp
                        <div style="background: white; border-radius: 16px; padding: 18px; border: 2px solid {{ $isUserAnswerMatch ? '#06d6a0' : 'rgba(6, 214, 160, 0.2)' }}; box-shadow: 0 4px 12px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: {{ $isUserAnswerMatch ? '#06d6a0' : 'rgba(6, 214, 160, 0.1)' }}; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check" style="color: {{ $isUserAnswerMatch ? 'white' : '#06d6a0' }}; font-size: 1.1rem;"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-size: 1.2rem; font-weight: 600; color: #1e1e2f; margin-bottom: 6px; word-break: break-word;">
                                        {{ $blank->correct_answer }}
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        @if($blank->case_sensitive)
                                            <span style="background: rgba(108, 117, 125, 0.1); padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; color: #6c757d; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-lock"></i> Case Sensitive
                                            </span>
                                        @else
                                            <span style="background: rgba(108, 117, 125, 0.1); padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; color: #6c757d; display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="fas fa-lock-open"></i> Case Insensitive
                                            </span>
                                        @endif
                                        
                                        @if($isUserAnswerMatch)
                                            <span style="background: rgba(6, 214, 160, 0.15); color: #06d6a0; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                                                Your match
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="background: white; border-radius: 16px; padding: 30px; text-align: center; border: 2px dashed rgba(239, 71, 111, 0.3);">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; color: #ef476f; margin-bottom: 15px;"></i>
                    <div style="color: #6c757d; font-size: 1rem;">No correct answers have been defined for this fill in the blank question.</div>
                    <div style="color: #6c757d; font-size: 0.9rem; margin-top: 8px;">Please contact the administrator.</div>
                </div>
            @endif
        </div>
        
        <!-- Help Tip for Incorrect Answers -->
        @if($userAnswer && !$isCorrect && $hasFillBlanks)
            <div style="margin-top: 25px; padding: 20px; background: rgba(255, 209, 102, 0.1); border-radius: 16px; border-left: 6px solid #ffd166;">
                <div style="display: flex; align-items: flex-start; gap: 15px;">
                    <i class="fas fa-lightbulb" style="font-size: 2rem; color: #ffd166;"></i>
                    <div>
                        <div style="font-weight: 600; color: #b85e00; margin-bottom: 8px; font-size: 1.1rem;">Need Help?</div>
                        <div style="color: #6c757d; line-height: 1.6;">
                            Your answer <strong style="color: #ef476f;">"{{ $userAnswer }}"</strong> doesn't match any of the correct answers. 
                            The correct answer{{ count($correctAnswers) > 1 ? 's are' : ' is' }}: 
                            <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($correctAnswers as $correct)
                                    <span style="background: white; padding: 6px 15px; border-radius: 30px; color: #06d6a0; font-weight: 600; border: 1px solid rgba(6, 214, 160, 0.3);">
                                        "{{ $correct }}"
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        @if(strlen($userAnswer) > 0)
                            <div style="margin-top: 15px; padding: 10px; background: white; border-radius: 8px;">
                                <div style="font-size: 0.9rem; color: #6c757d;">Tips for matching:</div>
                                <ul style="margin-top: 8px; margin-bottom: 0; color: #6c757d; font-size: 0.9rem;">
                                    <li>Check for spelling errors</li>
                                    <li>Ensure correct spacing and punctuation</li>
                                    <li>Try matching with case sensitivity in mind</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    
@elseif($question->question_type === 'matching')
    <div style="background: #f8f9fa; padding: 20px; border-radius: 16px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="border-bottom: 2px solid rgba(0,0,0,0.05);">
                    <th style="text-align: left; padding: 15px 10px; color: #6c757d; font-weight: 500;">Left Item</th>
                    <th style="text-align: center; padding: 15px 10px; color: #6c757d; font-weight: 500;">Match</th>
                    <th style="text-align: left; padding: 15px 10px; color: #6c757d; font-weight: 500;">Your Answer</th>
                    <th style="text-align: left; padding: 15px 10px; color: #6c757d; font-weight: 500;">Correct Answer</th>
                    <th style="text-align: center; padding: 15px 10px; color: #6c757d; font-weight: 500;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($question->matchingPairs as $pair)
                    @php
                    $userMatch = null;
                    $isMatchCorrect = false;
                    
                    if ($type === 'user' && $answerData && isset($answerData['pair_' . $pair->id])) {
                        $userMatch = $answerData['pair_' . $pair->id];
                        $isMatchCorrect = $userMatch === $pair->right_item;
                    }
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                        <td style="padding: 15px 10px; font-weight: 600;">
                            {{ $pair->left_item }}
                        </td>
                        <td style="padding: 15px 10px; text-align: center;">
                            <i class="fas fa-arrow-right" style="color: #4361ee;"></i>
                        </td>
                        <td style="padding: 15px 10px;">
                            @if($userMatch)
                                <span style="color: {{ $isMatchCorrect ? '#06d6a0' : '#ef476f' }}; font-weight: 500;">
                                    {{ $userMatch }}
                                </span>
                            @else
                                <span style="color: #6c757d; font-style: italic;">Not answered</span>
                            @endif
                        </td>
                        <td style="padding: 15px 10px;">
                            <span style="color: #06d6a0; font-weight: 500;">
                                {{ $pair->right_item }}
                            </span>
                        </td>
                        <td style="padding: 15px 10px; text-align: center;">
                            @if($userMatch)
                                @if($isMatchCorrect)
                                    <span class="rs-badge rs-badge-correct" style="display: inline-block;">
                                        <i class="fas fa-check"></i> Correct
                                    </span>
                                @else
                                    <span class="rs-badge rs-badge-incorrect" style="display: inline-block;">
                                        <i class="fas fa-times"></i> Incorrect
                                    </span>
                                @endif
                            @else
                                <span class="rs-badge" style="display: inline-block; background: rgba(108, 117, 125, 0.1); color: #6c757d;">
                                    <i class="fas fa-minus"></i> Not answered
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @php
        // Calculate overall matching score
        $totalPairs = $question->matchingPairs->count();
        $correctPairs = 0;
        
        if ($type === 'user' && $answerData) {
            foreach ($question->matchingPairs as $pair) {
                if (isset($answerData['pair_' . $pair->id]) && $answerData['pair_' . $pair->id] === $pair->right_item) {
                    $correctPairs++;
                }
            }
        }
        @endphp
        
        @if($type === 'user')
            <div style="margin-top: 20px; padding: 15px; background: white; border-radius: 12px;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <span style="font-weight: 600;">Matching Score:</span>
                        <span style="margin-left: 10px;">{{ $correctPairs }}/{{ $totalPairs }} correct matches</span>
                    </div>
                    <div>
                        @if($correctPairs === $totalPairs)
                            <span class="rs-badge rs-badge-correct" style="padding: 5px 15px;">
                                <i class="fas fa-check-circle"></i> Perfect Match!
                            </span>
                        @elseif($correctPairs > 0)
                            <span class="rs-badge rs-badge-missed" style="padding: 5px 15px;">
                                Partial Match ({{ round(($correctPairs/$totalPairs)*100) }}%)
                            </span>
                        @else
                            <span class="rs-badge rs-badge-incorrect" style="padding: 5px 15px;">
                                No Correct Matches
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    
@elseif($question->question_type === 'essay' || $question->question_type === 'text')
    <div style="background: #f8f9fa; padding: 20px; border-radius: 16px;">
        <div style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: #6c757d;">
                <i class="fas fa-pencil-alt"></i>
                <span>Your answer:</span>
            </div>
            <div style="padding: 15px; background: white; border-radius: 12px; border-left: 4px solid #4361ee;">
                {{ $answerData ?: 'No answer provided' }}
            </div>
        </div>
        
        @if($question->model_answer)
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; color: #6c757d;">
                <i class="fas fa-lightbulb" style="color: #ffd166;"></i>
                <span>Model answer:</span>
            </div>
            <div style="padding: 15px; background: white; border-radius: 12px; border-left: 4px solid #ffd166;">
                {{ $question->model_answer }}
            </div>
        </div>
        @endif
    </div>
@endif