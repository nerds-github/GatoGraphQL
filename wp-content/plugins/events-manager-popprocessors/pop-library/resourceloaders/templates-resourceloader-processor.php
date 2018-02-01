<?php
/**---------------------------------------------------------------------------------------------------------------
 *
 * Data Load Library
 *
 * ---------------------------------------------------------------------------------------------------------------*/

define ('POP_RESOURCELOADER_TEMPLATE_CALENDAR', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_CALENDAR));
define ('POP_RESOURCELOADER_TEMPLATE_CALENDAR_INNER', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_CALENDAR_INNER));
define ('POP_RESOURCELOADER_TEMPLATE_FORMCOMPONENT_TYPEAHEADMAP', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_FORMCOMPONENT_TYPEAHEADMAP));
define ('POP_RESOURCELOADER_TEMPLATE_FRAME_CREATELOCATIONMAP', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_FRAME_CREATELOCATIONMAP));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUT_CAROUSEL_INDICATORS_EVENTDATE', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUT_CAROUSEL_INDICATORS_EVENTDATE));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUT_DATETIME', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUT_DATETIME));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONADDRESS', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUT_LOCATIONADDRESS));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONNAME', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUT_LOCATIONNAME));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONS', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUT_LOCATIONS));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUTCALENDAR_CONTENT_POPOVER', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUTCALENDAR_CONTENT_POPOVER));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUTEVENT_TABLECOL', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUTEVENT_TABLECOL));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUTLOCATION_TYPEAHEAD_COMPONENT', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUTLOCATION_TYPEAHEAD_COMPONENT));
define ('POP_RESOURCELOADER_TEMPLATE_LAYOUTLOCATION_TYPEAHEAD_SELECTED', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_LAYOUTLOCATION_TYPEAHEAD_SELECTED));
define ('POP_RESOURCELOADER_TEMPLATE_MAP', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_ADDMARKER', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_ADDMARKER));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_DIV', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_DIV));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_INDIVIDUAL', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_INDIVIDUAL));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_INNER', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_INNER));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_SCRIPT));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_DRAWMARKERS', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_SCRIPT_DRAWMARKERS));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_MARKERS', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_SCRIPT_MARKERS));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_RESETMARKERS', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_SCRIPT_RESETMARKERS));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_POST', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_SCRIPTCUSTOMIZATION_POST));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_USER', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_SCRIPTCUSTOMIZATION_USER));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_STATICIMAGE));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE_URLPARAM', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_STATICIMAGE_URLPARAM));
define ('POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE_LOCATIONS', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_MAP_STATICIMAGE_LOCATIONS));
define ('POP_RESOURCELOADER_TEMPLATE_SCRIPT_TRIGGERTYPEAHEADSELECT_LOCATION', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_SCRIPT_TRIGGERTYPEAHEADSELECT_LOCATION));
define ('POP_RESOURCELOADER_TEMPLATE_VIEWCOMPONENT_LOCATIONBUTTON', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_VIEWCOMPONENT_LOCATIONBUTTON));
define ('POP_RESOURCELOADER_TEMPLATE_VIEWCOMPONENT_LOCATIONBUTTONINNER', PoP_TemplateIDUtils::get_template_definition(GD_TEMPLATESOURCE_VIEWCOMPONENT_LOCATIONBUTTONINNER));

class EM_PoPProcessors_TemplateResourceLoaderProcessor extends PoP_TemplateResourceLoaderProcessor {

