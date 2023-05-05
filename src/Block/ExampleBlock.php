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

namespace Kaudaj\Module\BlocksExampleExtension\Block;

use Kaudaj\Module\Blocks\Block;
use Kaudaj\Module\BlocksExampleExtension\Form\Type\Block\ExampleBlockType;
use PrestaShop\PrestaShop\Core\ConstraintValidator\Constraints\CleanHtml;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExampleBlock extends Block
{
    public const OPTION_MY_OPTION = 'my_option';

    /**
     * @var string|null
     */
    private $myOption;

    public function getName(): string
    {
        return 'example';
    }

    public function getDescription(): string
    {
        return $this->translator->trans('Example block, to start from or to study how it works', [], 'Modules.Kjblocksexampleextension.Admin');
    }

    public function getLocalizedName(): string
    {
        return $this->translator->trans('Example', [], 'Modules.Kjblocksexampleextension.Admin');
    }

    public function getLogo(): string
    {
        return '/modules/kjblocksexampleextension/views/img/blocks/example.png';
    }

    protected function getTemplate(): string
    {
        return 'module:kjblocksexampleextension/views/templates/front/blocks/example.tpl';
    }

    protected function getTemplateVariables(): array
    {
        $variables = parent::getTemplateVariables();

        if ($this->myOption) {
            $variables[self::OPTION_MY_OPTION] = $this->myOption;
        }

        return $variables;
    }

    public function setOptions(array $options = []): void
    {
        parent::setOptions($options);

        if (key_exists(self::OPTION_MY_OPTION, $options)) {
            $this->myOption = strval($options[self::OPTION_MY_OPTION]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefined([
                self::OPTION_MY_OPTION,
            ])
            ->setAllowedTypes(self::OPTION_MY_OPTION, 'string')
            ->setAllowedValues(self::OPTION_MY_OPTION, $this->createIsValidCallable(
                new CleanHtml()
            ))
        ;
    }

    public function getFormType(): string
    {
        return ExampleBlockType::class;
    }
}
