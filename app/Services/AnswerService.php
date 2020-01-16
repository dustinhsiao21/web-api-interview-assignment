<?php

namespace App\Services;

use App\Repositories\AnswerRepository;
use App\Repositories\PatientRepository;
use App\Repositories\QuestionRepository;
use App\Exceptions\QuestionTypeErrorException;
use App\Models\Question;

class AnswerService
{
    private $answers;
    private $questions;
    private $patients;

    /**
     * Create a new controller instance.
     *
     * @param $answers AnswerRepository
     * @return void
     */
    public function __construct(AnswerRepository $answers, QuestionRepository $questions, PatientRepository $patients)
    {
        $this->answers = $answers;
        $this->questions = $questions;
        $this->patients = $patients;
    }

    /**
     * Create or update answer.
     *
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $data)
    {
        $question = $this->questions->findOrFail($data['question_id']);

        $this->patients->findOrFail($data['patient_id']);

        if ($question->type != Question::CHECKBOX && count($data['answers']) > 1) {
            throw new QuestionTypeErrorException('Question should only have one answer');
        }

        return $this->answers->updateOrCreate($data);
    }
}
