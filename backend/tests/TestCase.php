<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }


    public function assertStatus($status)
    {
        $actual = $this->response->getStatusCode();

        PHPUnit\Framework\Assert::assertTrue(
            $actual === $status,
            "Expected status code {$status} but received {$actual}."
        );

        return $this;
    }


}
