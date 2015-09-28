# Dice Jobs Client

[![Latest Version](https://img.shields.io/github/release/JobBrander/jobs-dice.svg?style=flat-square)](https://github.com/JobBrander/jobs-dice/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/JobBrander/jobs-dice/master.svg?style=flat-square&1)](https://travis-ci.org/JobBrander/jobs-dice)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/JobBrander/jobs-dice.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-dice/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/JobBrander/jobs-dice.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-dice)
[![Total Downloads](https://img.shields.io/packagist/dt/jobbrander/jobs-dice.svg?style=flat-square)](https://packagist.org/packages/jobbrander/jobs-dice)

This package provides [Dice Jobs API](http://www.dice.com/common/content/util/apidoc/jobsearch.html)
support for the JobBrander's [Jobs Client](https://github.com/JobBrander/jobs-common).

## Installation

To install, use composer:

```
composer require jobbrander/jobs-dice
```

## Usage

Usage is the same as Job Branders's Jobs Client, using `\JobBrander\Jobs\Client\Provider\Dice` as the provider.

```php
$client = new JobBrander\Jobs\Client\Provider\Dice();

$jobs = $client
    // API parameters
    ->setDirect()    //  (optional) if the value of this parameter is "1" then jobs returned will be direct hire
    ->setAreacode()    //  (optional) specify the jobs area code
    ->setCountry()    //  (optional) specify the jobs ISO 3166 country code
    ->setState()    //  (optional) specify the jobs United States Post Office state code
    ->setSkill()    //  (optional) specify search text for the jobs skill property
    ->setCity()    //  (optional) specify the jobs United States Post Office ZipCode as the center of 40 mile radius
    ->setText()    //  (optional) specify search text for the jobs entire body
    ->setIp()    //  (optional) specify an IP address that will be used to look up a geocode which will be used in the search
    ->setAge()    //  (optional) specify a posting age (a.k.a. days back)
    ->setDiceid()    //  (optional) specify a Dice customer ID to find only jobs from that company
    ->setPage()    //  (optional) specify a page number of the results to be displayed (1 based)
    ->setPgcnt()    //  (optional) specify the number of results per page
    ->setSort()    //  (optional) specify a sort paremeter; sort=1 sorts by posted age, sort=2 sorts by job title, sort=3 sorts by company, sort=4 sorts by location
    ->setSd()    //  (optional) sort direction; sd=a sort order is ASCENDING sd=d sort order is DESCENDING
    // JobBrander parameters
    ->setKeyword('project manager') // The search text/keywords for the jobs entire body
    ->setCount(200)         // Specify the number of results per page
    ->getJobs();
```

The `getJobs` method will return a [Collection](https://github.com/JobBrander/jobs-common/blob/master/src/Collection.php) of [Job](https://github.com/JobBrander/jobs-common/blob/master/src/Job.php) objects.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/jobbrander/jobs-dice/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/jobbrander/jobs-dice/contributors)

## License

The Apache 2.0. Please see [License File](https://github.com/jobbrander/jobs-dice/blob/master/LICENSE) for more information.
