<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb2dab31f83e42dac8e34f44ff24b6ad6
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TwoLabNet\\CarbonFieldsLoader\\' => 29,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
            'Carbon_Fields\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TwoLabNet\\CarbonFieldsLoader\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
    );

    public static $prefixesPsr0 = array (
        'C' => 
        array (
            'Composer\\CustomDirectoryInstaller' => 
            array (
                0 => __DIR__ . '/..' . '/mnsami/composer-custom-directory-installer/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb2dab31f83e42dac8e34f44ff24b6ad6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb2dab31f83e42dac8e34f44ff24b6ad6::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitb2dab31f83e42dac8e34f44ff24b6ad6::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
