<?php

namespace App\Services;

use App\Repositories\PatientRepository;

class PatientService
{
    private $patients;

    /**
     * Create a new controller instance.
     *
     * @param $patients PatientRepository
     * @return void
     */
    public function __construct(PatientRepository $patients)
    {
        $this->patients = $patients;
    }

    /**
     * Get Answers By patient id.
     *
     * @param int $id patient id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAnswersById(int $id)
    {
        return $this->patients->findOrFail($id)->load('answers');
    }
}
