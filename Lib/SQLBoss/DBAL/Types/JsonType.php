<?php

namespace SQLBoss\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class JsonType extends Type
{
    const JSONTYPE = 'jsontype';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'JSON';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return null;
    }

    public function getName()
    {
        return self::JSONTYPE;
    }
}
