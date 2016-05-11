# Karriere Code Quality

Code Quality tests for Composer scripts.

## Used packages

### [phpspec/phpspec](https://github.com/phpspec/phpspec)

Used for testing (SpecBDD) the code.   
Must be configured with a `phpspec.yml` file in your root folder.

### [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

Currently used for fixing the code.   
Fixes all files in `src` directory.

This package is not used for checking (linting), because it can't create XML reports.

### [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

Currently used for checking (linting) the code.   
Sniffs all files in `src` directory.

This package is not used for fixing, because it turned out be buggy (v2.6.0).
Version v3.0.0 (not released yet) should improve reliability.

## Installation

The recommended way to install this package is over composer.

**Automatic way:**

```
composer config repositories.code-quality vcs git@gitlab:php/code_quality.git
composer require karriere/code-quality
```

**Manual way:**

Make following changes to your `composer.json` and afterwards do `composer update`.

```
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

```
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

```
composer test
composer lint
composer fix
composer coverage
```

These scripts accept arguments:

```
composer lint -- --env=local (default)
composer lint -- --env=jenkins
```
