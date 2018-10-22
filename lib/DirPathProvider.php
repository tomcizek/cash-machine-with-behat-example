<?php declare(strict_types = 1);

namespace Library;

final class DirPathProvider
{
	public static function getLibDir(): string
	{
		return __DIR__;
	}
}