	function get_resources_to_process() {

		return array(
			POP_RESOURCELOADER_TEMPLATE_CALENDAR,
			POP_RESOURCELOADER_TEMPLATE_CALENDAR_INNER,
			POP_RESOURCELOADER_TEMPLATE_FORMCOMPONENT_TYPEAHEADMAP,
			POP_RESOURCELOADER_TEMPLATE_FRAME_CREATELOCATIONMAP,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_CAROUSEL_INDICATORS_EVENTDATE,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_DATETIME,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONADDRESS,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONNAME,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONS,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTCALENDAR_CONTENT_POPOVER,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTEVENT_TABLECOL,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTLOCATION_TYPEAHEAD_COMPONENT,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTLOCATION_TYPEAHEAD_SELECTED,
			POP_RESOURCELOADER_TEMPLATE_MAP,
			POP_RESOURCELOADER_TEMPLATE_MAP_ADDMARKER,
			POP_RESOURCELOADER_TEMPLATE_MAP_DIV,
			POP_RESOURCELOADER_TEMPLATE_MAP_INDIVIDUAL,
			POP_RESOURCELOADER_TEMPLATE_MAP_INNER,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_DRAWMARKERS,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_MARKERS,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_RESETMARKERS,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_POST,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_USER,
			POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE,
			POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE_URLPARAM,
			POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE_LOCATIONS,
			POP_RESOURCELOADER_TEMPLATE_SCRIPT_TRIGGERTYPEAHEADSELECT_LOCATION,
			POP_RESOURCELOADER_TEMPLATE_VIEWCOMPONENT_LOCATIONBUTTON,
			POP_RESOURCELOADER_TEMPLATE_VIEWCOMPONENT_LOCATIONBUTTONINNER,
		);
	}
	
	function get_filename($resource) {
	
		$filenames = array(
			POP_RESOURCELOADER_TEMPLATE_CALENDAR => GD_TEMPLATESOURCE_CALENDAR,
			POP_RESOURCELOADER_TEMPLATE_CALENDAR_INNER => GD_TEMPLATESOURCE_CALENDAR_INNER,
			POP_RESOURCELOADER_TEMPLATE_FORMCOMPONENT_TYPEAHEADMAP => GD_TEMPLATESOURCE_FORMCOMPONENT_TYPEAHEADMAP,
			POP_RESOURCELOADER_TEMPLATE_FRAME_CREATELOCATIONMAP => GD_TEMPLATESOURCE_FRAME_CREATELOCATIONMAP,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_CAROUSEL_INDICATORS_EVENTDATE => GD_TEMPLATESOURCE_LAYOUT_CAROUSEL_INDICATORS_EVENTDATE,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_DATETIME => GD_TEMPLATESOURCE_LAYOUT_DATETIME,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONADDRESS => GD_TEMPLATESOURCE_LAYOUT_LOCATIONADDRESS,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONNAME => GD_TEMPLATESOURCE_LAYOUT_LOCATIONNAME,
			POP_RESOURCELOADER_TEMPLATE_LAYOUT_LOCATIONS => GD_TEMPLATESOURCE_LAYOUT_LOCATIONS,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTCALENDAR_CONTENT_POPOVER => GD_TEMPLATESOURCE_LAYOUTCALENDAR_CONTENT_POPOVER,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTEVENT_TABLECOL => GD_TEMPLATESOURCE_LAYOUTEVENT_TABLECOL,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTLOCATION_TYPEAHEAD_COMPONENT => GD_TEMPLATESOURCE_LAYOUTLOCATION_TYPEAHEAD_COMPONENT,
			POP_RESOURCELOADER_TEMPLATE_LAYOUTLOCATION_TYPEAHEAD_SELECTED => GD_TEMPLATESOURCE_LAYOUTLOCATION_TYPEAHEAD_SELECTED,
			POP_RESOURCELOADER_TEMPLATE_MAP => GD_TEMPLATESOURCE_MAP,
			POP_RESOURCELOADER_TEMPLATE_MAP_ADDMARKER => GD_TEMPLATESOURCE_MAP_ADDMARKER,
			POP_RESOURCELOADER_TEMPLATE_MAP_DIV => GD_TEMPLATESOURCE_MAP_DIV,
			POP_RESOURCELOADER_TEMPLATE_MAP_INDIVIDUAL => GD_TEMPLATESOURCE_MAP_INDIVIDUAL,
			POP_RESOURCELOADER_TEMPLATE_MAP_INNER => GD_TEMPLATESOURCE_MAP_INNER,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT => GD_TEMPLATESOURCE_MAP_SCRIPT,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_DRAWMARKERS => GD_TEMPLATESOURCE_MAP_SCRIPT_DRAWMARKERS,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_MARKERS => GD_TEMPLATESOURCE_MAP_SCRIPT_MARKERS,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_RESETMARKERS => GD_TEMPLATESOURCE_MAP_SCRIPT_RESETMARKERS,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_POST => GD_TEMPLATESOURCE_MAP_SCRIPTCUSTOMIZATION_POST,
			POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_USER => GD_TEMPLATESOURCE_MAP_SCRIPTCUSTOMIZATION_USER,
			POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE => GD_TEMPLATESOURCE_MAP_STATICIMAGE,
			POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE_URLPARAM => GD_TEMPLATESOURCE_MAP_STATICIMAGE_URLPARAM,
			POP_RESOURCELOADER_TEMPLATE_MAP_STATICIMAGE_LOCATIONS => GD_TEMPLATESOURCE_MAP_STATICIMAGE_LOCATIONS,
			POP_RESOURCELOADER_TEMPLATE_SCRIPT_TRIGGERTYPEAHEADSELECT_LOCATION => GD_TEMPLATESOURCE_SCRIPT_TRIGGERTYPEAHEADSELECT_LOCATION,
			POP_RESOURCELOADER_TEMPLATE_VIEWCOMPONENT_LOCATIONBUTTON => GD_TEMPLATESOURCE_VIEWCOMPONENT_LOCATIONBUTTON,
			POP_RESOURCELOADER_TEMPLATE_VIEWCOMPONENT_LOCATIONBUTTONINNER => GD_TEMPLATESOURCE_VIEWCOMPONENT_LOCATIONBUTTONINNER,
		);
		if ($filename = $filenames[$resource]) {
			return $filename;
		}

		return parent::get_filename($resource);
	}
	
