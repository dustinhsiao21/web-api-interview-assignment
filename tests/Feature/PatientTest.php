<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test get patient
     *
     * @return void
     */
    public function testGet()
    {
        $answer = factory(Answer::class)->create();

        $response = $this->json('GET', route('api::patient'), ['id' => $answer->patient_id]);

        $response->assertSuccessful();

        $patient = Patient::find($answer->patient_id);

        $this->assertEquals($response['first_name'], $patient->first_name);
        $this->assertEquals($response['last_name'], $patient->last_name);
        $this->assertEquals($response['answers'][0]['answers'], $answer->answers);
    }

    /**
     * Test patient not found
     *
     * @return void
     */
    public function testGetFail()
    {
        $response = $this->json('GET', route('api::patient'), ['id' => 1]);

        $response->assertStatus(404);
    }
}
