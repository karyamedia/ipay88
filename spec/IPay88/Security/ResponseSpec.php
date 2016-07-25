<?php

namespace spec\IPay88\Security;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use IPay88\Payment\Response;
use IPay88\Payment\Request;

class ResponseSpec extends ObjectBehavior
{
	function let($die)
	{
		$this->beConstructedWith("123key"); //merchant key
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('IPay88\Security\Response');
    }

    function it_validate_ipay88_response_header(Response $response, Request $request)
    {

    	$response->getReferrer()->willReturn("www.mobile88.com");

    	$response->getMerchantCode()->willReturn("123code");
    	$response->getPaymentId()->willReturn(2);
    	$response->getRefNo()->willReturn("12345622");
    	$response->getAmount()->willReturn("1,278.99");
    	$response->getCurrency()->willReturn("MYR");
    	$response->getStatus()->willReturn("1");
    	$response->getSignature()->willReturn("zZphaRvP2ZR0DP+/b+uNMksUPJA=");

    	$this->validate($response)->shouldReturn(true);
    }

    function it_throw_invalid_referrer_exception_when_referrer_is_not_valid(Response $response, Request $request)
    {
    	$response->getReferrer()->willReturn("www.badreferrer.com");

    	$response->getMerchantCode()->willReturn("123code");
    	$response->getPaymentId()->willReturn(2);
    	$response->getRefNo()->willReturn("12345622");
    	$response->getAmount()->willReturn("1,278.99");
    	$response->getCurrency()->willReturn("MYR");
    	$response->getStatus()->willReturn("1");
    	$response->getSignature()->willReturn("zZphaRvP2ZR0DP+/b+uNMksUPJA=");

    	$this->shouldThrow('IPay88\Security\Exceptions\InvalidReferrerException')->during('validate',array($response));
    }

    function it_throw_invalid_signature_exception_when_signature_doesnt_match(Response $response, Request $request)
    {
    	$response->getReferrer()->willReturn("www.mobile88.com");

    	$response->getMerchantCode()->willReturn("123code");
    	$response->getPaymentId()->willReturn(2);
    	$response->getRefNo()->willReturn("12345622");
    	$response->getAmount()->willReturn("1,278.99");
    	$response->getCurrency()->willReturn("MYR");
    	$response->getStatus()->willReturn("1");
    	$response->getSignature()->willReturn("zZphaRvP2ZR0DP+/b+uNMksUPJA=invalid");

    	$this->shouldThrow('IPay88\Security\Exceptions\InvalidSignatureException')->during('validate',array($response));
    }


}
