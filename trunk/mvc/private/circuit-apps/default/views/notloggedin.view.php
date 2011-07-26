<?php
/**
 * Standardized view for not logged in users
 * Allows a single message for users who are not logged in
 * @author Karen <kziv@gaiaonline.com>
 **/
class Default_NotLoggedIn_CircuitView extends CircuitView {

    public function execute(CircuitController $c) {

        $r = $c->getRequest();
        $message  = "<p>You can't do stuff if we don't know who you are. Go log in!</p>";
        $message .= "<p>If you're new here, <a href=\"" . $this->generateURL('Registration.Main') . '">Join Now</a>.</p>';
        $r->set('error.title', 'Not Logged In');
        $r->set('redirect.message', $message);        
        $this->forward('Default.MessageDie');
    }
}
