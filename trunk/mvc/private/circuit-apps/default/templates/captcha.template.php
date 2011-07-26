<?  //使用了新的验证机制
	if ($this->get('show_captcha')):
		$key=Captcha::generateKey();
	?>
    <div id="recaptcha_widget">
        <div id="recaptcha_switch">
            <label class="recaptcha_only_if_image">请输入下面题目中的结果:</label>
            <div class="clear"></div>
        </div>
        <div id="recaptcha_image"><img src='/gaia/captcha.php?key=<?=$key?>'></div>
        <input type="text" name="recaptcha_response_field" maxlength="10" />
		<input type="hidden" id="recaptcha_challenge_field" name="recaptcha_challenge_field" value="<?=$key?>" />
    </div>
<? endif; ?>