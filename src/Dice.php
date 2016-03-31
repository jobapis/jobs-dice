<?php namespace JobBrander\Jobs\Client\Providers;

use JobBrander\Jobs\Client\Job;

class Dice extends AbstractProvider
{
    /**
     * Base API Url
     *
     * @var string
     */
    protected $baseUrl = 'http://service.dice.com/api/rest/jobsearch/v1/simple.json?';

    /**
     * Map of setter methods to query parameters
     *
     * @var array
     */
    protected $queryMap = [
        'setKeyword' => 'text',
        'setCount' => 'pgcnt',
    ];

    /**
     * Current api query parameters
     *
     * @var array
     */
    protected $queryParams = [
        'age' => null,
        'areacode' => null,
        'city' => null,
        'country' => null,
        'diceid' => null,
        'direct' => null,
        'ip' => null,
        'page' => null,
        'pgcnt' => null,
        'sd' => null,
        'skill' => null,
        'sort' => null,
        'state' => null,
        'text' => null,
    ];

    /**
     * Returns the standardized job object
     *
     * @param array $payload
     *
     * @return \JobBrander\Jobs\Client\Job
     */
    public function createJobObject($payload)
    {
        $defaults = [
            'jobTitle',
            'company',
            'location',
            'date',
            'detailUrl'
        ];

        $payload = static::parseAttributeDefaults($payload, $defaults);

        $job = new Job([
            'title' => $payload['jobTitle'],
            'name' => $payload['jobTitle'],
            'url' => $payload['detailUrl'],
            'location' => $payload['location'],
        ]);

        $location = static::parseLocation($payload['location']);

        $job->setCompany($payload['company'])
            ->setDatePostedAsString($payload['date']);

        if (isset($location[0])) {
            $job->setCity($location[0]);
        }
        if (isset($location[1])) {
            $job->setState($location[1]);
        }

        return $job;
    }

    /**
     * Get data format
     *
     * @return string
     */
    public function getFormat()
    {
        return 'json';
    }

    /**
     * Get keyword for search query
     *
     * @return string Should return the value of the parameter describing this query
     */
    public function getKeyword()
    {
        return $this->queryParams['text'];
    }

    /**
     * Get listings path
     *
     * @return  string
     */
    public function getListingsPath()
    {
        return 'resultItemList';
    }

    /**
     * Get query string for client based on properties
     *
     * @return string
     */
    public function getQueryString()
    {
        return http_build_query($this->queryParams);
    }

    /**
     * Get http verb
     *
     * @return  string
     */
    public function getVerb()
    {
        return 'GET';
    }

    /**
     * Attempts to update current query parameters.
     *
     * @param  string  $value
     * @param  string  $key
     *
     * @return Careerbuilder
     */
    protected function updateQuery($value, $key)
    {
        if (array_key_exists($key, $this->queryParams)) {
            $this->queryParams[$key] = $value;
        }
        return $this;
    }
}
