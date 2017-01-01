<?php
namespace ArekvanSchaijk\BambooServerClient\Api\Data\Mapper;

use ArekvanSchaijk\BambooServerClient\Api\Data\Adapter;
use ArekvanSchaijk\BambooServerClient\Api\Entity\Project;

/**
 * Class ProjectMapper
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class ProjectMapper extends Adapter
{

    /**
     * Process
     *
     * @return void
     */
    protected function process()
    {
        $data = $this->json();
        if (isset($data->projects->project)) {
            foreach ($data->projects->project as $project) {
                $this->attach(
                    self::map($project)
                );
            }
        }
    }

    /**
     * Map
     *
     * @param mixed $data
     * @return Project
     * @static
     */
    static public function map($data)
    {
        $project = new Project();
        $project->setKey((string)$data->key);
        $project->setName((string)$data->name);
        $project->setLink((string)$data->link->href);
        return $project;
    }

}