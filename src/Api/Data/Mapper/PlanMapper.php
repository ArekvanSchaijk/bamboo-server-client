<?php
namespace ArekvanSchaijk\BambooServerClient\Api\Data\Mapper;

use ArekvanSchaijk\BambooServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BambooServerClient\Api\Entity\Plan;

/**
 * Class PlanMapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class PlanMapper extends Adapter
{

    /**
     * Process
     *
     * @return void
     */
    protected function process()
    {
        $data = $this->json();
        if (isset($data->plans->plan)) {
            foreach ($data->plans->plan as $plan) {
                $this->attach(
                    self::map($plan)
                );
            }
        }
    }

    /**
     * Map
     *
     * @param mixed $data
     * @return Plan
     * @static
     */
    static public function map($data)
    {
        $plan = new Plan();
        $plan->setKey((string)$data->key);
        $plan->setShortKey((string)$data->shortKey);
        $plan->setName((string)$data->name);
        $plan->setShortName((string)$data->shortName);
        $plan->setType((string)$data->type);
        $plan->setIsEnabled((bool)$data->enabled);
        $plan->setLink((string)$data->link->href);
        return $plan;
    }

}