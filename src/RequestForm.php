<?php

namespace Ipay88;

use Mustache;
class RequestForm
{
	private $engine = null;
	private $template = 'responseForm';

	public $paymentId = null;
	public $refNo = null;

	public __construct($args)
	{
		$this->engine = new Mustache_Engine;
	}

    public function render($args)
    {
        $this->engine->load($this->template);
    }

    public function setTemplate($template)
    {
    	$this->template = $template;
    }
}
