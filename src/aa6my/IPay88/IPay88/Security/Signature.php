<?php

namespace IPay88\Security;

class Signature
{
	/**
     * Generate signature to be used for transaction.
     *
     * You may verify your signature with online tool provided by iPay88
     * http://www.mobile88.com/epayment/testing/TestSignature.asp
     *
     * @access public
     * 
     * accept arbitary amount of params
     * @example IPay88\Security\Signature::generateSignature($key,$code,$refNo,$amount,$currency,[, $status])
     */
    public static function generateSignature()
    {
        $stringToHash = implode('',func_get_args());
        return base64_encode(self::_hex2bin(sha1($stringToHash)));
    }

    /**
    *
    * equivalent of php 5.4 hex2bin
    *
    * @access private
    * @param string $source The string to be converted
    */
    private static function _hex2bin($source)
    {
    	$bin = null;
    	for ($i=0; $i < strlen($source); $i=$i+2) { 
    		$bin .= chr(hexdec(substr($source, $i, 2)));
    	}
    	return $bin;
    }
}
