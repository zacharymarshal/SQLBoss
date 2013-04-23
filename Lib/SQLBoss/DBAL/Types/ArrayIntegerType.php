<?php

namespace SQLBoss\DBAL\Types;
 
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
 
class ArrayIntegerType extends Type
{
	const ARRAYINTEGERTYPE = 'arrayintegertype';
 
	public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		return 'INT[]';
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
		return self::ARRAYINTEGERTYPE;
	}
}