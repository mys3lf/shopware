<?php declare(strict_types=1);

namespace Shopware\Api\Tax\Event\Tax;

use Shopware\Api\Tax\Struct\TaxSearchResult;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Event\NestedEvent;

class TaxSearchResultLoadedEvent extends NestedEvent
{
    const NAME = 'tax.search.result.loaded';

    /**
     * @var TaxSearchResult
     */
    protected $result;

    public function __construct(TaxSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): TranslationContext
    {
        return $this->result->getContext();
    }
}