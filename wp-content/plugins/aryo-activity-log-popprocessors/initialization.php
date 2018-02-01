<?php
class AAL_PoPProcessors_Initialization {

	function initialize(){

		load_plugin_textdomain('aal-popprocessors', false, dirname(plugin_basename(__FILE__)).'/languages');

		// Set the plugin namespace for the processors
		PoP_TemplateIDUtils::set_namespace('a8');

		if (!is_admin()) {

			add_action("wp_enqueue_scripts", array($this, 'register_scripts'));
		}

		/**---------------------------------------------------------------------------------------------------------------
		 * Constants/Configuration for functionalities needed by the plug-in
		 * ---------------------------------------------------------------------------------------------------------------*/
		// require_once 'config/load.php';

		/**---------------------------------------------------------------------------------------------------------------
		 * PoP Library
		 * ---------------------------------------------------------------------------------------------------------------*/
		require_once 'pop-library/load.php';

		/**---------------------------------------------------------------------------------------------------------------
		 * Library
		 * ---------------------------------------------------------------------------------------------------------------*/
		// require_once 'library/load.php';
	}

	function register_scripts() {

		// Only if not doing code splitting then load the resources. Otherwise, the resources will be loaded by the ResourceLoader
		if (!PoP_Frontend_ServerUtils::use_code_splitting()) {

			$js_folder = AAL_POPPROCESSORS_URL.'/js';
			$dist_js_folder = $js_folder.'/dist';
			$libraries_js_folder = (PoP_Frontend_ServerUtils::use_minified_resources() ? $dist_js_folder : $js_folder).'/libraries';
			$suffix = PoP_Frontend_ServerUtils::use_minified_resources() ? '.min' : '';
			$bundles_js_folder = $dist_js_folder.'/bundles';

			// Moment.js library already loaded by PoP Core Processors
			// if (PoP_Frontend_ServerUtils::access_externalcdn_resources()) {

			// 	// CDN
			// 	wp_register_script('moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js', array('jquery'), null);
			// }
			// else {

			// 	// Local files
			// 	wp_register_script('moment', $cdn_js_folder . '/moment.2.10.6.min.js', array('jquery'), null);
			// }

			if (PoP_Frontend_ServerUtils::use_bundled_resources()) {
				
				wp_register_script('aal-popprocessors-templates', $bundles_js_folder . '/aryo-activity-log-popprocessors.templates.bundle.min.js', array(), AAL_POPPROCESSORS_VERSION, true);
				wp_enqueue_script('aal-popprocessors-templates');

				wp_register_script('aal-popprocessors', $bundles_js_folder . '/aryo-activity-log-popprocessors.bundle.min.js', array('pop', 'jquery'), AAL_POPPROCESSORS_VERSION, true);
				wp_enqueue_script('aal-popprocessors');
			}
			else {

				wp_register_script('aal-popprocessors-notifications', $libraries_js_folder.'/notifications'.$suffix.'.js', array('jquery', 'pop'), AAL_POPPROCESSORS_VERSION, true);
				wp_enqueue_script('aal-popprocessors-notifications');

				/** Templates Sources */
				$this->enqueue_templates_scripts();
			}
		}
	}

	function enqueue_templates_scripts() {

		$folder = AAL_POPPROCESSORS_URL.'/js/dist/templates/';

		wp_enqueue_script('aal-layout-previewnotification-tmpl', $folder.'aal-layout-previewnotification.tmpl.js', array('handlebars'), AAL_POPPROCESSORS_VERSION, true);
		wp_enqueue_script('aal-layout-notificationtime-tmpl', $folder.'aal-layout-notificationtime.tmpl.js', array('handlebars'), AAL_POPPROCESSORS_VERSION, true);
		wp_enqueue_script('aal-layout-notificationicon-tmpl', $folder.'aal-layout-notificationicon.tmpl.js', array('handlebars'), AAL_POPPROCESSORS_VERSION, true);
	}
}