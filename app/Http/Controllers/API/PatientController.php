<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Services\AnswerService;

class PatientController extends Controller
{
    private $answerService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * Get Answer By Patient Id.
     *
     * @param PatientRequest $request
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getAnswers(PatientRequest $request)
    {
        return $this->answerService->getAnswersByPatientId($request->id);
    }
}
