<?php namespace IPay88\Security\Exceptions;

class InvalidSignatureException extends \Exception
{
	protected $message = 'Signature mismatch';
}