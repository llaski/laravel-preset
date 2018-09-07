<?php

namespace Tests;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Assert as PHPUnit;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        EloquentCollection::macro('assertContains', function ($val) {
            PHPUnit::assertTrue($this->contains($val), 'Failed asserting that a collection contained the specified value');
        });

        EloquentCollection::macro('assertNotContains', function ($val) {
            PHPUnit::assertFalse($this->contains($val), 'Failed asserting that a collection did not contained the specified value');
        });

        EloquentCollection::macro('assertEquals', function ($items) {
            Assert::assertCount($items->count(), $this);

            $this->zip($items)->each(function ($itemPair) {
                Assert::assertTrue($itemPair[0]->is($itemPair[1]));
            });
        });
    }

    protected function weh()
    {
        $this->withoutExceptionHandling();
    }
}
