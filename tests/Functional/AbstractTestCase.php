<?php

namespace webignition\WebDriverElementMutator\Tests\Functional;

use webignition\BasePantherTestCase\AbstractBrowserTestCase;

abstract class AbstractTestCase extends AbstractBrowserTestCase
{
    const FIXTURES_RELATIVE_PATH = '/fixtures';
    const FIXTURES_HTML_RELATIVE_PATH = '/html';

    public static function setUpBeforeClass(): void
    {
        self::$webServerDir = __DIR__
            . '/..'
            . self::FIXTURES_RELATIVE_PATH
            . self::FIXTURES_HTML_RELATIVE_PATH;

        parent::setUpBeforeClass();
    }
}
