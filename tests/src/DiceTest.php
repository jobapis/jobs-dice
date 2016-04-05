<?php namespace JobBrander\Jobs\Client\Providers\Test;

use JobBrander\Jobs\Client\Providers\Dice;
use Mockery as m;

class DiceTest extends \PHPUnit_Framework_TestCase
{
    private $clientClass = 'JobBrander\Jobs\Client\Providers\AbstractProvider';
    private $collectionClass = 'JobBrander\Jobs\Client\Collection';
    private $jobClass = 'JobBrander\Jobs\Client\Job';

    public function setUp()
    {
        $this->client = new Dice(['keyword'=>'engineering']);
    }

    public function testItWillUseJsonFormat()
    {
        $format = $this->client->getFormat();

        $this->assertEquals('json', $format);
    }

    public function testItWillUseGetHttpVerb()
    {
        $verb = $this->client->getVerb();

        $this->assertEquals('GET', $verb);
    }

    public function testListingPath()
    {
        $path = $this->client->getListingsPath();

        $this->assertEquals('resultItemList', $path);
    }

    public function testItCanAddDirectAttribute()
    {
        $attribute = uniqid();

        $this->client->setDirect($attribute);
        
        $value = $this->client->queryParams['direct'];
        
        $this->assertEquals($attribute, $value);
    }

    public function testItCanAddCountAttribute()
    {
        $attribute = rand()*10;

        $this->client->setCount($attribute);
        
        $value = $this->client->getPgcnt();
        
        $this->assertEquals($attribute, $value);
    }

    public function testUrlIncludesKeywordWhenProvided()
    {
        $keyword = uniqid().' '.uniqid();
        $param = 'text='.urlencode($keyword);

        $url = $this->client->setKeyword($keyword)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesKeywordWhenNotProvided()
    {
        $param = 'text=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCityWhenCityProvided()
    {
        $city = uniqid();
        $param = 'city='.urlencode($city);

        $url = $this->client->setCity($city)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlIncludesStateWhenStateProvided()
    {
        $state = uniqid();
        $param = 'state='.urlencode($state);

        $url = $this->client->setState($state)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesCityWhenNotProvided()
    {
        $param = 'city=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlNotIncludesStateWhenNotProvided()
    {
        $param = 'state=';

        $url = $this->client->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesPageWhenProvided()
    {
        $page = uniqid();
        $param = 'page='.$page;

        $url = $this->client->setPage($page)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesPageWhenNotProvided()
    {
        $param = 'page=';

        $url = $this->client->setPage(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testUrlIncludesCountWhenProvided()
    {
        $count = uniqid();
        $param = 'pgcnt='.$count;

        $url = $this->client->setCount($count)->getUrl();

        $this->assertContains($param, $url);
    }

    public function testUrlNotIncludesStartWhenNotProvided()
    {
        $param = 'pgcnt=';

        $url = $this->client->setCount(null)->getUrl();

        $this->assertNotContains($param, $url);
    }

    public function testItCanCreateJobFromPayload()
    {
        $payload = $this->createJobArray();

        $results = $this->client->createJobObject($payload);

        $this->assertEquals($payload['jobTitle'], $results->title);
        $this->assertEquals($payload['company'], $results->company);
        $this->assertEquals($payload['location'], $results->location);
        $this->assertEquals($payload['detailUrl'], $results->url);
    }

    public function testItCanConnect()
    {
        $provider = $this->getProviderAttributes();

        for ($i = 0; $i < $provider['jobs_count']; $i++) {
            $payload['resultItemList'][] = $this->createJobArray();
        }

        $responseBody = json_encode($payload);

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($provider['keyword'])
            ->times($provider['jobs_count'])->andReturnSelf();
        $job->shouldReceive('setSource')->with($provider['source'])
            ->times($provider['jobs_count'])->andReturnSelf();

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn($responseBody);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($this->client->getVerb()))
            ->with($this->client->getUrl(), $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($provider['jobs_count'], $results);
    }

    public function testItCanRetreiveResults()
    {
        if (!getenv('LIVE')) {
            $this->markTestSkipped('LIVE variable not set. Real API call will not be made.');
        }

        $keyword = 'engineering';
        $this->client->setKeyword($keyword);
        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        foreach($results as $job) {
            $this->assertEquals($keyword, $job->query);
        }
    }

    private function createJobArray($num = 10) {
        return [
            'jobTitle' => uniqid(),
            'company' => uniqid(),
            'location' => uniqid().', '.uniqid(),
            'date' => '2015-07-'.rand(1,31),
            'detailUrl' => uniqid(),
        ];
    }

    private function getProviderAttributes($attributes = [])
    {
        $defaults = [
            'path' => uniqid(),
            'format' => 'json',
            'keyword' => uniqid(),
            'source' => uniqid(),
            'params' => [uniqid()],
            'jobs_count' => rand(2,10),

        ];
        return array_replace($defaults, $attributes);
    }
}
