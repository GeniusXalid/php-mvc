<?php

require_once DIR_CLASSES . 'recaptchalib.php';

/**
 * validateCaptcha class
 * Currently, we'll only use this to validate, but we may expand it in the future.
 * NOTE: If you're using this function in legacy code, you MUST wrap it in TRY/CATCH to return an error view!
 * @package default
 * @author Rich Martin
 * @dependencies recaptchalib.php
 **/
class Default_Captcha_CircuitModel
{

	/**
	 * validate function
	 * Validate the response and challenge strings of a recaptcha captcha.
	 * @return bool
	 * @author Rich Martin
	 **/
	public function validate($response, $challenge) 
	{
        // validate captcha
        $privatekey = "6Lc96AAAAAAAAM8m1ok23XZpJxWKD7iGagzckTab";
        $resp = recaptcha_check_answer ($privatekey,
                                        decode_ip( USER_IP ),
                                        $challenge,
                                        $response);

		// needless to say, blow up if it's wrong.
        if ( (bool) $resp->is_valid == FALSE && ! empty($resp->error) ) throw new CircuitValidationException("Please fill in the two words to submit your entry.");

        return TRUE;
	}

} // END class 

?>