<?php
/*
 * Plugin Name: Webtrekk Q3 001
 * Description: Dynamically populates the Webtrekk Q3 pixel code.
 * Author: Rocco Barbini
 * Author URI: www.barbinirocco.com
 * Disclaimer: This is my own original work and Webtrekk Gmbh has not in any capacity endorsed or reviewed it, doesn’t guarantee it and can’t be hold liable for any damange eventually caused by the use of this plugin. As a private citizen, I offer this plugin as is and I don't guarantee it. You can install it at your own risk and I can't be hold liable for any damage that this may cause.
 * License: GPL3
 * Version: 1.0.2
*/

/*
 * Changelog from version 1.0.1
 *
 * Support for Page Scroll Plugin added.
 */

/**
 * Activation method.
 *
 * Instantiates the DB option with their default values.
 *
 * @since 0.0.1
 */
function activate()
{
	$rba_wt_global_DBoptions_activate = array(
		'rba_wt_pluginIsActive' => 0,
		'rba_wt_tracking_url' => 'dummy-url.wt-eu02.net',
		'rba_wt_track_id' => '000000000000000',
		'rba_wt_config_domain' => 'www.nodomaindefined.it',
		'rba_wt_cookie' => 1,
		'rba_wt_media_code' => 'wt_mc',
		'rba_wt_siteForm' => 0,
		'rba_wt_pageScrollIsActive' => 0
		);
	$rba_wt_cg_DBoptions_activate = array(
		'rba_wt_cg_Counter' => '0',
		'rba_wt_cg_name_isDynamic_0' => 0,
		'rba_wt_cg_name_0' => '-',
		'rba_wt_cg_name_isDynamic_1' => 0,
		'rba_wt_cg_name_1' => '-',
		'rba_wt_cg_name_isDynamic_2' => 0,
		'rba_wt_cg_name_2' => '-',
		'rba_wt_cg_name_isDynamic_3' => 0,
		'rba_wt_cg_name_3' => '-',
		'rba_wt_cg_name_isDynamic_4' => 0,
		'rba_wt_cg_name_4' => '-',
		'rba_wt_cg_name_isDynamic_5' => 0,
		'rba_wt_cg_name_5' => '-',
		'rba_wt_cg_name_isDynamic_6' => 0,
		'rba_wt_cg_name_6' => '-',
		'rba_wt_cg_name_isDynamic_7' => 0,
		'rba_wt_cg_name_7' => '-',
		'rba_wt_cg_name_isDynamic_8' => 0,
		'rba_wt_cg_name_8' => '-',
		'rba_wt_cg_name_isDynamic_9' => 0,
		'rba_wt_cg_name_9' => '-'
		);
	$rba_wt_page_definition_DBoptions_activate = array(
		'rba_wt_content_id_mode' => 0,
		'rba_wt_link_track' => 'none',
		'rba_wt_link_track_attribute_present' => '0',
		'rba_wt_link_track_attribute' => 'rel',
		'rba_wt_heatmap' => '0',
		'rba_wt_form' => '0'
		);
	$rba_wt_page_parameter_DBoptions_activate = array(
		'document_title_display' => 0,
		'document_title_number' => 1,
		'post_author_display' => 0,
		'post_author_number' => 2,
		'word_count_display' => 0,
		'word_count_number' => 3
		);
	update_option('rba_wt_global_DBoptions',$rba_wt_global_DBoptions_activate);
	update_option('rba_wt_cg_DBoptions',$rba_wt_cg_DBoptions_activate);
	update_option('rba_wt_page_definition_DBoptions',$rba_wt_page_definition_DBoptions_activate);
	update_option('rba_wt_page_parameters_DBoptions',$rba_wt_page_parameter_DBoptions_activate);
}

/**
 * Deactivation method.
 *
 * Deletes the DB options.
 * An internal deactivation option is provided to avoid showing the
 * Webtrekk pixel without erasing the DB options.
 *
 * @since 0.0.1
 */
function deactivate()
{
	delete_option('rba_wt_cg_DBoptions');
	delete_option('rba_wt_page_definition_DBoptions');
	delete_option('rba_wt_global_DBoptions');
	delete_option('rba_wt_page_parameters_DBoptions');
}

