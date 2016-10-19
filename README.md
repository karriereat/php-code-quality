# Karriere Code Quality

Code Quality tests that can be run via Composer scripts.

## Used packages

### [phpspec/phpspec](https://github.com/phpspec/phpspec)

Used for testing (SpecBDD) the code.   
Must be configured with a `phpspec.yml` file in your root folder.

We are using the `henrikbjorn/phpspec-code-coverage` extension for generating coverage reports.   
This extension requires a `phpspec-coverage.yml` file in your root folder.

### [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

Currently used for fixing the code.   
Fixes all files in `src` directory. Does not implement all PSR-2 rules (yet).

This package is not used for checking (linting), because it can't create
XML reports.

### [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

Currently used for checking (linting) the code.   
Sniffs all files in `src` directory.

This package can also be used for fixing, but it fixes way more than
specified in PSR-2.

### [phpmd/phpmd](https://github.com/phpmd/phpmd)

Used for mess detection.   
Runs the defined ruleset (`config/phpmd.xml`) on all files in `src` directory.

## Installation

The recommended way to install this package is over composer.

**Automatic way:**

```
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
        "coverage": "Karriere\\CodeQuality\\CodeCoverage::run",
        "md": "Karriere\\CodeQuality\\MessDetector::run"
    }
}
```

You can execute the scripts like this:

```
composer test
composer lint
composer fix
composer coverage
composer md
```

> If you are using Git-Shell on Windows (or Git-Shell in Intellij 
> Terminal on Windows), call scripts like this: `composer.bat {script}`.
> Otherwise colors will not work.

These scripts accept arguments:

```
composer test -- -v
composer test -- --verbose
```
```
composer lint -- --env=local (default)
composer lint -- --env=jenkins
```
```
composer coverage -- --env=local (default)
composer coverage -- --env=jenkins
```
```
composer fix -- --tool=php-cs-fixer (default)
composer fix -- --tool=phpcbf
```
```
composer md -- --env=local (default)
composer md -- --env=jenkins
```

You can disable `TTY` by adding the `--notty` flag (needed for Jenkins).   
On Windows platform it's disabled automatically.

```
composer {script} -- --env=jenkins --notty
```
## FAQ

### Why do I have to provide two phpspec configuration files?

The code-coverage-extension slows down the phpspec tests, so we excluded it from the
normal configuration file. Keep tests fast!
