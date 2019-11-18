<a href="https://www.karriere.at/" target="_blank"><img width="200" src="http://www.karriere.at/images/layout/katlogo.svg"></a>
<span>&nbsp;&nbsp;&nbsp;</span>
[![Build Status](https://travis-ci.org/karriereat/php-code-quality.svg?branch=master)](https://travis-ci.org/karriereat/php-code-quality)
[![Code Style](https://styleci.io/repos/79470259/shield)](https://styleci.io/repos/79470259)

# Code Quality for PHP packages

This package provides code quality scripts that can be run via
[Composer](https://github.com/composer/composer).

The scripts also work on continous integration (CI) servers like Jenkins. 

## Used packages

### [phpspec/phpspec](https://github.com/phpspec/phpspec)

Used for testing (SpecBDD) the code.   
Must be configured with a `phpspec.yml` file in your root folder.

We are using the `leanphp/phpspec-code-coverage` extension for generating coverage reports.   
This extension requires a `phpspec-coverage.yml` file in your root folder and Xdebug enabled.

### [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

Currently used for fixing the code.   
Fixes all files in `src` directory.

This package is not used for checking (linting), because PHP_Codesniffer prints a 
more readable output.

### [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

Currently used for checking (linting) the code.   
Sniffs all files in `src` directory.

This package could also be used for fixing, but PHP-CS-Fixer does it better.

### [phpmd/phpmd](https://github.com/phpmd/phpmd)

Used for mess detection.   
Runs the defined ruleset (`config/phpmd.xml`) on all files in `src` directory.

## Installation

Run `composer require --dev karriere/code-quality` to install this package.

After installing, insert the desired scripts to your `composer.json`.

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

## Usage

You can run a script like this: `composer {script} -- {options}`.

> If you are using Git-Shell on Windows (or Git-Shell in Intellij 
> Terminal on Windows), call scripts like this: `composer.bat {script}`.
> Otherwise colors will not work.

You can disable `TTY` by adding the `--notty` flag (needed for Jenkins).   
On Windows platform it's disabled automatically.

```
composer {script} -- --env=jenkins --notty
```

### Scripts

#### `test`

```
Usage:
  test [--] [options]

Options:
      --fail     Exit with 1 if tests fail.
      --notty    Disable TTY.
      --ptimeout Set process timeout (defaults to 60 seconds).
   -v --verbose  Increase the verbosity of messages.
```

#### `coverage`

```
Usage:
  coverage [--] [options]

Options:
      --env       Specifiy the environment. Possible values:
                  'local': prints output on command-line.
                  'jenkins': generates a JUnit report file.
      --notty     Disable TTY.
      --ptimeout  Set process timeout (defaults to 60 seconds).
```

#### `lint`

```
Usage:
  lint [--] [options]

Options:
      --env       Specifiy the environment. Possible values:
                  'local': prints output on command-line.
                  'jenkins': generates a checkstyle report file.
      --fail      Exit with 1 if linting fails.
      --notty     Disable TTY.
      --ptimeout  Set process timeout (defaults to 60 seconds).
```

#### `md`

```
Usage:
  lint [--] [options]

Options:
      --env       Specifiy the environment. Possible values:
                  'local': prints output on command-line.
                  'jenkins': generates a xml report file.
      --notty     Disable TTY.
      --ptimeout  Set process timeout (defaults to 60 seconds).
```

#### `fix`

```
Usage:
  fix [--] [options]

Options:
      --notty     Disable TTY.
      --ptimeout  Set process timeout (defaults to 60 seconds).
```

## Using custom matchers

This package integrates [karriere/phpspec-matchers](https://github.com/karriereat/phpspec-matchers).
In order to use the custom matchers defined in this package,
please include the extension configuration in your `phpspec.yml`.

## FAQ

### Why do I have to provide two phpspec configuration files?

The code-coverage-extension slows down the phpspec tests, so we excluded it from the
normal configuration file. Keep tests fast!

### How do I increase the verbosity of the `test`-script output?

Run `composer test -- -v`.
