<?php declare(strict_types=1);

namespace Shopware\Api\Shipping\Event\ShippingMethodTranslation;

use Shopware\Api\Shipping\Collection\ShippingMethodTranslationBasicCollection;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Event\NestedEvent;

class ShippingMethodTranslationBasicLoadedEvent extends NestedEvent
{
    const NAME = 'shipping_method_translation.basic.loaded';

    /**
     * @var TranslationContext
     */
    protected $context;

    /**
     * @var ShippingMethodTranslationBasicCollection
     */
    protected $shippingMethodTranslations;

    public function __construct(ShippingMethodTranslationBasicCollection $shippingMethodTranslations, TranslationContext $context)
    {
        $this->context = $context;
        $this->shippingMethodTranslations = $shippingMethodTranslations;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): TranslationContext
    {
        return $this->context;
    }

    public function getShippingMethodTranslations(): ShippingMethodTranslationBasicCollection
    {
        return $this->shippingMethodTranslations;
    }
}