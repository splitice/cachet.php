<?php

namespace DivineOmega\CachetPHP\Models;

use DivineOmega\CachetPHP\CachetInstance;

class MetricPoint extends ModelBase
{
    public $id;
    public $value;
    public $metric = null;

    public function __construct(Metric $metric, $row = [], CachetInstance $cachetInstance = null)
    {
        $this->metric = $metric;

        parent::__construct($row, $cachetInstance);
    }

    public function save()
    {
        $queryParams = [];

        $queryParams['value'] = $this->value;

        $this->cachetInstance->client()->request('metrics/'.$this->metric->id.'/points/'.$this->id, $queryParams, 'PUT');
    }

    protected function getApiType()
    {
        return 'metrics';
    }

    public function getId()
    {
        return $this->metric->id.'/points/'.$this->id;
    }
}