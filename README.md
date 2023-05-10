<!-- <h1 align="center"><img src="/views/img/logo.png" alt="SAV Attachments" width="500"></h1> -->

# *Blocks: Example extension* for PrestaShop

[![PHP tests](https://github.com/Kaudaj/kjblocks/actions/workflows/php.yml/badge.svg)](https://github.com/Kaudaj/kjblocks/actions/workflows/php.yml)
[![GitHub release](https://img.shields.io/github/release/Kaudaj/kjblocks.svg)](https://GitHub.com/Kaudaj/kjblocks/releases/)
[![GitHub license](https://img.shields.io/github/license/Kaudaj/kjblocks)](https://github.com/Kaudaj/kjblocks/LICENSE.md)

## About

*Blocks: Example extension* module show you how to create an extension for [Blocks][kjblocks] module.

## Essential features

- Example block
- Documentation

## Usage

### Installation

**Get started**

From PrestaShop installation root:

```bash
cd modules
git clone https://github.com/Kaudaj/kjblocks.git
cd kjblocks
composer install
cd ../..
bin/console pr:mo install kjblocks
```

### Configuration

- `tests/php/.phpstan_bootstrap_config.php`<br>
For GrumPHP: Set PrestaShop installation path for PHPStan task.<br>
Replace default path with the root path of a stable PrestaShop environment.

### Commands

Here are some useful commands you could need during your development workflow:

- `composer grum`<br>
Run GrumPHP tasks suite.
- `composer header-stamp`<br>
Add license headers to files.
- `composer autoindex`<br>
Add index files in directories.
- `composer dumpautoload -a`<br>
Update the autoloader when you add new classes in a classmap package (`src` and `tests` folder here).

## Tutorial

### Start from the example extension

If you want to start quickly to develop your own extension, follow the same instructions as [kjmodulebedrock](https://github.com/Kaudaj/kjmodulebedrock#installation) states.
You'll have a fresh extension with an example block type, and you can now build your own types without starting from scratch.

### Build your own type

Each block type needs to implement `BlockInterface`.

You can start from it but it's recommended to extend directly abstract class `Block`.
It's the base class that implements by default all the required methods of `BlockInterface` and provides some features like caching and validation.

See [ExampleBlock](src/Block/ExampleBlock.php) to see a concrete example of block type extending `Block` class.

Let's explain the methods:

- `getName`: Return type identifier, used to retrieve the wanted block type
- `getLocalizedName`: Return human-readable name, used in types listing
- `getDescription`: Return description, used in types listing
- `getLogo`: Return path of the block logo, used in types listing
- `configureOptions`: Define options that the blocks accept and their specificities (required, type, allowed values).
See [OptionsResolver](https://symfony.com/doc/4.4/components/options_resolver.html) documentation to learn more about options definition.
- `getMultiLangOptions`: Returns multi-lang options names in an array. For these options, only the contextual language value from the lang-value pairs array will be passed to the block type. 
See TextBlock in [kjblocks][kjblocks] for a concrete example.
- `setOptions`: It's here that you decide what to do with the options. Usual use case is to assign the options to the block type properties, as in [ExampleBlock](src/Block/ExampleBlock.php).
- `render`: Returns block type rendering. You won't have to implement it if you use abstract `Block` class but rather `getTemplate` that returns the template path and `getTemplateVariables` which returns variables used in the template.

Once you implemented your block type, you have to expose it to the block types collector: the hook `actionGetBlockTypes`.
Your extension have to be connected to this hook and return the services of your block types in an array.
See [Services documentation](https://devdocs.prestashop-project.org/8/modules/concepts/services/) if you're not familiar with them.

### Handling the form

Each block has its own options and user can fill them in block form.
But fields can be different than options so you have to associate a Form Type to your block type. You will do so in `getFormType` method.

See [Form Type](https://symfony.com/doc/4.4/reference/forms/types.html) documentation to learn more about form types if you are not familiar with them, and see [ExampleBlockType](src/Block/ExampleBlockType.php) for a concrete example of block form type.

Also, as options are not always corresponding exactly to a form field, form mappers have been created. Their role is to :
- map fields to options to persist the options in the database in the right structure after saving the block form
- map options to fields to display accurate fields value corresponding to saved options

See ContainerFormMapper in [kjblocks][kjblocks] for a concrete example.

### Retrieve a block type

`BlockTypeProvider` stores all block types at runtime. You can get it through its service: `kaudaj.module.blocks.block_type_provider`.
It offers the `getBlockType` method. Passing the block type and its options, this method will return you a `BlockInterface` instance.

So to get a text block type with text option equals to "My text" and to render it, you can write this code:

```php
$textBlock = $blockTypeProvider->getBlockType('text', [
    TextBlock::OPTION_TEXT => 'My text'
]);

$textBlock->render();
```

## Compatibility

|     |     |
| --- | --- |
| PrestaShop | **>=1.7.8.0** |
| PHP        | **>=7.1** for production and **>=7.3** for development |
| Multishop | :heavy_check_mark: |

## License

[Academic Free License 3.0][afl-3.0].

## Reporting issues

You can [report issues][report-issue] in this very repository.

## Contributing

As it is an open source project, everyone is welcome and even encouraged to contribute with their own improvements!

To contribute in the best way possible, you want to follow the [PrestaShop contribution guidelines][contribution-guidelines].

## Contact

Feel free to contact us by email at info@kaudaj.com.

[report-issue]: https://github.com/Kaudaj/kjblocks/issues/new/choose
[prestashop]: https://www.prestashop.com/
[contribution-guidelines]: https://devdocs.prestashop.com/1.7/contribute/contribution-guidelines/project-modules/
[afl-3.0]: https://opensource.org/licenses/AFL-3.0
[kjblocks]: https://github.com/Kaudaj/kjblocks