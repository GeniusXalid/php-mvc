<?php
/**
 * Redirect ot the url specified in redirect.path.
 * @author     72squared <john@gaiaonline.com>
 */
class Default_Redirect_CircuitView extends CircuitView {

    public function execute(CircuitController $c) {

        //get the observer...
        $observer = $c->getObserver();

        //get the URL...
        $url = !$c->getRequest()->isEmpty('redirect')
            ? $c->getRequest()->get('redirect')
            : $observer->get('redirect.path');

        //if it isn't local or it's empty, throw it out NOW...
        if ( ! urlIsLocal($url) ) {
            $this->forward('default.404');
        }

        //handle our redirect if this is a JSON call...
        if ($c->getRequest()->get('ajax')) {
            $output = array('type' => 'redirect',
                            'url'  => $url,
                            );
            $this->set('data',$output);
            $this->render('default.jsonresponse');
        }
        //handle our redirect if this a normal redirect...
        else {
            redirect($url);
        }
        // bye bye!
        exit;
    }

}