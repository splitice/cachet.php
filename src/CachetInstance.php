<?php

namespace DivineOmega\CachetPHP;

use DivineOmega\CachetPHP\Client\IApiClient;
use DivineOmega\CachetPHP\Factories\ComponentFactory;
use DivineOmega\CachetPHP\Factories\IncidentFactory;
use DivineOmega\CachetPHP\Factories\MetricFactory;
use DivineOmega\CachetPHP\Factories\SubscriberFactory;
use DivineOmega\CachetPHP\Models\Component;
use DivineOmega\CachetPHP\Models\Incident;
use DivineOmega\CachetPHP\Models\Metric;
use DivineOmega\CachetPHP\Models\Subscriber;
use GuzzleHttp\Client;

class CachetInstance
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getApiToken()
    {
        return $this->apiToken;
    }

    public function getAuthHeaders()
    {
        $authHeaderKey = 'X-Cachet-Token';
        $authHeaderValue = $this->getApiToken();

        return [
                    $authHeaderKey => $authHeaderValue,
                ];
    }

    /**
     * @return IApiClient
     */
    public function client()
    {
        return $this->client;
    }

    public function ping()
    {
        $response = $this->client->request('ping', 'GET');

        if ($response->getStatusCode() != 200) {
            throw new \Exception('cachet.php: Bad response.');
        }

        $data = $response->getData();

        if (!$data) {
            throw new \Exception('cachet.php: No data received from ping.');
        }

        return $data;
    }

    public function isWorking()
    {
        return $this->ping() == 'Pong!';
    }

    /**
     * @param string $sort
     * @param string $order
     * @return Component[]
     */
    public function getAllComponents($sort = null, $order = null)
    {
        return ComponentFactory::getAll($this, $sort, $order);
    }

    /**
     * @param string $sort
     * @param string $order
     * @return Incident[]
     */
    public function getAllIncidents($sort = null, $order = null)
    {
        return IncidentFactory::getAll($this, $sort, $order);
    }

    /**
     * @param string $sort
     * @param string $order
     * @return Metric[]
     */
    public function getAllMetrics($sort = null, $order = null)
    {
        return MetricFactory::getAll($this, $sort, $order);
    }

    /**
     * @param string $sort
     * @param string $order
     * @return Subscriber[]
     */
    public function getAllSubscribers($sort = null, $order = null)
    {
        return SubscriberFactory::getAll($this, $sort, $order);
    }
}
