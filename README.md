# Dice Jobs Client

[![Latest Version](https://img.shields.io/github/release/jobapis/jobs-dice.svg?style=flat-square)](https://github.com/jobapis/jobs-dice/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jobapis/jobs-dice/master.svg?style=flat-square&1)](https://travis-ci.org/jobapis/jobs-dice)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/JobBrander/jobs-dice.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-dice/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobapis/jobs-dice.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-dice)
[![Total Downloads](https://img.shields.io/packagist/dt/jobapis/jobs-dice.svg?style=flat-square)](https://packagist.org/packages/jobapis/jobs-dice)

DEPRECATION NOTICE: As of [October, 2017 the Dice Jobs API has been shut down](https://github.com/jobapis/jobs-dice/issues/8). Dice has given me no reason for this, but there's nothing I can do about it. This library no longer works, and everything outlined below is just here for history's sake.

To contact Dice, [please fill out this form on their website](http://techhub.dice.com/Dice_General-ContactUs_D.html).

~~This package provides [Dice Jobs API](http://www.dice.com/common/content/util/apidoc/jobsearch.html)
support for the JobBrander's [Jobs Client](https://github.com/jobapis/jobs-common).~~

## Installation

To install, use composer:

```
composer require jobapis/jobs-dice
```

## Usage

Create a Query object and add all the parameters you'd like via the constructor.
 
```php
// Add parameters to the query via the constructor
$query = new JobApis\Jobs\Client\Queries\DiceQuery([
    'text' => 'engineering'
]);
```

Or via the "set" method. All of the parameters documented in the API's documentation can be added.

```php
// Add parameters via the set() method
$query->set('skill', 'soldering');
```

You can even chain them if you'd like.

```php
// Add parameters via the set() method
$query->set('state', 'Illinois')
    ->set('city', 'Chicago')
    ->set('country', 'United States');
```
 
Then inject the query object into the provider.

```php
// Instantiating provider with a query object
$client = new JobApis\Jobs\Client\Provider\DiceProvider($query);
```

And call the "getJobs" method to retrieve results.

```php
// Get a Collection of Jobs
$jobs = $client->getJobs();
```

This will return a [Collection](https://github.com/jobapis/jobs-common/blob/master/src/Collection.php) of [Job](https://github.com/jobapis/jobs-common/blob/master/src/Job.php) objects.

## Testing

To run all tests except for actual API calls
``` bash
$ ./vendor/bin/phpunit
```

To run all tests including actual API calls
``` bash
$ REAL_CALL=1 ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/jobapis/jobs-dice/contributors)

## License

The Apache 2.0. Please see [License File](https://github.com/jobapis/jobs-dice/blob/master/LICENSE) for more information.
