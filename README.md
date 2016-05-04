# Karriere Code Quality

Code Quality functions for Composer scripts.

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
