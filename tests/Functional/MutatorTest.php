<?php

declare(strict_types=1);

namespace webignition\WebDriverElementMutator\Tests\Functional;

use webignition\DomElementIdentifier\ElementIdentifier;
use webignition\SymfonyDomCrawlerNavigator\Navigator;
use webignition\WebDriverElementInspector\Inspector;
use webignition\WebDriverElementMutator\Mutator;

class MutatorTest extends AbstractTestCase
{
    private Mutator $mutator;
    private Inspector $inspector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mutator = Mutator::create();
        $this->inspector = Inspector::create();
    }

    /**
     * @dataProvider setValueDataProvider
     */
    public function testSetValue(
        string $fixture,
        string $elementCssSelector,
        string $value,
        ?string $expectedValue
    ): void {
        $crawler = self::$client->request('GET', $fixture);

        $navigator = Navigator::create($crawler);
        $elementLocator = new ElementIdentifier($elementCssSelector);

        $collection = $navigator->find($elementLocator);

        $this->mutator->setValue($collection, $value);

        $this->assertSame($expectedValue, $this->inspector->getValue($collection));
    }

    /**
     * @return array[]
     */
    public function setValueDataProvider(): array
    {
        return [
            'radio button collection, none checked, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-not-checked"]',
                'value' => '',
                'expectedValue' => null,
            ],
            'radio button collection, none checked, invalid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-not-checked"]',
                'value' => 'invalid',
                'expectedValue' => null,
            ],
            'radio button collection, none checked, valid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-not-checked"]',
                'value' => 'not-checked-2',
                'expectedValue' => 'not-checked-2',
            ],
            'radio button collection, has checked, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-checked"]',
                'value' => '',
                'expectedValue' => 'checked-2',
            ],
            'radio button collection, has checked, invalid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-checked"]',
                'value' => 'invalid',
                'expectedValue' => 'checked-2',
            ],
            'radio button collection, has checked, valid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-checked"]',
                'value' => 'checked-3',
                'expectedValue' => 'checked-3',
            ],
            'select option collection, none selected, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"] option',
                'value' => '',
                'expectedValue' => 'none-selected-1',
            ],
            'select option collection, none selected, invalid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"] option',
                'value' => 'invalid',
                'expectedValue' => 'none-selected-1',
            ],
            'select option collection, none selected, valid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"] option',
                'value' => 'none-selected-3',
                'expectedValue' => 'none-selected-3',
            ],
            'select option collection, has selected, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"] option',
                'value' => '',
                'expectedValue' => 'has-selected-3',
            ],
            'select option collection, has selected, invalid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"] option',
                'value' => 'invalid',
                'expectedValue' => 'has-selected-3',
            ],
            'select option collection, has selected, valid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"] option',
                'value' => 'has-selected-1',
                'expectedValue' => 'has-selected-1',
            ],
            'select, none selected, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"]',
                'value' => '',
                'expectedValue' => 'none-selected-1',
            ],
            'select, none selected, invalid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"]',
                'value' => 'invalid',
                'expectedValue' => 'none-selected-1',
            ],
            'select, none selected, valid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"]',
                'value' => 'none-selected-2',
                'expectedValue' => 'none-selected-2',
            ],
            'select, has selected, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"]',
                'value' => '',
                'expectedValue' => 'has-selected-3',
            ],
            'select, has selected, invalid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"]',
                'value' => 'invalid',
                'expectedValue' => 'has-selected-3',
            ],
            'select, has selected, valid non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"]',
                'value' => 'has-selected-2',
                'expectedValue' => 'has-selected-2',
            ],
            'collection of unrelated elements, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input',
                'value' => '',
                'expectedValue' => null,
            ],
            'collection of unrelated elements, non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input',
                'value' => 'value',
                'expectedValue' => null,
            ],
            'input with empty value, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="input-with-empty-value"]',
                'value' => '',
                'expectedValue' => '',
            ],
            'input with empty value, non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="input-with-empty-value"]',
                'value' => 'value',
                'expectedValue' => 'value',
            ],
            'input with non-empty value, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="input-with-non-empty-value"]',
                'value' => '',
                'expectedValue' => '',
            ],
            'input with non-empty value, non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="input-with-non-empty-value"]',
                'value' => 'new value',
                'expectedValue' => 'new value',
            ],
            'textarea element, empty, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'textarea[name="empty-textarea"]',
                'value' => '',
                'expectedValue' => '',
            ],
            'textarea element, empty, non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'textarea[name="empty-textarea"]',
                'value' => 'value',
                'expectedValue' => 'value',
            ],
            'textarea element, non-empty, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'textarea[name="non-empty-textarea"]',
                'value' => '',
                'expectedValue' => '',
            ],
            'textarea element, non-empty, non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'textarea[name="non-empty-textarea"]',
                'value' => 'new value',
                'expectedValue' => 'new value',
            ],
        ];
    }
}
