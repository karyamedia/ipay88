<?php

namespace spec\IPay88\Payment;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
	function let($die)
	{
		$this->beConstructedWith('123key');
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('IPay88\Payment\Request');
    }

    function it_can_be_statically_generated()
    {
    	$this->make('123key',array(
			'merchantCode' => '123code',
			'paymentId'=> 2,
			'refNo' => '12345',
			'amount'=> '1,278.99',
			'currency' => 'MYR',
			'prodDesc' => 'A test payment',
			'userName' => 'John Doe',
			'userEmail'=> 'john.doe@yopmail.com',
			'userContact' => '0124346785',
			'remark'=> 'This is a test payment from John Doe',
			'lang'  => 'UTF-8',
			'responseUrl'  => 'http://merchant.com/payment/respond',
			'backendUrl'  => 'http://merchant.com/payment/respond/backend'
			))->shouldHaveType('IPay88\Payment\Request');
    }

    function it_can_set_and_get_attributes()
    {
    	$field_values = array(
			'merchantCode' => '123code',
			'paymentId'=> 2,
			'refNo' => '12345',
			'amount'=> '1,278.99',
			'currency' => 'MYR',
			'prodDesc' => 'A test payment',
			'userName' => 'John Doe',
			'userEmail'=> 'john.doe@yopmail.com',
			'userContact' => '0124346785',
			'remark'=> 'This is a test payment from John Doe',
			'lang'  => 'UTF-8',
			'responseUrl'  => 'http://merchant.com/payment/respond',
			'backendUrl'  => 'http://merchant.com/payment/respond/backend'
			);

    	foreach ($field_values as $field => $value) {
    		$set_method = 'set'.ucfirst($field);
    		$get_method = 'get'.ucfirst($field);
    		$this->$set_method($value);
    		$this->$get_method()->shouldReturn($value);
    	}
    }

    function it_can_generate_signature()
    {
    	$field_values = array(
			'merchantCode' => '123code',
			'paymentId'=> 2,
			'refNo' => '12345',
			'amount'=> '1,278.99',
			'currency' => 'MYR',
			'prodDesc' => 'A test payment',
			'userName' => 'John Doe',
			'userEmail'=> 'john.doe@yopmail.com',
			'userContact' => '0124346785',
			'remark'=> 'This is a test payment from John Doe',
			'lang'  => 'UTF-8',
			'responseUrl'  => 'http://merchant.com/payment/respond',
			'backendUrl'  => 'http://merchant.com/payment/respond/backend'
			);

    	foreach ($field_values as $field => $value) {
    		$set_method = 'set'.ucfirst($field);
    		$this->$set_method($value);
    	}

    	$this->getSignature()->shouldReturn('T/jqQC5v0+1FD1Nf/XS9kK2g4kA=');
    }


    /**
    * we dont want to call ipay88 everytime we run the test dont we
    *
    
    function it_can_requery_payment()
    {
    	$this->requery("123code", "12345622", "1,278.99")->shouldHaveType("string");
    }
    */
}
