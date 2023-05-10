<?php
/**
 * Copyright since 2019 Kaudaj
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@kaudaj.com so we can send you a copy immediately.
 *
 * @author    Kaudaj <info@kaudaj.com>
 * @copyright Since 2019 Kaudaj
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

declare(strict_types=1);

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

if (file_exists(_PS_MODULE_DIR_ . 'kjblocks/vendor/autoload.php')) {
    require_once _PS_MODULE_DIR_ . 'kjblocks/vendor/autoload.php';
}

class KJBlocksExampleExtension extends Module
{
    /**
     * @var string[] Hooks to register
     */
    public const HOOKS = [
        'actionGetBlockTypes',
    ];

    public function __construct()
    {
        $this->name = 'kjblocksexampleextension';
        $this->tab = 'others';
        $this->version = '1.0.0';
        $this->author = 'Kaudaj';
        $this->ps_versions_compliancy = ['min' => '1.7.8.0', 'max' => _PS_VERSION_];
        $this->dependencies = ['kjblocks'];

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Blocks Example Extension', [], 'Modules.Kjblocksexampleextension.Admin');
        $this->description = $this->trans(<<<EOF
        Provides example for kjblocks extensions.
EOF
            ,
            [],
            'Modules.Kjblocksexampleextension.Admin'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function install(): bool
    {
        return parent::install()
            && $this->registerHook(self::HOOKS)
        ;
    }

    /**
     * @return string[]
     */
    public function hookActionGetBlockTypes(): array
    {
        return [
            'kaudaj.module.blocks_example_extension.block.example',
        ];
    }
}
