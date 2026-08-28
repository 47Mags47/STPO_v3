<?php

namespace Tests\Feature\Cases;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\hasControllerTest;
use Tests\TestCase;

class GuessesModelTestCase extends TestCase
{
    use hasControllerTest;

    public $model_class = '';

    protected function setUp(): void
    {
        parent::setUp();
    }
}
