<?php
namespace GrShareCode\Contact\CustomField;

use GrShareCode\TypedCollection;

/**
 * Class CustomFieldMappingCollection
 * @package GrShareCode\Contact\CustomField
 */
class CustomFieldMappingCollection extends TypedCollection
{
    public function __construct()
    {
        $this->setItemType('\GrShareCode\Contact\CustomField\CustomFieldMapping');
    }
}