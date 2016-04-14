<?php
namespace AppBundle\Application\Exception;

/**
 * @author Albert Colom <skolom@gmail.com>
 */
class InvalidFormException extends \RuntimeException
{
    protected $form;

    /**
     * @param string $message
     * @param int $code
     * @param null $form
     */
    public function __construct($message, $code = 0, $form = null)
    {
        parent::__construct($message, $code);
        $this->form = $form;
    }

    /**
     * @return array|null
     */
    public function getForm()
    {
        return $this->form;
    }
}