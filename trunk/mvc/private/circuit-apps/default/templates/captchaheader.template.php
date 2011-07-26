<?php if ($this->get('show_captcha')) require_once DIR_CLASSES . 'recaptchalib.php'; ?>

<? if ($this->get('show_captcha')): ?>
<script type="text/javascript">
    var RecaptchaOptions = {
       theme: 'custom',
       custom_theme_widget: 'recaptcha_widget'
    };
</script>
<? endif; ?>
