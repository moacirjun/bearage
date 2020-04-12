<?php

use App\Resources\Locale;
use PHPUnit\Framework\TestCase;

class ResourceLocaleTest extends TestCase
{
    public function testDefaultLocale()
    {
        $this->assertEquals('pt', Locale::DEFAULT_LOCALE_CODE);
    }
}
