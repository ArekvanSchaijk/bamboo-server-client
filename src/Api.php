<?php
namespace ArekvanSchaijk\BambooServerClient;

use ArekvanSchaijk\BambooServerClient\Api\Data\Mapper\PlanMapper;
use ArekvanSchaijk\BambooServerClient\Api\Data\Mapper\ProjectMapper;
use ArekvanSchaijk\BambooServerClient\Api\Entity\Plan;
use ArekvanSchaijk\BambooServerClient\Api\Entity\Project;
use ArekvanSchaijk\BambooServerClient\Api\Exception\ConflictException;
use ArekvanSchaijk\BambooServerClient\Api\Exception\UnauthorizedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

/**
 * Class Api
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class Api
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    static protected $endpoint;

    /**
     * @var array
     */
    static protected $options = ['headers' => ['Accept' => 'application/json']];

    /**
     * Sets the Endpoint
     *
     * @param string $endpoint
     * @return void
     */
    public function setEndpoint($endpoint)
    {
        self::$endpoint = rtrim($endpoint, '/');
    }

    /**
     * Login
     *
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        self::$options = array_merge(self::$options, ['auth' => [$username, $password]]);
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        unset(self::$options['auth']);
    }

    /**
     * Gets the Client
     *
     * @return Client
     */
    protected function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client();
        }
        return $this->client;
    }

    /**
     * Gets the Projects
     *
     * @return ProjectMapper
     */
    public function getProjects()
    {
        try {
            $response = $this->getClient()->request('GET', self::$endpoint . '/rest/api/latest/project', self::$options);
            return new ProjectMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Gets a Project
     *
     * @param string $projectKey
     * @return Project
     */
    public function getProject($projectKey)
    {
        try {
            $response = $this->getClient()->request('GET', self::$endpoint . '/rest/api/latest/project/'
                . $projectKey, self::$options);
            return self::mapSingleResponse($response, ProjectMapper::class);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Gets the Plans
     *
     * @return PlanMapper
     */
    public function getPlans()
    {
        try {
            $response = $this->getClient()->request('GET', self::$endpoint . '/rest/api/latest/plan', self::$options);
            return new PlanMapper($response);
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    public function queuePlan(Plan $plan)
    {
        $options = array_merge(self::$options, [
            'form_params' => [
                'executeAllStages' => true
            ]
        ]);
        try {
            $response = $this->getClient()->request('POST', self::$endpoint . '/rest/api/latest/queue/'
                . $plan->getKey(), $options);
            print_r(\GuzzleHttp\json_decode($response->getBody()));
        } catch (\Exception $exception) {
            $this->exceptionHandler($exception);
        }
    }

    /**
     * Exception Handler
     *
     * @param \Exception $exception
     * @return void
     * @throws ConflictException
     * @throws Exception
     * @throws UnauthorizedException
     */
    protected function exceptionHandler(\Exception $exception)
    {
        if ($exception instanceof ClientException) {
            $statusCode = $exception->getResponse()->getStatusCode();
            // Tries to resolve the initial error message by Atlassian
            $errorMessage = null;
            try {
                $json = \GuzzleHttp\json_decode($exception->getResponse()->getBody());
                $errorMessage = (isset($json->errors[0]->message) ? $json->errors[0]->message : null);
            } catch (\Exception $jsonDecodeException) {
                // Here we do just nothing ;)
            }
            switch ($statusCode) {
                case 401:
                    throw new UnauthorizedException(($errorMessage ?: $exception));
                    break;
                case 409:
                    throw new ConflictException(($errorMessage ?: $exception));
                    break;
                default:
                    throw new Exception(($errorMessage ?: $exception));
            }
        }
        throw new Exception($exception);
    }

    /**
     * Maps Single Response
     *
     * @param Response $response
     * @param string $mapper
     * @return mixed
     * @static
     */
    static public function mapSingleResponse(Response $response, $mapper)
    {
        return $mapper::map(\GuzzleHttp\json_decode($response->getBody()));
    }

}