/**
 * Pixel class. (use period)
 *
 * It sets up the pixel for a given page upon creation.
 * It has a method for showing the pixel in the page.
 *
 * @since 0.0.1
 *
 * @global string $pixelVersion Current version of the Webtrekk Pixel.
 * @global string $rba_wt_tracking_url Webtrekk tracking URL for the account.
 * @global string $rba_wt_track_id Webtrekk track ID for the account.
 * @global $rba_wt_config_domain Domain field in the webtrekkConfig object.
 * @global $rba_wt_cookie Cookie field in the webtrekkConfig object.
 * @global $rba_wt_media_code mediaCode field in the webtrekkConfig object.
 * @global array $rba_wt_cg Content Group names.
 * @global int $rba_wt_cg_Counter Amount of Content Groups used.
 * @global int $rba_wt_content_id_mode Defines how the contentId is generated.
 * @global string $rba_wt_link_track Defines the link track value in the pixel.
 * @global int $rba_wt_link_track_attribute_present Defines if there is the linkTrackAttribute value.
 * @global string $rba_wt_link_track_attribute Defines the linkTrackAttribute value, if present.
 * @global int $rba_wt_heatmap Defines the heatmap value in the pixel.
 * @global int $rba_wt_form Defines the form value in the pixel.
 * @global int $rba_wt_page_id Stores the Wordpress ID of the current page.
 * @global int $rba_wt_cg_firstDynamic Set to 1 when a dynamic Content Group is found for the first time.
 * @global array $rba_wt_cg_dynamic Stores all available dynamic Content Group names, it is populated the first time a dynamic CG is encountered.
 * @global int $rba_wt_cg_dynamicCountAvailable Counts the number of available dynamic Content Group names.
 * @global int $rba_wt_cg_dynamicCountUsed Counts the amount of dynamic Content Group names that have already been used.
 * @global int $rba_wt_pluginIsActive Set to 1 if the pixel should be displayed.
 * @global int $rba_wt_page_parameters_present Set to 1 if page parameters should be displayed.
 * @global int $rba_wt_cp_document_title_display Set to 1 if the document title should be displayed as a page parameter.
 * @global int $rba_wt_cp_document_title_number Page parameter number for the Document Title parameter.
 * @global int $rba_wt_cp_post_author_display Set to 1 if the post author should be displayed as a page parameter.
 * @global int $rba_wt_cp_post_author_number Page parameter number for the Post Author parameter.
 * @global string rba_wt_cp_post_author_value Stores the value of the current page's Post Author parameter.
 * @global int $rba_wt_cp_word_count_display Set to 1 if the word count should be displayed as a page parameter.
 * @global int $rba_wt_cp_word_count_number Page parameter number for the word count parameter.
 * @global string rba_wt_cp_word_count_value Stores the value of the current page's word count parameter.
 */
class Webtrekk_Q3_Pixel
{
	public $pixelVersion = "3.2.3";
	public $rba_wt_tracking_url;
	public $rba_wt_track_id;
	public $rba_wt_config_domain;
	public $rba_wt_cookie;
	public $rba_wt_media_code;
	public $rba_wt_siteForm;
	public $rba_wt_pageScrollIsActive = 0;
	public $rba_wt_cg = array(
		0 => "",
		1 => "",
		2 => "",
		3 => "",
		4 => "",
		5 => "",
		6 => "",
		7 => "",
		8 => "",
		9 => "",
		);
	public $rba_wt_cg_Counter;
	public $rba_wt_content_id_mode;
	public $rba_wt_link_track;
	public $rba_wt_link_track_attribute_present;
	public $rba_wt_link_track_attribute;
	public $rba_wt_heatmap;
	public $rba_wt_form;
	public $rba_wt_page_id;
	public $rba_wt_cg_firstDynamic;
	public $rba_wt_cg_dynamic;
	public $rba_wt_cg_dynamicCountAvailable;
	public $rba_wt_cg_dynamicCountUsed;
	public $rba_wt_pluginIsActive;
	public $rba_wt_page_parameters_present = 0;
	public $rba_wt_cp_document_title_display;
	public $rba_wt_cp_document_title_number;
	public $rba_wt_cp_post_author_display;
	public $rba_wt_cp_post_author_number;
	public $rba_wt_cp_post_author_value;
	public $rba_wt_cp_word_count_display;
	public $rba_wt_cp_word_count_number;
	public $rba_wt_cp_word_count_value;
	// Private variables
	private $rba_wt_page_parameter_previous = 0; // For use in the display method only. Sets to 1 the first time a page parameter is displayed.
	
