<?php declare(strict_types=1);

namespace Shopware\Shop\Writer\Resource;

use Shopware\Api\Write\Field\FkField;
use Shopware\Api\Write\Field\ReferenceField;
use Shopware\Api\Write\Flag\Required;
use Shopware\Api\Write\WriteResource;
use Shopware\Context\Struct\TranslationContext;
use Shopware\Shop\Event\ShopPageGroupMappingWrittenEvent;

class ShopPageGroupMappingWriteResource extends WriteResource
{
    public function __construct()
    {
        parent::__construct('shop_page_group_mapping');

        $this->fields['shop'] = new ReferenceField('shopUuid', 'uuid', ShopWriteResource::class);
        $this->primaryKeyFields['shopUuid'] = (new FkField('shop_uuid', ShopWriteResource::class, 'uuid'))->setFlags(new Required());
        $this->fields['shopPageGroup'] = new ReferenceField('shopPageGroupUuid', 'uuid', ShopPageGroupWriteResource::class);
        $this->primaryKeyFields['shopPageGroupUuid'] = (new FkField('shop_page_group_uuid', ShopPageGroupWriteResource::class, 'uuid'))->setFlags(new Required());
    }

    public function getWriteOrder(): array
    {
        return [
            ShopWriteResource::class,
            ShopPageGroupWriteResource::class,
            self::class,
        ];
    }

    public static function createWrittenEvent(array $updates, TranslationContext $context, array $rawData = [], array $errors = []): ShopPageGroupMappingWrittenEvent
    {
        $uuids = [];
        if (isset($updates[self::class])) {
            $uuids = array_column($updates[self::class], 'uuid');
        }

        $event = new ShopPageGroupMappingWrittenEvent($uuids, $context, $rawData, $errors);

        unset($updates[self::class]);

        /**
         * @var WriteResource
         * @var string[]      $identifiers
         */
        foreach ($updates as $class => $identifiers) {
            if (!array_key_exists($class, $updates) || count($updates[$class]) === 0) {
                continue;
            }

            $event->addEvent($class::createWrittenEvent($updates, $context));
        }

        return $event;
    }
}