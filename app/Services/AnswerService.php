<?php

namespace App\Services;

use App\Exceptions\QuestionTypeErrorException;
use App\Models\Question;
use App\Repositories\AnswerRepository;
use App\Repositories\PatientRepository;
use App\Repositories\QuestionRepository;

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

        if (
            ($question->type == Question::RADIO || $question->type == Question::SELECT) &&
            count($data['answers']) != 1
        ) {
            throw new QuestionTypeErrorException("Question type: $question->type should only store one answer");
        }

        return $this->answers->updateOrCreate($data);
    }

    /**
     * Get Answers by Patient Id.
     *
     * @param integer $id patient id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAnswersByPatientId(int $id)
    {
        $this->patients->findOrFail($id);

        return $this->answers->findByPatientId($id)->with('question')->get();
    }
}
