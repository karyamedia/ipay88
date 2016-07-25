<?php

namespace IPay88\Payment;

use IPay88\Security\Signature;

class Response
{
	private $merchantKey;
	public function __construct($merchantKey)
    {
    	$this->merchantKey = $merchantKey;
    }

    private $referrer;
    public function getReferrer()
    {
    	return $this->referrer;
    }

    public function setReferrer($val)
    {
    	return $this->referrer = $val;
    }

	private $merchantCode;
	public function getMerchantCode()
	{
		return $this->merchantCode;
	}

	public function setMerchantCode($val)
	{
		return $this->merchantCode = $val;
	}

	private $paymentId;
	public function getPaymentId()
	{
		return $this->paymentId;
	}

	public function setPaymentId($val)
	{
		return $this->paymentId = $val;
	}

	private $refNo;
	public function getRefNo()
	{
		return $this->refNo;
	}

	public function setRefNo($val)
	{
		return $this->refNo = $val;
	}

	private $amount;
	public function getAmount()
	{
		return $this->amount;
	}

	public function setAmount($val)
	{
		return $this->amount = $val;
	}

	private $currency;
	public function getCurrency()
	{
		return $this->currency;
	}

	public function setCurrency($val)
	{
		return $this->currency = $val;
	}

	private $remark;
	public function getRemark()
	{
		return $this->remark;
	}

	public function setRemark($val)
	{
		return $this->remark = $val;
	}

	private $transId;
	public function getTransId()
	{
		return $this->transId;
	}

	public function setTransId($val)
	{
		return $this->transId = $val;
	}

	private $authCode;
	public function getAuthCode()
	{
		return $this->authCode;
	}

	public function setAuthCode($val)
	{
		return $this->authCode = $val;
	}

	private $status;
	public function getStatus()
	{
		return $this->status;
	}

	public function setStatus($val)
	{
		return $this->status = $val;
	}

	private $errDesc;
	public function getErrDesc()
	{
		return $this->errDesc;
	}

	public function setErrDesc($val)
	{
		return $this->errDesc = $val;
	}

	private $signature;
	public function getSignature()
	{
		return $this->signature;
	}

	public function setSignature($val)
	{
		return $this->signature = $val;
	}

	public function isValid()
	{
		return Signature::generateSignature(
				$this->merchantKey, 
				$this->getMerchantCode(),
				$this->getPaymentId(),
				$this->getRefNo(), 
				preg_replace('/[\.\,]/', '', $this->getAmount()), 
				$this->getCurrency(),
				$this->getStatus()
			) == $this->getSignature();
	}

	protected static $fillable_fields = [
		'referrer','merchantCode','paymentId','refNo','amount',
		'currency','remark','transId','authCode','status',
		'errDesc','signature'
	];

	/**
	* IPay88 Payment Response factory function
	*
	* @access public
	* @param string $merchantKey The merchant key provided by ipay88
	* @param hash $fieldValues Set of field value that is to be set as the properties
	*  Override `$fillable_fields` to determine what value can be set during this factory method
	* @example
	*  $response = IPay88\Payment\Response::make($merchantKey, $fieldValues)
	* 
	*/
	public static function make($merchantKey, $fieldValues)
	{
		$request = new Response($merchantKey);
		foreach(self::$fillable_fields as $field)
		{
			if(isset($fieldValues[$field]))
			{
				$method = 'set'.ucfirst($field);
				$request->$method($fieldValues[$field]);
			}
		}

		return $request;
	}

}
