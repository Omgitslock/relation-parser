<?php
namespace Omgitslock\RelationParser\Enums;

//todo возможно стоит выпилить эту зависимость, ибо профита немного
use MyCLabs\Enum\Enum;

class RelationType extends Enum
{
    private const HAS_MANY = 'HasMany';

    private const HAS_MANY_THROUGH = 'HasManyThrough';

    private const BELONGS_TO_MANY = 'BelongsToMany';

    private const HAS_ONE = 'HasOne';

    private const BELONGS_TO = 'BelongsTo';

    private const MORPH_ONE = 'MorphOne';

    private const MORPH_TO = 'MorphTo';

    private const MORPH_MANY = 'MorphMany';

    private const MORPH_TO_MANY = 'MorphToMany';

    private const MORPH_BY_MANY = 'MorphedByMany';

    /**
     * Получить список всех возможных значений для данного enum
     *
     * @return string
     */
    public static function getValuesString()
    {
        return implode(", ", static::values());
    }
}