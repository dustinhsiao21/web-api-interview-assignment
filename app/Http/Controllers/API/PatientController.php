<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Services\PatientService;

class PatientController extends Controller
{
    private $patientService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * Get Patient.
     *
     * @param PatientRequest $request
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAnswers(PatientRequest $request)
    {
        return $this->patientService->getAnswersById($request->id);
    }
}
