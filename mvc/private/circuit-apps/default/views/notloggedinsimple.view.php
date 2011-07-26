<?php

/**
 * Displays a simple not logged in error page
 * Standardized view for not logged in users
 * Allows a single message for users who are not logged in
 * Use this view when you need a short not logged in page, such as in AJAX or API calls.
 * @author Jenn T <jtsai@gaiaonline.com>
 **/

class Default_NotLoggedInSimple_CircuitView extends CircuitView {
    
    public function execute(CircuitController $c) {
        $title = '您还没有登录';
        $message = '您必须登录后才能看到这部分内容.';
        die("<h2>$title</h2><p>$message</p>");
    }
}