# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Releases

### [0.1.9] - 2023-06-25

* Composer update
* Fix package description

### [0.1.8] - 2023-01-22

* Rename CheckerArray::checkSimple to CheckerArray::checkSequential.
* Rename CheckerArray::checkIndexArraySimple to CheckerArray::checkIndexArraySequential.

### [0.1.7] - 2023-01-13

* Add documentation

### [0.1.6] - 2023-01-13

* Refactoring
* Add documentation

### [0.1.5] - 2023-01-10

* Add Checker::checkArrayFlat

### [0.1.4] - 2023-01-10

* Add Checker::checkArrayString

### [0.1.3] - 2022-12-30

* Remove .phpunit.result.cache from repository

### [0.1.2] - 2022-12-30

* Change README.md description.

### [0.1.1] - 2022-12-30

* Change README.md description.

### [0.1.0] - 2022-12-30

* Initial release
* Add src
* Add tests
  * PHP Coding Standards Fixer
  * PHPMND - PHP Magic Number Detector
  * PHPStan - PHP Static Analysis Tool
  * PHPUnit - The PHP Testing Framework
  * Rector - Instant Upgrades and Automated Refactoring
* Add README.md
* Add LICENSE.md

## Add new version

```bash
# Checkout master branch
$ git checkout main && git pull

# Check current version
$ vendor/bin/version-manager --current

# Increase patch version
$ vendor/bin/version-manager --patch

# Change changelog
$ vi CHANGELOG.md

# Push new version
$ git add CHANGELOG.md VERSION && git commit -m "Add version $(cat VERSION)" && git push

# Tag and push new version
$ git tag -a "$(cat VERSION)" -m "Version $(cat VERSION)" && git push origin "$(cat VERSION)"
```
