<?php

namespace App\Http\Controllers\API;

use App\Services\PatientService;
use App\Http\Requests\PatientRequest;
use App\Http\Controllers\Controller;

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
     * Get Patient
     *
     * @param PatientRequest $request
     * @return Illuminate\Database\Eloquent\Model
     */
    public function get(PatientRequest $request)
    {
        return $this->patientService->getById($request->id);
    }
}
