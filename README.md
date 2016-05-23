# Karriere Code Quality

Code Quality tests that can be run via Composer scripts.

## Used packages

### [phpspec/phpspec](https://github.com/phpspec/phpspec)

Used for testing (SpecBDD) the code.   
Must be configured with a `phpspec.yml` file in your root folder.

### [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

Currently used for fixing the code.   
Fixes all files in `src` directory. Does not implement all PSR2 rules (yet).

This package is not used for checking (linting), because it can't create
XML reports.

### [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

Currently used for checking (linting) the code.   
Sniffs all files in `src` directory.

This package is can also be used for fixing, but it fixes way more than
specified in PSR2 and is buggy.   
Version v3.0.0 (not released yet) should improve reliability.

## Installation

The recommended way to install this package is over composer.

**Automatic way:**

```shell
composer config repositories.code-quality vcs git@gitlab:php/code_quality.git
composer require karriere/code-quality
```

**Manual way:**

Make following changes to your `composer.json` and afterwards do 
`composer update`.

```json
{
    "repositories": {
        "code-quality": {
            "type": "vcs",
            "url": "git@gitlab:php/code_quality.git"
        }
    },
    "require": {
        "karriere/code-quality": "<version>"
    }
}
```

## Usage

Insert the desired scripts to your `composer.json`.

```json
{
    "scripts": {
        "test": "Karriere\\CodeQuality\\SpecificationTest::run",
        "lint": "Karriere\\CodeQuality\\CodeStyleChecker::run",
        "fix": "Karriere\\CodeQuality\\CodeStyleFixer::run",
        "coverage": "Karriere\\CodeQuality\\CodeCoverage::run"
    }
}
```

You can execute the scripts like this:

```shell
composer test
composer lint
composer fix
composer coverage
```

These scripts accept arguments:

```shell
composer lint -- --env=local (default)
composer lint -- --env=jenkins
```
```shell
composer coverage -- --env=local (default)
composer coverage -- --env=jenkins
```
```shell
composer fix -- --tool=php-cs-fixer (default)
composer fix -- --tool=phpcbf
```

You can disable `TTY` by adding the `--notty` flag (needed for Jenkins).   
On Windows platform it's disabled automatically.

```
composer {script} -- --env=jenkins --notty
```
