<?php

namespace webignition\WebDriverElementMutator;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\RadioButtonCollection;
use webignition\WebDriverElementCollection\SelectOptionCollection;
use webignition\WebDriverElementCollection\WebDriverElementCollectionInterface;

class Mutator
{
    private const SELECT_TAG_NAME = 'select';
    private const VALUE_ATTRIBUTE_NAME = 'value';

    public static function create(): Mutator
    {
        return new Mutator();
    }

    public function setValue(WebDriverElementCollectionInterface $collection, string $value): void
    {
        if ($collection instanceof RadioButtonCollection || $collection instanceof SelectOptionCollection) {
            $this->setSelectedCollectionValue($collection, $value);

            return;
        }

        if (1 === count($collection)) {
            $element = $collection->get(0);

            if ($element instanceof WebDriverElement) {
                $this->setElementValue($element, $value);

                return;
            }
        }

        return;
    }

    private function setElementValue(WebDriverElement $element, string $value): void
    {
        $tagName = $element->getTagName();

        if (self::SELECT_TAG_NAME === $tagName) {
            $selectOptionCollection = SelectOptionCollection::fromSelectElement($element);

            if ($selectOptionCollection instanceof SelectOptionCollection) {
                $this->setSelectedCollectionValue($selectOptionCollection, $value);
            }

            return;
        }

        $element->clear();
        $element->sendKeys($value);

        return;
    }

    private function setSelectedCollectionValue(WebDriverElementCollectionInterface $collection, string $value): void
    {
        foreach ($collection as $item) {
            $valueAttribute = trim((string) $item->getAttribute(self::VALUE_ATTRIBUTE_NAME));

            if ($value === $valueAttribute) {
                $item->click();
            }
        }
    }
}
