<?php 
use IPay88\RequestForm;

class IPay88
{
	private $merchantKey = null;
	public $merchantCode = null;
	public $responseUrl = null;
	public $backendResponseUrl = null;

	public function __construct($merchantKey, $merchantCode, $responseUrl, $backendResponseUrl)
	{
		$this->merchantKey = $merchantKey;
		$this->merchantCode= $merchantCode;
		$this->responseUrl = $responseUrl;
		$this->backendResponseUrl = $backendResponseUrl;
	}
	
	/**
     * Generate signature to be used for transaction.
     *
     * You may verify your signature with online tool provided by iPay88
     * http://www.mobile88.com/epayment/testing/TestSignature.asp
     *
     * @access public
     * @param string $merchantKey ProvidedbyiPay88OPSGandsharebetweeniPay88and merchant only
     * @param string $merchantCode Merchant Code provided by iPay88 and use to uniquely identify the Merchant.
     * @param string $refNo Unique merchant transaction id
     * @param int $amount Payment amount
     * @param string $currency Payment currency
     */
    public function generateSignature($refNo, $amount, $currency)
    {
        $stringToHash = $this->merchantKey.$this->merchantCode.$refNo.$amount.$currency;
        return base64_encode(self::_hex2bin(sha1($stringToHash)));
    }

    /**
    *
    * equivalent of php 5.4 hex2bin
    *
    * @access private
    * @param string $source The string to be converted
    */
    private function _hex2bin($source)
    {
    	$bin = null;
    	for ($i=0; $i < strlen($source); $i=$i+2) { 
    		$bin .= chr(hexdec(substr($source, $i, 2)));
    	}
    	return $bin;
    }

    /**
    * @access public
    * @param boolean $multiCurrency Set to true to get payments optinos for multi currency gateway
    */
    public static function getPaymentOptions($multiCurrency = false)
    {
        $myrOnly = array(
        	2 => array('Credit Card','MYR'),
        	6 => array('Maybank2U','MYR'),
        	8 => array('Alliance Online','MYR'),
        	10=> array('AmOnline','MYR'),
        	14=> array('RHB Online','MYR'),
        	15=> array('Hong Leong Online','MYR'),
        	16=> array('FPX','MYR'),
        	20=> array('CIMB Click', 'MYR'),
        	22=> array('Web Cash','MYR'),
        	48=> array('PayPal','MYR'),
        	100 => array('Celcom AirCash','MYR'),
        	102 => array('Bank Rakyat Internet Banking','MYR'),
        	103 => array('AffinOnline','MYR')
        	);

        $multiCurrency = array(
        	25=> array('Credit Card','USD'),
        	35=> array('Credit Card','GBP'),
        	36=> array('Credit Card','THB'),
        	37=> array('Credit Card','CAD'),
        	38=> array('Credit Card','SGD'),
        	39=> array('Credit Card','AUD'),
        	40=> array('Credit Card','MYR'),
        	41=> array('Credit Card','EUR'),
        	42=> array('Credit Card','HKD'),
        	);

        return $multiCurrency ? $multiCurrency : $myrOnly;
    }

    /**
    * @access public
    * @param 
    */
    public function makeRequestForm($args)
    {
    	$args['merchantCode'] = $this->merchantCode;
    	$args['signature'] = $this->generateSignature(
    		$args['refNo'],
    		(int) $args['amount'],
    		$args['currency']
    		);
    	$args['responseUrl'] = $this->responseUrl;
    	$args['backendUrl'] = $this->backendResponseUrl;

        return new IPay88\RequestForm($args);
    }
}
