<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit09eb8fffc1015518cc1586e36ed251ef
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit09eb8fffc1015518cc1586e36ed251ef::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit09eb8fffc1015518cc1586e36ed251ef::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
