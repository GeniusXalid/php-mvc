<?php
# +---------------------------------------------------------------------------+
# | This file is part of the CIRCUIT MVC Framework.                           |
# | Author foobarbazquux (kziv@gaiaonline.com                                 |
# |                                                                           |
# | Copyright (c) Gaia Online 2005                                            |
# |                                                                           |
# | For the full copyright and license information, please view the LICENSE   |
# | file that was distributed with this source code.                          |
# +---------------------------------------------------------------------------+

//include_once DIR_CLASSES . 'jsmin-1.1.0.php';

/**
 * This page handles JS minification
 */
class Default_MinScript_CircuitRequest extends CircuitRequest {

    protected $base_path = 'src';

    public function load() {
        $args = $this->getArgs();
        $path = '';
        for ($i = 1; $i < count($args); $i++) {
            $path .= '/'.$args[$i];
        }
        $this->set('path', $path);
        $this->set('count', $args[0]);
    }

    public function getKeyFromPath($path) {
        return 'JSMIN_' . $this->get('count') . str_replace('/', '_', $path);
    }

    public function getRollupPackage($path) {
        // all extra slashes gone
        $path = trim($path, '/');

        // okay, now we'll build a file list for each package
        $files = array();

        // handle packages
        switch ($path) {
            case 'pkg-gaia_core.js':
                $files = array(
                    'src/yui/utilities/utilities.js',
                    'src/yui/container/container-min.js',
					'src/yui/overlay_patch-min.js',  /* Remove overlay_patch once YUI fixes overlay bug */
                    'src/yui/selector/selector-min.js',
                    'src/yui/json/json-min.js',
                    'src/yui/menu/menu-min.js',
					'src/yui/menu_patch-min.js',  /* Remove menu_patch once YUI fixes menu bug */
					'src/yui/cookie/cookie-min.js',
					'src/js/yshort.js',
                    'src/common/header.js',
                    'src/js/core.js',
					'src/js/gim/getname.js',
					'src/js/pulldown/dropdown.js',
					'src/js/equip/equip.js',
                    'src/js/jitloader.js',
                    'src/js/cashshop/_package.js',
					'src/js/friends/addfriend.js',
					'src/js/header/headerMenu.js',
                    'src/js/header/shortcut.js',
					'/src/common/change_store_name.js',
                    //from GIM global
					'/src/js/flash/flashutil.js',
                    '/src/js/persist/persist.js',
                    '/src/js/gim/headerbuddylist.js',
                    '/src/js/gim/launcher.js',
                    '/src/js/gim/globallauncher.js'
                    );
            break;
	        case 'pkg-cashshop.js':
                $files = array(
                    // abstracts
                    'src/js/cashshop/abstractmodule.js',

                    // static on every screen
                    'src/js/cashshop/npc.js',
                    'src/js/cashshop/gaiacashad.js',
                    'src/js/cashshop/cashheader.js',
                    'src/js/cashshop/shopbanner.js',

                    // pages
                    'src/js/cashshop/home.js',
                    'src/js/cashshop/browser.js',
                    'src/js/cashshop/itemdetail.js',
                    'src/js/cashshop/itempreview.js',
                    'src/js/cashshop/selectdestination.js',
                    'src/js/cashshop/privacy.js',
                    'src/js/cashshop/giftmessage.js',
                    'src/js/cashshop/reviewgift.js',
                    'src/js/cashshop/receipt.js',

                    // app layer
                    'src/js/cashshop/cashshop.js',
                );
            break;
            case 'pkg-gaia_gim_global.js':
                $files = array(
                    '/src/js/flash/flashutil.js',
                    '/src/js/persist/persist.js',
                    '/src/js/gim/headerbuddylist.js',
                    '/src/js/gim/launcher.js',
                    '/src/js/gim/globallauncher.js'
                    );
            break;
            case 'pkg-gaia_gim_core.js':
                $files = array(
                    'src/yui/utilities/utilities.js',
                    'src/yui/container/container-min.js',
					'src/yui/overlay_patch-min.js'
                );
                break;

			case 'pkg-gaia_gim.js':
				$files = array(
					'/src/js/login/md5-min.js',
					'/src/yui/resize/resize-min.js',
					'/src/yui/cookie/cookie-min.js',
                    '/src/yui/imageloader/imageloader-min.js',
                    '/src/js/gim/client.js',
					'/src/js/gim/externalcarousel.js',
					'/src/js/gim/externalbuddylist.js',
					'/src/js/gim/aimapi.text.en-us.js',
					'/src/js/gim/globallauncher.js',
				);
				break;
			case 'pkg-gaia_gimCarousel.js':
				$files = array(
					'/src/yui/resize/resize-min.js',
					'/src/yui/button/button-min.js',
					'/src/js/gim/carouselresize.js',
					'/src/js/gim/gim_editor.js'
				);
				break;
			case 'pkg-gaia_profile.js':
				$files = array(
					'src/yui/utilities/utilities.js',
					'src/yui/selector/selector-min.js',
					'src/yui/cookie/cookie-min.js',
					'src/yui/container/container-min.js',
					'src/yui/overlay_patch-min.js', /* Remove overlay_patch once YUI fixes overlay bug */
					'src/yui/json/json-min.js',
					'src/js/yshort.js',
					'/src/js/gim/launcher.js',
                    '/src/js/gim/globallauncher.js',
					'/src/js/gim/getname.js',
					'/src/js/friends/addfriend.js',
					'src/js/pulldown/dropdown.js',
					'src/js/equip/equip.js',

				);
				break;
			case 'pkg-gaia_tank.js':
				$files = array(
					'src/yui/utilities/utilities.js',
					'src/yui/selector/selector-min.js',
					'src/yui/container/container-min.js',
					'src/js/yshort.js',
					'src/js/pulldown/dropdown.js',
					'src/js/equip/equip.js',
				);
				break;
			case 'pkg-gaia_core.css':
				$files = array(
					'src/yui/grids/grids-min.css',
					'src/yui/container/assets/container.css',
					'src/layout/gaialol/screen.css',
					'src/css/core.css',
				);
				break;
        }

        // if no packages found, this is a weird named thing... damn...
        if (count($files) <= 0) {
            return false;
        }

        // okay, now let's open up all those files and append them to an output
		$output = NULL;
        foreach($files as $k => $file) {
            $output .= "\n\n".file_get_contents(DIR_PUBLIC_HTML . $file);
        }

        return $output;
    }