	/**
	 * Constructor method.
	 *
	 * Sets up the pixel for a given page.
	 *
	 * @since 0.0.1
	 *
	 * @see Webtrekk_Q3_Pixel
	 *
	 * @param  int $rba_wt_page_id Wordpress ID of the current page.
	 */
	public function __construct($rba_wt_page_id)
	{
		/*
		 * NOTE
		 * The number of content groups should be defined in the configuration page.
		 * It should be possible to define a number of CGs between 0 and 10.
		 * If the variable value is equal to zero, no CGs should be shown.
		 * If the variable value is greater than zero, an array equal to the number of CGs should define if their
		 * names are static.
		 * From the point when they stopped being static, they should be counted (the count could be part of another
		 * variable, computed when the config is saved, to make it all lighter and faster).
		 * The parents of the post should be counted and the lower number between the number of parents and the number
		 * of automatic CGs should be taken into account.
		 * Then the CG values should be populated based on the appropriate parent.
		 * If the page is a post, the first automatic CG should always be blog, the subsequent ones should be blog
		 * categories or whatever hierarchy is available.
		 */
		// Fallback variable definitions
		$this->rba_wt_cg[0] = "";
		$this->rba_wt_cg[1] = "";
		$this->rba_wt_cg[2] = "";
		$this->rba_wt_cg[3] = "";
		$this->rba_wt_cg[4] = "";
		$this->rba_wt_cg[5] = "";
		$this->rba_wt_cg[6] = "";
		$this->rba_wt_cg[7] = "";
		$this->rba_wt_cg[8] = "";
		$this->rba_wt_cg[9] = "";
		$this->rba_wt_cg_Counter = 0;
		$this->rba_wt_tracking_url = "dummy-url.wt-eu02.net";
		$this->rba_wt_track_id = "000000000000000";
		$this->rba_wt_cg_firstDynamic = 0; // This is set to 1 when a dynamic CG is found for the fist time
		$this->rba_wt_cg_dynamicCountAvailable = 0; // This is number of available dynamic CG values
		$this->rba_wt_cg_dynamicCountUsed = 0; // This is number of used dynamic CG values
		$this->rba_wt_pluginIsActive = 0; // Check: is the plugin active?
		$this->rba_wt_config_domain = "www.nodomaindefined.it"; // Domain in the webtrekkConfig object
		$this->rba_wt_cookie = "3"; // First or third party cookie, default is 3rd party
		$this->rba_wt_mediaCode = "wt_mc"; // mediaCode in the webtrekkConfig object
		
		/*
		 * Global Options are instantiated.
		 *
		 * First, we retrieve the options.
		 * Then we check if the plugin is active.
		 * Then we go on
		 *
		 */
		$rba_wt_global_TEMPoptions = get_option('rba_wt_global_DBoptions');
		if ($rba_wt_global_TEMPoptions != false && $rba_wt_global_TEMPoptions['rba_wt_pluginIsActive'] == "1") {
			$this->rba_wt_pluginIsActive = 1;
			if (gettype($rba_wt_global_TEMPoptions['rba_wt_tracking_url']) == 'string' && $rba_wt_global_TEMPoptions['rba_wt_tracking_url'] != '') {
				$this->rba_wt_tracking_url = $rba_wt_global_TEMPoptions['rba_wt_tracking_url'];
			}
			if (preg_match('/^[0-9]+$/', $rba_wt_global_TEMPoptions['rba_wt_track_id'])) {
				$this->rba_wt_track_id = $rba_wt_global_TEMPoptions['rba_wt_track_id'];
			}
			if (gettype($rba_wt_global_TEMPoptions['rba_wt_config_domain']) == 'string' && $rba_wt_global_TEMPoptions['rba_wt_config_domain'] != '') {
				$this->rba_wt_config_domain = $rba_wt_global_TEMPoptions['rba_wt_config_domain'];
			}
			if (gettype($rba_wt_global_TEMPoptions['rba_wt_media_code']) == 'string' && $rba_wt_global_TEMPoptions['rba_wt_media_code'] != '') {
				$this->rba_wt_media_code = $rba_wt_global_TEMPoptions['rba_wt_media_code'];
			}
			if (preg_match('/^[0-1]+$/', $rba_wt_global_TEMPoptions['rba_wt_cookie'])) {
				$this->rba_wt_cookie = $rba_wt_global_TEMPoptions['rba_wt_cookie'];
			}
			if (preg_match('/^[0-1]+$/', $rba_wt_global_TEMPoptions['rba_wt_siteForm'])) {
				$this->rba_wt_siteForm = $rba_wt_global_TEMPoptions['rba_wt_siteForm'];
			}
			if ($rba_wt_global_TEMPoptions['rba_wt_pageScrollIsActive'] == "1") {
				$this->rba_wt_pageScrollIsActive = "1";
			}
			
			$this->setup_content_groups(); // Content Groups are instantiated via their own, private method.
			$this->setup_page_options(); // Page options are instantiated via their own, private method.
			$this->setup_page_parameter(); // Page parameters are instantiated, if present.
		}
		else { // Nope, there's something wrong with the plugin
			$this->rba_wt_pluginIsActive = 0;
		}
	}
	
