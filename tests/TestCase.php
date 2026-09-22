<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithCachedConfig;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use WithCachedConfig;
}
