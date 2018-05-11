<?php
namespace GrShareCode\Contact;

/**
 * Class CustomField
 * @package GrShareCode\Contact
 */
class CustomField
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $value;

    /**
     * @param string $id
     * @param $name
     * @param string $value
     */
    public function __construct($id, $name, $value = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