	/**
	 * Display method.
	 *
	 * Displays the pixel on a given page.
	 *
	 * @since 0.0.1
	 *
	 * @see Webtrekk_Q3_Pixel
	 * @see __construct()
	 */
	public function display()
	{
		// Is the plugin active?
		if ($this->rba_wt_pluginIsActive == "1") {
			$this->rba_wt_page_parameter_previous = 0;
			// First I set up the noscript url
			$rba_wt_noscript_url = '		<img src="http://'.$this->rba_wt_tracking_url.'/'.$this->rba_wt_track_id.'/wt.pl?p=326';
			$i = 0;
			while ($i <= $this->rba_wt_cg_Counter) {
				$this->rba_wt_noscript_url .= '&amp;cg'.($i+1).'='.urlencode($this->rba_wt_cg[$i]);
				$i++;
			}
			$rba_wt_noscript_url .= '" height="1" width="1" alt="" />';
			// Then I start echoing stuff and writing code on the page
			echo "\n".'<!-- Webtrekk 3.2.3, (c) www.webtrekk.com -->'."\n";
			// The following line includes the webtrekk_v3.js file
			if($this->rba_wt_pageScrollIsActive == 1) {
				echo '<script type="text/javascript" src="' . plugins_url( 'includes/webtrekk_scrollposition.js' , __FILE__ ) . '"></script>'."\n";
			}
			echo '<script type="text/javascript" src="' . plugins_url( 'includes/webtrekk_v3.js' , __FILE__ ) . '"></script>'."\n";
			echo '<script type="text/javascript">'."\n";
			echo '<!--'."\n";
			// The following segment echoes the pageconfig section of webtrekk_v3.js
			echo 'var webtrekkConfig = {'."\n";
			echo '	trackId : "'.$this->rba_wt_track_id.'",'."\n";
			echo '	trackDomain : "'.$this->rba_wt_tracking_url.'",'."\n";
			echo '	domain : "'.$this->rba_wt_config_domain.'",'."\n";
			echo '	cookie : "';
			switch ($this->rba_wt_cookie) {
				case "0":
					echo '1'; // First party cookie
					break;
				case "1":
					echo '3'; // Third party cookie
					break;
			};
			echo '",'."\n";
			echo '	mediaCode : "'.$this->rba_wt_media_code.'",'."\n";
			echo '	contentId : ""';
			if($this->rba_wt_siteForm == "1") {
				echo ",\n" . '	form : "1"';
			}
			if($this->rba_wt_pageScrollIsActive == 1) {
				echo ",\n" . '	executePluginFunction : "wt_scrollposition"';
			}
			echo "\n" . '}'."\n";
			// And now we begin with the usual code
			if ($this->rba_wt_content_id_mode == 1) {
				echo "\n" . 'function getContentIdByURL(){' . "\n";
				echo '	var url = document.location.href;' . "\n";
				echo '	if(url && url !== null) {' . "\n";
				echo '		return url.split("?")[0].toLowerCase();' . "\n";
				echo '	}' . "\n";
				echo '	return "no_content";' . "\n";
				echo '};' . "\n";
			};
			echo 'var webtrekk = {'."\n";
			echo '	contentId : ';
			switch ($this->rba_wt_content_id_mode) {
				case "0":
					echo '""'; // Default UTF
					break;
				case "1":
					echo 'getContentIdByURL()'; // Normalized URL with no string parameters, all lowercase
					break;
				case "2":
					echo 'document.location.href'; // Full URL
					break;
				case "3":
					echo 'document.title'; // Page Title
					break;
			};
			echo ",\n";
			echo '	linkTrack : "'; // Link Track begins
			if($this->rba_wt_link_track != "none") {
				echo $this->rba_wt_link_track;
			}
			echo '",'."\n"; // Link Track ends
			if($this->rba_wt_link_track != none && $this->rba_wt_link_track_attribute != 'INVALID') {
				echo '	linkTrackAttribute : "'.$this->rba_wt_link_track_attribute.'",'."\n";
			}
			echo '	heatmap : "'.$this->rba_wt_heatmap.'"';
			if($this->rba_wt_siteForm != "1") {
				echo ",\n" .'	form : "'.$this->rba_wt_form.'"';
			}
			echo "\n" .'};'."\n";
			echo 'var wt = new webtrekkV3(webtrekk);'."\n";
			echo 'wt.contentGroup = {'."\n";
			// Let's cycle through all available CGs and show them if != "-"
			$i = 0; // Counts the cycles
			$k = 0; // Counts the CGs that have been shown on the page
			while ($i <= $this->rba_wt_cg_Counter) {
				if ($this->rba_wt_cg[$i] != "-")
				{
					if ($k > 0) {
							echo ",\n";
						}
					echo '	'.($i+1).' : "',$this->rba_wt_cg[$i],'"';
					$k++;
				}
				$i++;
			}
			echo "\n};\n";
			if($this->rba_wt_page_parameters_present == 1){
				echo 'wt.customParameter = {'."\n";
				if ($this->rba_wt_cp_document_title_display == 1) {
					if ($this->rba_wt_page_parameter_previous == 1) {
						echo ",\n";
					}
					echo '	' . $this->rba_wt_cp_document_title_number . ' : document.title';
					$this->rba_wt_page_parameter_previous = 1;
				}
				if ($this->rba_wt_cp_post_author_display == 1 && !is_home()) {
					if ($this->rba_wt_page_parameter_previous == 1) {
						echo ",\n";
					}
					echo '	' . $this->rba_wt_cp_post_author_number . ' : "' . $this->rba_wt_cp_post_author_value . '"';
					$this->rba_wt_page_parameter_previous = 1;
				}
				if ($this->rba_wt_cp_word_count_display == 1 && !is_home()) {
					if ($this->rba_wt_page_parameter_previous == 1) {
						echo ",\n";
					}
					echo '	' . $this->rba_wt_cp_word_count_number . ' : "' . $this->rba_wt_cp_word_count_value . '"';
					$this->rba_wt_page_parameter_previous = 1;
				}
				// Insert code to display more page parameters here
				echo "\n};\n";
			}
			echo 'wt.sendinfo()'."\n";
			echo '//-->'."\n";
			echo '</script>'."\n";
			echo '<noscript>'."\n";
			echo '	<div>'."\n";
			echo $rba_wt_noscript_url."\n";
			echo '	</div>'."\n";
			echo '</noscript>'."\n";
			echo '<!-- /Webtrekk -->'."\n";
		}
	}
	