	function get_version($resource) {
	
		return EM_POPPROCESSORS_VERSION;
	}
	
	function get_path($resource) {
	
		return EM_POPPROCESSORS_URL.'/js/dist/templates';
	}
	
	function get_dir($resource) {
	
		return EM_POPPROCESSORS_DIR.'/js/dist/templates';
	}
	
	function get_globalscope_method_calls($resource) {

		switch ($resource) {

			case POP_RESOURCELOADER_TEMPLATE_CALENDAR_INNER:

				return array(
					'popFullCalendarAddEvents' => array(
						'addEvents',
					),
					'popManager' => array(
						'getBlock',
						'getPageSection',
					),
				);
			case POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_POST:
			case POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPTCUSTOMIZATION_USER:

				return array(
					'popMapRuntime' => array(
						'setMarkerData',
					),
				);

			case POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_DRAWMARKERS:

				return array(
					'popMapRuntime' => array(
						'drawMarkers',
					),
					'popManager' => array(
						'getBlock',
						'getPageSection',
					),
				);

			case POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_MARKERS:

				return array(
					'popMapRuntime' => array(
						'initMarker',
					),
				);

			case POP_RESOURCELOADER_TEMPLATE_MAP_SCRIPT_RESETMARKERS:

				return array(
					'popMapRuntime' => array(
						'resetMarkerIds',
					),
				);

			case POP_RESOURCELOADER_TEMPLATE_SCRIPT_TRIGGERTYPEAHEADSELECT_LOCATION:

				return array(
					'popTypeaheadTriggerSelect' => array(
						'triggerSelect',
					),
					'popManager' => array(
						'getBlock',
						'getPageSection',
						'getItemObject',
					),
				);

		}

		return parent::get_globalscope_method_calls($resource);
	}
}

/**---------------------------------------------------------------------------------------------------------------
 * Initialization
 * ---------------------------------------------------------------------------------------------------------------*/
new EM_PoPProcessors_TemplateResourceLoaderProcessor();
