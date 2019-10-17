<?php

namespace App\Testing;

use App\Testing\UnitTestDataHelper\UnitTestDataHelper;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    /** @var UnitTestDataHelper */
    private $unitTestDataHelper;

    public function getDataHelper(): UnitTestDataHelper
    {
        if (!$this->unitTestDataHelper instanceof UnitTestDataHelper) {
            $this->unitTestDataHelper = new UnitTestDataHelper();
        }

        return $this->unitTestDataHelper;
    }
}
