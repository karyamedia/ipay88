<?php

namespace IPay88\Payment;

use IPay88\Security\Signature;

class Response
{
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

}
