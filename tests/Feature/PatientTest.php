<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test get patient.
     *
     * @return void
     */
    public function testGetAnswer()
    {
        $answer = factory(Answer::class)->create();

        $response = $this->json('GET', route('api::patient::answer'), ['id' => $answer->patient_id]);

        $response->assertSuccessful();

        $result = $response->decodeResponseJson();

        $question = Question::find($answer->question_id);

        $this->assertEquals($question->title, $result[0]['question']['title']);
        $this->assertEquals($answer->answers, $result[0]['answers']);
    }

    /**
     * Test patient not found.
     *
     * @return void
     */
    public function testGetFail()
    {
        $response = $this->json('GET', route('api::patient::answer'), ['id' => 1]);

        $response->assertStatus(404);
    }
}
