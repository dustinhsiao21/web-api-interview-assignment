<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswerRepository
{
    private $model;

    /**
     * Create a new controller instance.
     *
     * @param $model Answer Model
     * @return void
     */
    public function __construct(Answer $model)
    {
        $this->model = $model;
    }

    /**
     * Create or update answer by patient_id and question_id.
     *
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $data)
    {
        return $this->model->updateOrCreate([
            'patient_id' => $data['patient_id'],
            'question_id' => $data['question_id'],
        ], ['answers' => $data['answers']]);
    }

    /**
     * Find Answers by patient ID
     *
     * @param integer $id
     * @return void
     */
    public function findByPatientId(int $id)
    {
        return $this->model->where('patient_id', $id);
    }
}
