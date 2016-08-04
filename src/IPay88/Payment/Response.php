<?php

namespace IPay88\Payment;

use IPay88\Security\Signature;

class Response
{
	public static $requeryUrl = 'https://www.mobile88.com/epayment/enquiry.asp';

	private $return;
	public function init($merchantCode, $requery = TRUE, $return_data = TRUE) {
	    $return = array(
			'status' => '',
			'message' => '',
			'data' => array(),
	    );

	    $data = $_POST;
	    $return['status'] = isset($data['Status']) ? $data['Status'] : FALSE;
	    $return['message'] = isset($data['ErrDesc']) ? $data['ErrDesc'] : '';

	    if ($requery) {
			if ($return['status']) {
				$data['_RequeryStatus'] = $this->requery($data);
				if ($data['_RequeryStatus'] != '00') {
					// Requery failed, return NULL array.
					$return['status'] = FALSE;
					return $return;
				}
			}
	    }

	    if ($return_data) {
	    	$return['data'] = $data;
	    }

	    return $return;
	}

	/**
	* Check payment status (re-query).
	*
	* @access public
	* @param array $paymentDetails The following variables are required:
	* - MerchantCode (Optional)
	* - RefNo
	* - Amount
	* @return string Possible payment status from iPay88 server:
	* - 00                 - Successful payment
	* - Invalid parameters - Parameters passed is incorrect
	* - Record not found   - Could not find the record.
	* - Incorrect amount   - Amount differs.
	* - Payment fail       - Payment failed.
	* - M88Admin           - Payment status updated by Mobile88 Admin (Fail)
	*/
    public static function requery($merchantCode, $refNo, $amount) 
    {
        if (!function_exists('curl_init')) {
            trigger_error('PHP cURL extension is required.');
            return false;
        }
        $curl = curl_init(
        			self::$requeryUrl . '?' . http_build_query(array(
		        		'MerchantCode' => $merchantCode,
		        		'RefNo' => $refNo,
		        		'Amount'=> $amount
		        	))
		        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = trim(curl_exec($curl));
        curl_close($curl);

        return $result;
    }

}
