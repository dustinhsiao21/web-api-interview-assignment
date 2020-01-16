<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerCreateRequest;
use App\Http\Requests\AnswerUpdateRequest;
use App\Services\AnswerService;

class AnswerController extends Controller
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
     * Create Answer
     *
     * @param AnswerCreateRequest $request
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create(AnswerCreateRequest $request)
    {
        return $this->answerService->updateOrCreate($request->onlyRules());
    }

    /**
     * Update Answer
     *
     * @param AnswerUpdateRequest $request
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update(AnswerUpdateRequest $request)
    {
        return $this->answerService->updateOrCreate($request->onlyRules());
    }
}
