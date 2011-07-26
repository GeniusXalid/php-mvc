<?
/**
 * create pagination.
 * Generate the pagination String for this topic and save the results
 * into the template
 */
class Default_Pagination_CircuitFrame
{

    function execute( & $controller )
    {
        $template =& SingletonContainer::get("template");
        $observer =& $controller->getObserver();
        $page = $observer->get("default.pagination.page");
        $totalPages = $observer->get("default.pagination.total");
        $url = $observer->get('default.pagination.url');
        $pg_id = $observer->get('default.pagination.pg_id');
        $tpl = $observer->get('default.pagination.template');
        if( empty( $tpl) ) $tpl = 'pagination.tpl';

        if( strlen( $pg_id ) < 1 ) $pg_id = 'page';
        $url = append_sid( $url );
        $url .= ( strpos($url, '?') === FALSE ) ? '?' : '&amp;';
        $url .= $pg_id . '=';
        if( $totalPages <= 1 ) return;
        $pages = array();
        
        $skip_inserted = false;
        $skip_second_inserted = false;
        $currentPage = 1;
    
        while ($currentPage <= $totalPages) {
            if (($currentPage > 3) && ($totalPages > 4) && (!$skip_inserted)) {
                $pages[] = "...";
                $skip_inserted = true;
            }
    
            if ( (($currentPage <= ($page+3)) && ($currentPage >= ($page-2))) || ($currentPage > ($totalPages-4)) || ($currentPage <= 3) ) {
                $pages[] = $currentPage;
            }
    
            if (($currentPage < ($totalPages-4)) && ($currentPage > ($page+3)) && (!$skip_second_inserted)) {
                $pages[] = "...";
                $skip_second_inserted = true;
            }
    
            $currentPage++;
        }
        
        $template->set_filename('paginate', $tpl);
        foreach ($pages as $paginationPage) {
            $template->assign_block_vars("pagination", array(
                "PAGE"			=>		$paginationPage,
                "IS_SEPERATOR"	=>		($paginationPage == "...") ? TRUE : FALSE
                )
            );
        }
        $template->assign_vars(array(
            "MY_PAGE"                   => $page,
            "FIRST_PAGE"                => 1,
            "LAST_PAGE"                 => $totalPages,
            "USE_URL"                   => $url,            
            "NEXT_PAGE"                 => $page+1,
            "HAS_NEXT_PAGE"             => ($page+1 <= $totalPages) ? TRUE : FALSE,
            "NEXT_10_PAGE"              => $page+10,
            "HAS_NEXT_10_PAGE"          => ($page+10 <= $totalPages) ? TRUE : FALSE,
            "NEXT_100_PAGE"             => $page+100,
            "HAS_NEXT_100_PAGE"         => ($page+100 <= $totalPages) ? TRUE : FALSE,
            
            "PREV_PAGE"                 => $page-1,
            "HAS_PREV_PAGE"             => ($page-1 >= 1) ? TRUE : FALSE,
            "PREV_10_PAGE"              => $page-10,
            "HAS_PREV_10_PAGE"          => ($page-10 >= 1) ? TRUE : FALSE,
            "PREV_100_PAGE"             => $page-100,
            "HAS_PREV_100_PAGE"         => ($page-100 >= 1) ? TRUE : FALSE
            )
        );
        
        return $template->fetch("paginate");
    
    }
}
?>