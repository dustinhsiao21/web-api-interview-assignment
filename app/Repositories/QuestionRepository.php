<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    private $model;

    /**
     * Create a new controller instance.
     *
     * @param $model Answer Model
     * @return void
     */
    public function __construct(Question $model)
    {
        $this->model = $model;
    }

    /**
     * Find Question by Id.
     *
     * @param int $id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }
}
