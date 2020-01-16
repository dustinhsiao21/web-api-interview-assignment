<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Patient;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test create single answer.
     *
     * @return void
     */
    public function testCreate()
    {
        $answers = ['test'];
        $patient = factory(Patient::class)->create();
        $question = factory(Question::class)->create();

        $response = $this->postJson(route('api::answer::create'), [
            'patient_id' => $patient->id,
            'question_id' => $question->id,
            'answers' => $answers,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('answers', [
            'patient_id' => $patient->id,
            'question_id' => $question->id,
            'answers' => json_encode($answers),
        ]);
    }

    /**
     * Test Question not found.
     *
     * @return void
     */
    public function testQuestionNotFound()
    {
        $patient = factory(Patient::class)->create();

        $response = $this->postJson(route('api::answer::create'), [
            'patient_id' => $patient->id,
            'question_id' => 1,
            'answers' => ['test'],
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test Patient not found.
     *
     * @return void
     */
    public function testPatientNotFound()
    {
        $question = factory(Question::class)->create();

        $response = $this->postJson(route('api::answer::create'), [
            'patient_id' => 1,
            'question_id' => $question->id,
            'answers' => ['test'],
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test Question Type Error and return with Bad request status code.
     *
     * @return void
     */
    public function testQuestionTypeError()
    {
        $patient = factory(Patient::class)->create();
        // set question type is radio
        $question = factory(Question::class)->create([
            'type' => 'radio',
        ]);
        // radio type should have only one answer
        $answers = ['answer1', 'answer2'];

        $response = $this->postJson(route('api::answer::create'), [
            'patient_id' => $patient->id,
            'question_id' => $question->id,
            'answers' => $answers,
        ]);

        $response->assertStatus(400);
    }

    /**
     * Test create multiple answers.
     *
     * @return void
     */
    public function testCreateMutiple()
    {
        $answers = ['answer1', 'answer2'];
        $patient = factory(Patient::class)->create();
        $question = factory(Question::class)->create([
            'type' => Question::CHECKBOX,
        ]);

        $response = $this->postJson(route('api::answer::create'), [
            'patient_id' => $patient->id,
            'question_id' => $question->id,
            'answers' => $answers,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('answers', [
            'patient_id' => $patient->id,
            'question_id' => $question->id,
            'answers' => json_encode($answers),
        ]);
    }

    /**
     * Test update Answers.
     *
     * @return void
     */
    public function testUpdate()
    {
        $updateAnswers = ['answer1'];
        $answer = factory(Answer::class)->create();

        $response = $this->json('PUT', route('api::answer::update'), [
            'patient_id' => $answer->patient_id,
            'question_id' => $answer->question_id,
            'answers' => $updateAnswers,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('answers', [
            'patient_id' => $answer->patient_id,
            'question_id' => $answer->question_id,
            'answers' => json_encode($updateAnswers),
        ]);

        // test old answers
        $this->assertDatabaseMissing('answers', [
            'answers' => json_encode($answer->answers),
        ]);
    }
}
