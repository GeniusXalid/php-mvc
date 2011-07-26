<?php
/**
 * Displays a global 404 page
 * Shows a full webpage with an informative page not found message
 * @author John <jloehrer@gaiaonline.com>
 * @author Karen <kziv@gaiaonline.com>
 * @see Default.404Simple.View
 **/
class Default_MeteredRelease_CircuitView extends CircuitGridView {

    public function execute(CircuitController $c) {

        //session_pagestart(PAGE_4O4);

        switch (SC::get('metered_release.output_style')) {
            case 'popup':
                $this->set('title', 'Nothing to See Here');
                $this->render('Default.MeteredReleaseMin');
                break;
            
            default:
                LM::setPageTitle('Nothing to See Here');
                LM::disableGapi();
                LM::renderHeader();
                $this->setLayout('Paul McCartney');
                $this->addZoneContent('1A', 'Default.MeteredRelease');
                $this->renderLayout();
                LM::renderFooter();
                break;
        }
    }
    
}
