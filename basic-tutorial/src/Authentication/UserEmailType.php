<?php

namespace Authentication;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

final class UserEmailType extends StringType
{
    const NAME = 'UserEmail';

    public function getName() : string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /* @var $value UserEmail */
        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return UserEmail::fromString($value);
    }
}