	/**
	 * Content Group Instantiation Method.
	 *
	 * Should only be called from the constructor.
	 * First, we retrieve the options for the Content Groups.
	 * Then the number of desired CGs is checked against reality.
	 * Then the CG counter is checked and eventually corrected.
	 * Then a cycle checks every CG level.
	 * The first time a dynamic CG is found, the post type is scanned (blog or page)
	 * and all the available dynamic CG names are retrieved and cached.
	 * From then on, all dynamic CGs are named based on the retrieved values.
	 * Remember that the counter is the desired value - 1
	 * i.e. CG Level1 is $rba_wt_cg[0]
	 *
	 * @since 0.0.3
	 *
	 * @see Webtrekk_Q3_Pixel
	 * @see __construct()
	 *
	 * @global array $rba_wt_cg_TEMPoptions Used to retrieve and store the Content Group options from the DB
	 */
	private function setup_content_groups() {
		$rba_wt_cg_TEMPoptions = get_option('rba_wt_cg_DBoptions');
		$rba_wt_cg_TEMPoptions['rba_wt_cg_Counter'] = intval($rba_wt_cg_TEMPoptions['rba_wt_cg_Counter']);
		// Firs we check that the options actually exist and that the counter is an integer and it's not negative
		if ($rba_wt_cg_TEMPoptions != false && gettype($rba_wt_cg_TEMPoptions['rba_wt_cg_Counter']) == "integer" && $rba_wt_cg_TEMPoptions['rba_wt_cg_Counter'] > 0) {
			// Yes, they do exist.
			if ($rba_wt_cg_TEMPoptions['rba_wt_cg_Counter'] <= 9) {
				// The counter is below 9, good!
				$this->rba_wt_cg_Counter = $rba_wt_cg_TEMPoptions['rba_wt_cg_Counter'];
			}
			else {
				// The counter is too high, let's set it to 9
				$this->rba_wt_cg_Counter = 9; // Max fallback value
			}
		}
		else {
			// No, the options don't exist or the counter is negative or it's not an integer
			$this->rba_wt_cg_Counter = 0; // Min or null fallback value.
		}
		// Now it's time to cycle through the names
		$i = 0;
		// echo "\n".'<!--DEBUG $this->rba_wt_cg_Counter -> '.$this->rba_wt_cg_Counter.' -->'."\n";
		while ($i <= $this->rba_wt_cg_Counter) {
			// echo "\n".'<!--DEBUG $i -> '.$i.' -->'."\n";
			// echo "\n".'<!--DEBUG $rba_wt_cg_TEMPoptions[rba_wt_cg_name_isDynamic_.$i] -> '.$rba_wt_cg_TEMPoptions['rba_wt_cg_name_isDynamic_'.$i].' -->'."\n";
			// Is the CG name dynamic?
			if ($rba_wt_cg_TEMPoptions != false && $rba_wt_cg_TEMPoptions['rba_wt_cg_name_isDynamic_'.$i] == 1) {
				// Yes, the CG name is dynamic
				// Is it the first time that we find a dynamic CG?
				// echo "\n".'<!--DEBUG $this->rba_wt_cg_firstDynamic -> '.$this->rba_wt_cg_firstDynamic.' -->'."\n";
				if ($this->rba_wt_cg_firstDynamic == 0) {
					// Yes, this is the first time we find one
					$this->rba_wt_cg_dynamicCount = 0;
					// Is this a post or a page?
					// echo "\n".'<!--DEBUG get_post_type($post) -> '.get_post_type($post).' -->'."\n";
					if (get_post_type($post)=='post') {
						// This is a post
						// Since a post can have multiple categories, I will only use "Blog" as the sole CG
						$this->rba_wt_cg_dynamic[0] = "Blog";
					}
					else {
						// This is not a post, so it's a page
						// echo "\n".'<!--DEBUG $post->post_parent -> '.$post->post_parent.' -->'."\n";
						// echo "\n".'<!--DEBUG get_the_id() -> '.get_the_id().' -->'."\n";
						// echo "\n".'<!--DEBUG get_the_title($post) -> '.get_the_title($post).' -->'."\n";
						if ($post->post_parent)	{
							// echo "\n".'<!--DEBUG a parent was found -->'."\n";
							$rba_wt_temp_ancestors=get_post_ancestors($post->ID);
							$ancestors_counter = 1;
							while ($ancestors_counter <= count($rba_wt_temp_ancestors)) {
								$root=count($rba_wt_temp_ancestors)-$ancestors_counter;
								$parent = $rba_wt_temp_ancestors[$root];
								$this->rba_wt_cg_dynamic[$ancestors_counter - 1] = get_the_title($parent);
								// echo "\n".'<!--DEBUG get_the_title($parent) -> '.get_the_title($parent).' -->'."\n";
								$ancestors_counter ++;
							}
						}
						else {
							// echo "\n".'<!--DEBUG a parent was not found -->'."\n";
							$this->rba_wt_cg_dynamic[0] = get_the_title($post->ID); // Fallback
							// echo "\n".'<!--DEBUG $this->rba_wt_cg_dynamic[0] -> '.$this->rba_wt_cg_dynamic[0].' -->'."\n";
						}
					}
					$this->rba_wt_cg_dynamicCountAvailable = count($this->rba_wt_cg_dynamic);
					$this->rba_wt_cg_dynamicCountUsed = 0;
					$this->rba_wt_cg_firstDynamic = 1;
				}
				// If there are available dynamic CGs, we use them
				// echo "\n".'<!--DEBUG ($this->rba_wt_cg_dynamicCountUsed < $this->rba_wt_cg_dynamicCountAvailable) -> '.$this->rba_wt_cg_dynamicCountUsed.$this->rba_wt_cg_dynamicCountAvailable.' -->'."\n";
				if ($this->rba_wt_cg_dynamicCountUsed < $this->rba_wt_cg_dynamicCountAvailable) {
					$this->rba_wt_cg[$i] = $this->rba_wt_cg_dynamic[$this->rba_wt_cg_dynamicCountUsed];
					$this->rba_wt_cg_dynamicCountUsed ++;
				}
				else {
					$this->rba_wt_cg[$i] = "-"; // Fallback
				}
			}
			else {
				// Nope, the CG name is not dynamic.
				// Is the static CG name valid?
				if ($rba_wt_cg_TEMPoptions != false && ( gettype($rba_wt_cg_TEMPoptions['rba_wt_cg_name_'.$i]) == 'string' && $rba_wt_cg_TEMPoptions['rba_wt_cg_name_'.$i] != '' )) {
					// Yes, we have our CG name
					$this->rba_wt_cg[$i] = $rba_wt_cg_TEMPoptions['rba_wt_cg_name_'.$i];
				}
				else {
					// Nope, invalid CG name, let's fall back
					$this->rba_wt_cg[$i] = "-"; // The fallback value is passed
				}
			}
			$i ++;
		}
	}
	
