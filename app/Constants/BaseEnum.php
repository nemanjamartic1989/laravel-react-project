<?php

declare(strict_types=1);

namespace App\Constants;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use Exception;

/**
 * Base class for all enums with:
 * - magic getter support
 * - localization support
 * - clean API for constants
 */
abstract class BaseEnum extends Enum implements LocalizedEnum
{
    /**
     * Magic getter to retrieve additional computed attributes.
     *
     */
    public function __get($attrName)
    {
        if (method_exists($this, $attrName)) {
            return $this->{$attrName}();
        }

        $class = static::class;

        throw new Exception("Property or method [{$attrName}] does not exist on [{$class}]");
    }
}
