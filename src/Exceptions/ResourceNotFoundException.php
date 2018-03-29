<?php
namespace evolve\Exceptions;

class ResourceNotFoundException extends BaseException
{

	/**
	 * Constructor.
	 *
	 * @param string        $params
	 * @param int           $code
	 * @param Exception $previous
	 */
	public function __construct($resource, $code = 0, $previous = null)
	{
		parent::__construct('Resource not found on storage : '.$this->stringify($resource), $code, $previous);
	}

}