	/**
	 * Page Options Instantiation Method.
	 *
	 * Should only be called from the constructor.
	 * First, we retrieve the options.
	 * Then we check if the options are valid.
	 * If they aren't, we reset the defaults for this page
	 *
	 * @since 0.0.3
	 *
	 * @see Webtrekk_Q3_Pixel
	 * @see __construct()
	 *
	 * @global array $rba_wt_page_definition_DBoptions Used to retrieve and store the Page options from the DB
	 */
	private function setup_page_options() {
		$rba_wt_page_definition_DBoptions = get_option('rba_wt_page_definition_DBoptions');
		if ($rba_wt_page_definition_DBoptions != false) {
			// Validate the contentId mode
			$rba_wt_page_definition_DBoptions['rba_wt_content_id_mode'] = intval($rba_wt_page_definition_DBoptions['rba_wt_content_id_mode']);
			if(gettype($rba_wt_page_definition_DBoptions['rba_wt_content_id_mode']) == "integer" && $rba_wt_page_definition_DBoptions['rba_wt_content_id_mode'] >= 0 && $rba_wt_page_definition_DBoptions['rba_wt_content_id_mode'] <= 3) {
				$this->rba_wt_content_id_mode = $rba_wt_page_definition_DBoptions['rba_wt_content_id_mode'];
			}
			else {
				$this->rba_wt_content_id_mode = 0;
			}
			// Validate the link tracking mode
			if($rba_wt_page_definition_DBoptions['rba_wt_link_track'] == "none" || $rba_wt_page_definition_DBoptions['rba_wt_link_track'] == "link" || $rba_wt_page_definition_DBoptions['rba_wt_link_track'] == "standard") {
				$this->rba_wt_link_track = $rba_wt_page_definition_DBoptions['rba_wt_link_track'];
			}
			else {
				$this->rba_wt_link_track = 'none';
			}
			// Validate the presence of the linkTrack attribute
			$rba_wt_page_definition_DBoptions['rba_wt_link_track_attribute_present'] = intval($rba_wt_page_definition_DBoptions['rba_wt_link_track_attribute_present']);
			if(gettype($rba_wt_page_definition_DBoptions['rba_wt_link_track_attribute_present']) == "integer" && $rba_wt_page_definition_DBoptions['rba_wt_link_track_attribute_present'] = 1) {
				$this->rba_wt_link_track_attribute_present = 1;
			}
			else {
				$this->rba_wt_link_track_attribute_present = 0;
			}
			// Validate the linkTrack attribute - this needs improving
			if(gettype($rba_wt_page_definition_DBoptions['rba_wt_link_track_attribute']) == "string") {
				$this->rba_wt_link_track_attribute = $rba_wt_page_definition_DBoptions['rba_wt_link_track_attribute'];
			}
			else {
				$this->rba_wt_link_track_attribute = 'INVALID';
			}
			// Validate the presence of the heatmap attribute
			$rba_wt_page_definition_DBoptions['rba_wt_heatmap'] = intval($rba_wt_page_definition_DBoptions['rba_wt_heatmap']);
			if(gettype($rba_wt_page_definition_DBoptions['rba_wt_heatmap']) == "integer" && $rba_wt_page_definition_DBoptions['rba_wt_heatmap'] = 1) {
				$this->rba_wt_heatmap = "1";
			}
			else {
				$this->rba_wt_heatmap = '';
			}
			$this->rba_wt_form = '';
		}
	}
	
