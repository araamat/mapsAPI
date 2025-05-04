<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;


use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication as TestsCreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use TestsCreatesApplication, RefreshDatabase;
}
