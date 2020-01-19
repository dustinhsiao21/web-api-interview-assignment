<?php

namespace Tests\Feature;

use App\Exceptions\QuestionTypeErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Answer;
use App\Models\Patient;
use App\Models\Question;
use App\Services\AnswerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = app(AnswerService::class);
    }

    /**
     * /**
     * Test create single answer.
     *
     * @return void
     */
    public function testCreateAnswer()
    {
        $patient = factory(Patient::class)->create();
        $question = factory(Question::class)->create();
        $answers = ['test'];

        $data = [
            'patient_id' => $patient->id,
            'question_id' => $question->id,
            'answers' => $answers
        ];

        $result = $this->service->updateOrCreate($data);

        $this->assertEquals($question->id, $result->question_id);
        $this->assertEquals($patient->id, $result->patient_id);
        $this->assertEquals($answers, $result->answers);
    }

    /**
     * Test update answer
     *
     * @return void
     */
    public function testUpdateAnswer()
    {
        $answer = factory(Answer::class)->create();
        $answers = ['test'];

        $data = [
            'patient_id' => $answer->patient_id,
            'question_id' => $answer->question_id,
            'answers' => $answers
        ];

        $result = $this->service->updateOrCreate($data);
        $this->assertEquals($answers, $result->answers);
    }

    /**
     * Test patient id not found when update answer
     *
     * @return void
     */
    public function testPatientNotFoundWhenUpdateAnswer()
    {
        $answer = factory(Answer::class)->create();
        $answers = ['test'];

        $data = [
            'patient_id' => $answer->patient_id + 1,
            'question_id' => $answer->question_id,
            'answers' => $answers
        ];

        $this->expectException(ModelNotFoundException::class);
        $this->service->updateOrCreate($data);
    }

    /**
     * Test question id not found when update answer
     * 
     * @return void
     */
    public function testQuestionNotFoundWhenUpdateAnswer()
    {
        $answer = factory(Answer::class)->create();
        $answers = ['test'];

        $data = [
            'patient_id' => $answer->patient_id,
            'question_id' => $answer->question_id + 1,
            'answers' => $answers
        ];

        $this->expectException(ModelNotFoundException::class);
        $this->service->updateOrCreate($data);
    }

    /**
     * Test question type error exception when update answers.
     *
     * @return void
     */
    public function testQuestionTypeError()
    {
        $answer = factory(Answer::class)->create();

        $question = Question::first();
        $question->type = Question::RADIO;
        $question->save();

        $answers = ['test1', 'test2'];

        $data = [
            'patient_id' => $answer->patient_id,
            'question_id' => $answer->question_id,
            'answers' => $answers
        ];
        $this->expectException(QuestionTypeErrorException::class);
        $this->service->updateOrCreate($data);
    }

    /**
     * Test GetAnswersByPatientId
     *
     * @return void
     */
    public function testGetAnswersByPatientId()
    {
        $answer = factory(Answer::class)->create();

        $result = $this->service->getAnswersByPatientId($answer->patient_id)->first();

        $this->assertNotNull($result);

        $this->assertEquals($answer->answers, $result->answers);
        $this->assertEquals($answer->question->title, $result->question->title);
    }

    /**
     * Test Patient Not Found when getAnswersByPatientId
     *
     * @return void
     */
    public function testPatientNotFoundWhenGetAnswersByPatientId()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->getAnswersByPatientId(1);
    }
}