	/**
	 * Page Parameter Instantiation Method.
	 *
	 * Should only be called from the constructor.
	 *
	 * @since 0.0.3
	 *
	 * @see Webtrekk_Q3_Pixel
	 * @see __construct()
	 *
	 * @global array $rba_wt_page_parameters_TEMPoptions Used to retrieve and store the Content Group options from the DB
	 */
	private function setup_page_parameter() {
		$rba_wt_page_parameters_TEMPoptions = get_option('rba_wt_page_parameters_DBoptions');
		if ($rba_wt_page_parameters_TEMPoptions != false) {
			// Check and initialise the document.title parameter
			if(intval($rba_wt_page_parameters_TEMPoptions['document_title_display']) == 1 && intval($rba_wt_page_parameters_TEMPoptions['document_title_number']) >0) {
				$this->rba_wt_cp_document_title_display = intval($rba_wt_page_parameters_TEMPoptions['document_title_display']);
				$this->rba_wt_cp_document_title_number = intval($rba_wt_page_parameters_TEMPoptions['document_title_number']);
				$this->rba_wt_page_parameters_present = 1;
			}
			// Check and initialise the post author parameter
			if(intval($rba_wt_page_parameters_TEMPoptions['post_author_display']) == 1 && intval($rba_wt_page_parameters_TEMPoptions['post_author_number']) >0) {
				$this->rba_wt_cp_post_author_display = intval($rba_wt_page_parameters_TEMPoptions['post_author_display']);
				$this->rba_wt_cp_post_author_number = intval($rba_wt_page_parameters_TEMPoptions['post_author_number']);
				$this->rba_wt_page_parameters_present = 1;
				if(gettype(get_the_author()) == "string" && get_the_author() != "") {
					$this->rba_wt_cp_post_author_value = get_the_author();
				}
				else {
					$this->rba_wt_cp_post_author_value = "not available";
				}
			}
			// Check and initialise the word count parameter
			if(intval($rba_wt_page_parameters_TEMPoptions['word_count_display']) == 1 && intval($rba_wt_page_parameters_TEMPoptions['word_count_number']) >0) {
				$this->rba_wt_cp_word_count_display = intval($rba_wt_page_parameters_TEMPoptions['word_count_display']);
				$this->rba_wt_cp_word_count_number = intval($rba_wt_page_parameters_TEMPoptions['word_count_number']);
				$this->rba_wt_page_parameters_present = 1;
				$rba_wt_wordcount_temp_content = get_post_field( 'post_content', $post->ID );
				$this->rba_wt_cp_word_count_value = str_word_count( strip_tags( $rba_wt_wordcount_temp_content ) );
			}
		}
	}
}

/**
 * Pixel setup and display function.
 *
 * It creates a new pixel, then calls its display method.
 * This function should only be hooked to the footer of the page.
 *
 * @since 0.0.1
 *
 * @see Webtrekk_Q3_Pixel
 * @see Webtrekk_Q3_Pixel::__construct()
 * @see Webtrekk_Q3_Pixel::display()
 */
function get_Webtrekk_Q3_Pixel()
{
	$The_Pixel = new Webtrekk_Q3_Pixel($post->ID);
	$The_Pixel->display();
}

// Plugin hook when the footer is called.
add_action( 'get_footer', 'get_Webtrekk_Q3_Pixel' );

	
//Installation and uninstallation hooks
register_activation_hook(__FILE__, 'activate');
register_deactivation_hook(__FILE__, 'deactivate');

// Includes the options page file
if( is_admin() )
	include( plugin_dir_path( __FILE__ ) . 'includes/rba_wt_options.php');