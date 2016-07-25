<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IPay88Spec extends ObjectBehavior
{
	function let($die)
	{
		$this->beConstructedWith(
			"12345", //merchant key
			"12345", //merchant code
			"http://www.example.com/payment/response/", //response url
			"http://www.example.com/payment/response/backend" //backend url
			); 
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('IPay88');
    }

    function it_can_generate_signature()
    {
    	/**
    	* the signature value is retrieve from Ipay88 signature test tool
     	* http://www.mobile88.com/epayment/testing/TestSignature.asp
    	*/

    	$this->generateSignature(
    		"2020", //ref no
    		1000, //amount
    		"MYR" //currency
    		)->shouldReturn("ZT/zioXeYSAzPQJlH/U5JnnMPmM=");
    }

    function it_can_give_payment_options()
    {
    	$this->getPaymentOptions()->shouldBeArray();
    	$this->getPaymentOptions(true)->shouldBeArray();
    }

    function it_can_create_form_object()
    {
    	$this->makeRequestForm(array(
    		'paymentId' => '2',
    		'refNo' => '2020',
    		'amount'=> '1.00',
    		'currency'=> 'MYR',
    		'prodDesc'=> 'A test payment description',
    		'userName'=> 'John Doe',
    		'userEmail' => 'john.doe@yopmail.com',
    		'userContact' => '0124345454',
    		'remark'=> 'A test payment remark',
    		'lang' => 'UTF-8',
    		))->shouldBeAnInstanceOf('Ipay88\RequestForm');
    }
}
