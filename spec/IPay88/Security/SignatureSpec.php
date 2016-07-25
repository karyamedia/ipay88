<?php

namespace spec\IPay88\Security;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignatureSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('IPay88\Security\Signature');
    }
    
    function it_can_generate_signature()
    {
    	$this->generateSignature(
    		'123key', //merchant key
    		'123code', //merchant code
    		'2020', //ref no
    		1000, //amount
    		'MYR' //currency
    		)->shouldReturn("kUPITSSTPGSpDWUf5THV/y8V6xQ=");

    	$this->generateSignature(
    		'abx12guru65',
    		'hash34thew928',
    		'263528201',
    		1000000,
    		'MYR'
    		)->shouldReturn("KUT68Ks8QechAHJI9TilgNEEktQ=");
    }
}
