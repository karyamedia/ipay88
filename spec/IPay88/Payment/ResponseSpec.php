<?php

namespace spec\IPay88\Payment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
	function let($die)
	{
		$this->beConstructedWith('123key'); //merchant key
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('IPay88\Payment\Response');
    }

}
