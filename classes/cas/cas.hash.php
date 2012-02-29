<?php
define('SECRET_KEY', 'SECRETKEY');

class CasHash
{
	/*
	 * The RFC recommends a key size larger than the output hash for the
	* hash function you use (16 for md5() and 20 for sha1()).
	*/
	function create_parameters($array) {
		$data = '';
		$ret = array();
		/*
		 * For each variable in the array we a string containing
		* "$key=$value" to an array and concatenate
		* $key and $value to the $data string.
		*/
		foreach ($array as $key => $value) {
			$data .= $key . $value;
			$ret[] = "$key=$value";
		}

		$h = new HMAC(SECRET_KEY, 'md5');
		$hash = $h->hash($data);
		$ret[] = "hash=$hash";
		//return join ('&amp;', $ret);
		return join ('&', $ret);
	}

	function verify_parameters($array) {
		$data = '';
		$ret = array();
		/* Store the hash in a separate variable and unset the hash from
		 * the array itself (as it was not used in constructing the hash
		*/
		$hash = $array['hash'];
		unset ($array['hash']);
		/* Construct the string with our key/value pairs */
		foreach ($array as $key => $value) {
			$data .= $key . $value;
			$ret[] = "$key=$value";
		}
		$h = new HMAC(SECRET_KEY, 'md5');
		if ($hash != $h->hash($data)) {
			return false;
		}
		else {
			return true;
		}
	}

}

class HMAC {

	/**
	 * Constructor
	 * Pass method as first parameter
	 *
	 * @param string method - Hash function used for the calculation
	 * @return void
	 * @access public
	 */
	function __construct($key, $method = 'md5')
	{
		if (!in_array($method, array('sha1', 'md5'))) {
			die("Unsupported hash function '$method'.");
		}
		$this->_func = $method;
		/* Pad the key as the RFC wishes (step 1) */
		if (strlen($key) > 64) {
			$key = pack('H32', $method($key));
		}
		if (strlen($key) < 64) {
			$key = str_pad($key, 64, chr(0));
		}
		/* Calculate the padded keys and save them (step 2 & 3) */
		$this->_ipad = substr($key, 0, 64) ^ str_repeat(chr(0x36), 64);
		$this->_opad = substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64);
	}

	/**
	 * Hashing function
	 *
	 * @param string data - string that will hashed (step 4)
	 * @return string
	 * @access public
	 */
	function hash($data)
	{
		$func = $this->_func;
		$inner = pack('H32', $func($this->_ipad . $data));
		$digest = $func($this->_opad . $inner);
		return $digest;
	}

}
