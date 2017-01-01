<?php
namespace ArekvanSchaijk\BambooServerClient\Api\Entity;
use ArekvanSchaijk\BambooServerClient\Api;

/**
 * Class Plan
 * @author Arek van Schaijk <info@ucreation.nl>
 */
class Plan
{

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $shortKey;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $shortName;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $isEnabled = false;

    /**
     * @var string
     */
    protected $link;

    /**
     * Gets the Key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets the Key
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Gets the ShortKey
     *
     * @return string
     */
    public function getShortKey()
    {
        return $this->shortKey;
    }

    /**
     * Sets the ShortKey
     *
     * @param string $shortKey
     */
    public function setShortKey($shortKey)
    {
        $this->shortKey = $shortKey;
    }

    /**
     * Gets the Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the Name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the ShortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Sets the ShortName
     *
     * @param string $shortName
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * Gets the Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the Type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Gets the Is Enabled
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Sets the IsEnabled
     *
     * @param boolean $isEnabled
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * Gets the Link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the Link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Queue
     *
     * @return void
     */
    public function queue()
    {
        $api = new Api();
        $api->queuePlan($this);
    }

}