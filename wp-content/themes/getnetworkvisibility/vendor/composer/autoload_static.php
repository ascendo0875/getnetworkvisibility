<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit90ffcf40d12fdb972265231ad8baa511
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FINNPartners\\Theme\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FINNPartners\\Theme\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit90ffcf40d12fdb972265231ad8baa511::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit90ffcf40d12fdb972265231ad8baa511::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit90ffcf40d12fdb972265231ad8baa511::$classMap;

        }, null, ClassLoader::class);
    }
}
