<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
    private $model;

    /**
     * Create a new controller instance.
     *
     * @param $model Patient Model
     * @return void
     */
    public function __construct(Patient $model)
    {
        $this->model = $model;
    }

    /**
     * find patient by id.
     *
     * @param int $id patient id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }
}