    public function outputHeaders($ext, $full_path) {
        SC::set('header_suppress_cache_control', 1);
	$cache_duration = 86400 * 7; // 7 days
	$last_mod_duration = 86400 * 2; // 2 days
	$last_mod_date = date('r', (SC::get('board_config.time_now') - $last_mod_duration));
        $to_cache_date = date('r', (SC::get('board_config.time_now') + $cache_duration));
        header("Expires: $to_cache_date");
        header("Last-Modified: $last_mod_date");
        header("Cache-Control: max-age=$cache_duration");

        // make an etag based on the full path
        // header('Etag: ' .'"'. crc32($full_path) . '"');

        if ($ext == ".js") {
            header("Content-type: text/javascript");
        }
        if ($ext == ".css") {
            header("Content-type: text/css");
        }
    }

    public function selectView() {
        // load a memcache object
        $memcache = MemcacheFactory::construct('query_memcache');

        // reduce path to just a dir structure. Remove funny stuff...
        // .. //
        $invalid_path_items = array(
            '//',
            '..',
        );
        $path = str_replace($invalid_path_items, '', $this->get('path'));

        $full_path = DIR_PUBLIC_HTML . $this->base_path . $path;

        $extension_stub_pos = strripos($full_path, '.');
        $extn = substr($full_path, -1*(strlen($full_path) - $extension_stub_pos));
        $this->outputHeaders($extn, $full_path);

        // if we have a key, use it
        if (!SC::get('board_config.disable_query_memcache')) {
            $output = $memcache->get($this->getKeyFromPath($full_path));
        }

        if ($output) {
            echo '/'.'* cache=true *'.'/'."\n";
            echo $output;
            exit;
        }

        $comments = array('cache=false');

        // check for rollup packages
        if (strpos($path, 'pkg-') !== false) {
            $comments[] = 'pkg=true';
            $output = $this->getRollupPackage($path);
        }

        // only minify in production
        // if (!SC::get('board_config.local_domain_enable') && $extn == '.js') {
        //     $comments[] = 'mini=true';
        //     $output = JSMin::minify($output);
        // }

		// store to memcache
        if ( !SC::get('board_config.disable_query_memcache') && $memcache->add('key'.$this->getKeyFromPath($full_path), 1) ) {
            $comments[] = 'cachewrite=true';
            $memcache->set($this->getKeyFromPath($full_path), $output, MEMCACHE_COMPRESSED, 86400);
        }

        echo '/'.'* ' . implode(';', $comments) . ' *'.'/'."\n";
        echo $output;

        exit;
    }
}
?>
