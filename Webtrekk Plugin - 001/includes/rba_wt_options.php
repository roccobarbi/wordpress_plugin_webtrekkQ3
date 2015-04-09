<?php
class rba_wt_settings_page
{
    /**
     * Holds the values to be used in the fields callbacks
     */
	private $global_options;
	private $cg_options;
	private $page_definition_options;
	private $page_parameter_options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
		add_options_page(
			'Webtrekk Settings',
			'Webtrekk Settings',
			'manage_options',
			'rba-wt-settings', // Page Slug
			array( $this, 'create_admin_page' )
		);
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
		$this->cg_options = get_option( 'rba_wt_cg_DBoptions' );
		$this->global_options = get_option( 'rba_wt_global_DBoptions' );
		$this->page_definition_options = get_option('rba_wt_page_definition_DBoptions');
		$this->page_parameter_options = get_option('rba_wt_page_parameters_DBoptions');
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Webtrekk Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
				settings_fields( 'rba_wt_settings_optgroup' );  // => Please note that all sections in a page must be part of the same option group
                do_settings_sections( 'rba_wt_settings' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
		// BEGIN Global Settings
		
		register_setting(
			'rba_wt_settings_optgroup', // Option group
			'rba_wt_global_DBoptions', // Option name
			'' // Sanitize
		);
		
		add_settings_section(
			'rba_wt_settings_global_section', // Section ID
			'Global Webtrekk Settings', // Title
			array( $this, 'rba_wt_settings_global_text' ), // Callback
			'rba_wt_settings' // Page must be equal to the Page Slug
		);
		// Boolean: is the plugin active?
		add_settings_field(
			'rba_wt_pluginIsActive', // ID
			'Check to activate the Webtrekk plugin', // Title
			array( $this, 'rba_wt_pluginIsActive_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		// Tracking URL
		add_settings_field(
			'rba_wt_tracking_url', // ID
			'Tracking URL', // Title
			array( $this, 'rba_wt_tracking_url_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		// Track ID
		add_settings_field(
			'rba_wt_track_id', // ID
			'Track ID', // Title
			array( $this, 'rba_wt_track_id_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		// Config Domain
		add_settings_field(
			'rba_wt_config_domain', // ID
			'Config Domain', // Title
			array( $this, 'rba_wt_config_domain_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		// Cookie
		add_settings_field(
			'rba_wt_cookie', // ID
			'Cookie', // Title
			array( $this, 'rba_wt_cookie_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		// Form Tracking
		add_settings_field(
			'rba_wt_siteForm', // ID
			'Site-wide Form Tracking', // Title
			array( $this, 'rba_wt_siteForm_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		// Track ID
		add_settings_field(
			'rba_wt_media_code', // ID
			'Media Code', // Title
			array( $this, 'rba_wt_media_code_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		// Page Scroll Plugin
		add_settings_field(
			'rba_wt_pageScrollIsActive', // ID
			'Acrivate Page Scroll Plugin?', // Title
			array( $this, 'rba_wt_pageScrollIsActive_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_global_section' // Section must be equal to the Section ID
		);
		
		// END Global Settings
		
		// BEGIN Page Settings
		
		register_setting(
			'rba_wt_settings_optgroup', // Option group
			'rba_wt_page_definition_DBoptions', // Option name
			'' // Sanitize
		);
		
		add_settings_section(
			'rba_wt_page_definition_section', // Section ID
			'Webtrekk Page Settings', // Title
			array( $this, 'rba_wt_page_definition_text' ), // Callback
			'rba_wt_settings' // Page must be equal to the Page Slug
		);
		// How do we define the Content ID?
		add_settings_field(
			'rba_wt_content_id_mode', // ID
			'Content ID Generation mode', // Title
			array( $this, 'rba_wt_content_id_mode_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_page_definition_section' // Section must be equal to the Section ID
		);
		// Link Track
		add_settings_field(
			'rba_wt_link_track', // ID
			'Link Track', // Title
			array( $this, 'rba_wt_link_track_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_page_definition_section' // Section must be equal to the Section ID
		);
		// Is there a linkTrackAttribute?
		add_settings_field(
			'rba_wt_link_track_attribute_present', // ID
			'Check to activate the linkTrackAttribute', // Title
			array( $this, 'rba_wt_link_track_attribute_present_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_page_definition_section' // Section must be equal to the Section ID
		);
		// linkTrackAttribute
		add_settings_field(
			'rba_wt_link_track_attribute', // ID
			'linkTrackAttribute', // Title
			array( $this, 'rba_wt_link_track_attribute_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_page_definition_section' // Section must be equal to the Section ID
		);
		// Heatmap
		add_settings_field(
			'rba_wt_heatmap', // ID
			'Check to activate the heatmap', // Title
			array( $this, 'rba_wt_heatmap_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_page_definition_section' // Section must be equal to the Section ID
		);
		// Form tracking still needs to be defined (logic side)
		
		// END Page Settings
		
		// BEGIN Page Parameter Settings
		
		register_setting(
			'rba_wt_settings_optgroup', // Option group
			'rba_wt_page_parameters_DBoptions', // Option name
			'' // Sanitize
		);
		
		add_settings_section(
			'rba_wt_settings_page_parameter_section', // Section ID
			'Page Parameter Settings', // Title
			array( $this, 'rba_wt_settings_page_parameter_text' ), // Callback
			'rba_wt_settings' // Page must be equal to the Page Slug
		);
		// Is there a document.title page parameter?
		add_settings_field(
			'document_title_display', // ID
			'Check to display the document.title parameter.', // Title
			array( $this, 'rba_wt_document_title_display_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_page_parameter_section' // Section must be equal to the Section ID
		);
		// What's the number of the document.title page parameter?
		add_settings_field(
			'document_title_number', // ID
			'What is the number of the document.title parameter?', // Title
			array( $this, 'rba_wt_document_title_number_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_page_parameter_section' // Section must be equal to the Section ID
		);
		// Is there a Post Author page parameter?
		add_settings_field(
			'post_author_display', // ID
			'Check to display the Post Author parameter.', // Title
			array( $this, 'rba_wt_post_author_display_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_page_parameter_section' // Section must be equal to the Section ID
		);
		// What's the number of the Post Author page parameter?
		add_settings_field(
			'post_author_number', // ID
			'What is the number of the Post Author parameter?', // Title
			array( $this, 'rba_wt_post_author_number_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_page_parameter_section' // Section must be equal to the Section ID
		);
		// Is there a Word Count page parameter?
		add_settings_field(
			'word_count_display', // ID
			'Check to display the Word Count parameter.', // Title
			array( $this, 'rba_wt_word_count_display_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_page_parameter_section' // Section must be equal to the Section ID
		);
		// What's the number of the Word Count page parameter?
		add_settings_field(
			'word_count_number', // ID
			'What is the number of the Word Count parameter?', // Title
			array( $this, 'rba_wt_word_count_number_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_page_parameter_section' // Section must be equal to the Section ID
		);
		
		// END Page Parameter Settings
		
		// BEGIN Content Group Settings
		
		register_setting(
			'rba_wt_settings_optgroup', // Option group
			'rba_wt_cg_DBoptions', // Option name
			'' // Sanitize
		);
		
		add_settings_section(
			'rba_wt_settings_cg_section', // Section ID
			'Content Group Settings', // Title
			array( $this, 'rba_wt_settings_cg_text' ), // Callback
			'rba_wt_settings' // Page must be equal to the Page Slug
		);
		// Content Group Counter
		add_settings_field(
			'rba_wt_cg_Counter', // ID
			'How many CG levels do you need? [1-10]', // Title
			array( $this, 'rba_wt_cg_Counter_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 1
		// Indice: 0
		add_settings_field(
			'rba_wt_cg_name_isDynamic_0', // ID
			'Check to make the CG 1 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_0_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_0', // ID
			'Name for the CG Level 1 (if static)', // Title
			array( $this, 'rba_wt_cg_name_0_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 2
		// Indice: 1
		add_settings_field(
			'rba_wt_cg_name_isDynamic_1', // ID
			'Check to make the CG 2 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_1_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_1', // ID
			'Name for the CG Level 2 (if static)', // Title
			array( $this, 'rba_wt_cg_name_1_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 3
		// Indice: 2
		add_settings_field(
			'rba_wt_cg_name_isDynamic_2', // ID
			'Check to make the CG 3 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_2_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_2', // ID
			'Name for the CG Level 3 (if static)', // Title
			array( $this, 'rba_wt_cg_name_2_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 4
		// Indice: 3
		add_settings_field(
			'rba_wt_cg_name_isDynamic_3', // ID
			'Check to make the CG 4 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_3_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_3', // ID
			'Name for the CG Level 4 (if static)', // Title
			array( $this, 'rba_wt_cg_name_3_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 5
		// Indice: 4
		add_settings_field(
			'rba_wt_cg_name_isDynamic_4', // ID
			'Check to make the CG 5 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_4_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_4', // ID
			'Name for the CG Level 5 (if static)', // Title
			array( $this, 'rba_wt_cg_name_4_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 6
		// Indice: 5
		add_settings_field(
			'rba_wt_cg_name_isDynamic_5', // ID
			'Check to make the CG 6 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_5_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_5', // ID
			'Name for the CG Level 6 (if static)', // Title
			array( $this, 'rba_wt_cg_name_5_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 7
		// Indice: 6
		add_settings_field(
			'rba_wt_cg_name_isDynamic_6', // ID
			'Check to make the CG 7 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_6_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_6', // ID
			'Name for the CG Level 7 (if static)', // Title
			array( $this, 'rba_wt_cg_name_6_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 8
		// Indice: 7
		add_settings_field(
			'rba_wt_cg_name_isDynamic_7', // ID
			'Check to make the CG 8 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_7_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_7', // ID
			'Name for the CG Level 8 (if static)', // Title
			array( $this, 'rba_wt_cg_name_7_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 9
		// Indice: 8
		add_settings_field(
			'rba_wt_cg_name_isDynamic_8', // ID
			'Check to make the CG 9 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_8_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_8', // ID
			'Name for the CG Level 9 (if static)', // Title
			array( $this, 'rba_wt_cg_name_8_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		// Content Group Livello 10
		// Indice: 9
		add_settings_field(
			'rba_wt_cg_name_isDynamic_9', // ID
			'Check to make the CG 10 dynamic', // Title
			array( $this, 'rba_wt_cg_name_isDynamic_9_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		add_settings_field(
			'rba_wt_cg_name_9', // ID
			'Name for the CG Level 10 (if static)', // Title
			array( $this, 'rba_wt_cg_name_9_input' ), // Callback
			'rba_wt_settings', // Page
			'rba_wt_settings_cg_section' // Section must be equal to the Section ID
		);
		
		// END Content Group Settings
		
	}
	
	/** 
	 * Print the Section text for the Global Webtrekk Settings
	 */
	public function rba_wt_settings_global_text() {
		print 'Global settings for the Webtrekk Plugin.<br />
		Please note that the <em>Activate Plugin</em> checkbox must be checked, or the Webtrekk pixel won\'t be inserted into your website\'s pages.<br />
		Be careful to enter the right data, or the calls won\'t work and Webtrekk won\'t record any data.';
	}
	
	/** 
     * Get the settings option array and print one of its values
     */
	public function rba_wt_pluginIsActive_input() {
		printf(
			'<input type="checkbox" id="rba_wt_pluginIsActive" name="rba_wt_global_DBoptions[rba_wt_pluginIsActive]" value="1"' . checked( 1, $this->global_options['rba_wt_pluginIsActive'], false ) . ' />'
		);
	}
	
	public function rba_wt_tracking_url_input() {
		printf(
			'<input type="text" id="rba_wt_tracking_url" name="rba_wt_global_DBoptions[rba_wt_tracking_url]" value="%s" />' , isset( $this->global_options['rba_wt_tracking_url'] ) ? esc_attr( $this->global_options['rba_wt_tracking_url']) : ''
		);
	}
	
	public function rba_wt_track_id_input() {
		printf(
			'<input type="text" id="rba_wt_track_id" name="rba_wt_global_DBoptions[rba_wt_track_id]" value="%s" />' , isset( $this->global_options['rba_wt_track_id'] ) ? esc_attr( $this->global_options['rba_wt_track_id']) : ''
		);
	}
	
	public function rba_wt_config_domain_input() {
		printf(
			'<input type="text" id="rba_wt_config_domain" name="rba_wt_global_DBoptions[rba_wt_config_domain]" value="%s" />' , isset( $this->global_options['rba_wt_config_domain'] ) ? esc_attr( $this->global_options['rba_wt_config_domain']) : ''
		);
	}
	
	public function rba_wt_cookie_input() {
		printf(
			"\n".'<select id="rba_wt_cookie" name="rba_wt_global_DBoptions[rba_wt_cookie]">'.
			"\n	".'<option value="0"' . selected( $this->global_options['rba_wt_cookie'], "0", false) . '>First Party Cookie</option>'.
			"\n	".'<option value="1"' . selected( $this->global_options['rba_wt_cookie'], "1", false) . '>Third Party Cookie</option>'.
			"\n".'</select>'."\n"
        );
	}
	
	public function rba_wt_media_code_input() {
		printf(
			'<input type="text" id="rba_wt_media_code" name="rba_wt_global_DBoptions[rba_wt_media_code]" value="%s" />' , isset( $this->global_options['rba_wt_media_code'] ) ? esc_attr( $this->global_options['rba_wt_media_code']) : ''
		);
	}
	
	public function rba_wt_siteForm_input() {
		printf(
			'<input type="checkbox" id="rba_wt_siteForm" name="rba_wt_global_DBoptions[rba_wt_siteForm]" value="1"' . checked( 1, $this->global_options['rba_wt_siteForm'], false ) . ' />'
		);
	}
	
	public function rba_wt_pageScrollIsActive_input() {
		printf(
			'<input type="checkbox" id="rba_wt_pageScrollIsActive" name="rba_wt_global_DBoptions[rba_wt_pageScrollIsActive]" value="1"' . checked( 1, $this->global_options['rba_wt_pageScrollIsActive'], false ) . ' />'
		);
	}
	
	/** 
	 * Print the Section text for the Content Group Settings
	 */
	public function rba_wt_page_definition_text()
    {
        print 'Page settings for the Webtrekk plugin.';
    }

    /** 
     * Get the settings option array and print one of its values
     */
	public function rba_wt_content_id_mode_input() {
		printf(
			"\n".'<select id="rba_wt_content_id_mode" name="rba_wt_page_definition_DBoptions[rba_wt_content_id_mode]">'.
			"\n	".'<option value="0"' . selected( $this->page_definition_options['rba_wt_content_id_mode'], "0", false) . '>Default UTF</option>'.
			"\n	".'<option value="1"' . selected( $this->page_definition_options['rba_wt_content_id_mode'], "1", false) . '>Normalized URL</option>'.
			"\n	".'<option value="2"' . selected( $this->page_definition_options['rba_wt_content_id_mode'], "2", false) . '>Full URL</option>'.
			"\n	".'<option value="3"' . selected( $this->page_definition_options['rba_wt_content_id_mode'], "3", false) . '>Document Title</option>'.
			"\n".'</select>'."\n"
        );
	}
	public function rba_wt_link_track_input() {
		printf(
			"\n".'<select id="rba_wt_link_track" name="rba_wt_page_definition_DBoptions[rba_wt_link_track]">'.
			"\n	".'<option value="link"' . selected( $this->page_definition_options['rba_wt_link_track'], "link", false) . '>Link</option>'.
			"\n	".'<option value="standard"' . selected( $this->page_definition_options['rba_wt_link_track'], "standard", false) . '>Standard</option>'.
			"\n	".'<option value="none"' . selected( $this->page_definition_options['rba_wt_link_track'], "none", false) . '>None</option>'.
			"\n".'</select>'."\n"
        );
	}
	public function rba_wt_link_track_attribute_present_input() {
		printf(
			'<input type="checkbox" id="rba_wt_link_track_attribute_present" name="rba_wt_page_definition_DBoptions[rba_wt_link_track_attribute_present]" value="1"' . checked( 1, $this->page_definition_options['rba_wt_link_track_attribute_present'], false ) . ' />'
		);
	}
	public function rba_wt_link_track_attribute_input() {
		printf(
			'<input type="text" id="rba_wt_link_track_attribute" name="rba_wt_page_definition_DBoptions[rba_wt_link_track_attribute]" value="%s" />' , isset( $this->page_definition_options['rba_wt_link_track_attribute'] ) ? esc_attr( $this->page_definition_options['rba_wt_link_track_attribute']) : ''
		);
	}
	public function rba_wt_heatmap_input() {
		printf(
			'<input type="checkbox" id="rba_wt_heatmap" name="rba_wt_page_definition_DBoptions[rba_wt_heatmap]" value="1"' . checked( 1, $this->page_definition_options['rba_wt_heatmap'], false ) . ' />'
		);
	}
	
	/** 
	 * Print the Section text for the Global Webtrekk Settings
	 */
	public function rba_wt_settings_page_parameter_text() {
		print 'Set the page parameters for your website.<br />
		Please note that the "display" checkbox has precedence over the parameter\'s index';
	}
	
	/** 
     * Get the settings option array and print one of its values
     */
	// Document.title
	public function rba_wt_document_title_display_input() {
		printf(
			'<input type="checkbox" id="document_title_display" name="rba_wt_page_parameters_DBoptions[document_title_display]" value="1"' . checked( 1, $this->page_parameter_options['document_title_display'], false ) . ' />'
		);
	}
	public function rba_wt_document_title_number_input() {
		printf(
		'<input type="text" id="document_title_number" name="rba_wt_page_parameters_DBoptions[document_title_number]" value="%s" />' , isset( $this->page_parameter_options['document_title_number'] ) ? esc_attr( $this->page_parameter_options['document_title_number']) : ''
		);
	}
	// Post Author
	public function rba_wt_post_author_display_input() {
		printf(
			'<input type="checkbox" id="post_author_display" name="rba_wt_page_parameters_DBoptions[post_author_display]" value="1"' . checked( 1, $this->page_parameter_options['post_author_display'], false ) . ' />'
		);
	}
	public function rba_wt_post_author_number_input() {
		printf(
		'<input type="text" id="post_author_number" name="rba_wt_page_parameters_DBoptions[post_author_number]" value="%s" />' , isset( $this->page_parameter_options['post_author_number'] ) ? esc_attr( $this->page_parameter_options['post_author_number']) : ''
		);
	}
	// Word Count
	public function rba_wt_word_count_display_input() {
		printf(
			'<input type="checkbox" id="word_count_display" name="rba_wt_page_parameters_DBoptions[word_count_display]" value="1"' . checked( 1, $this->page_parameter_options['word_count_display'], false ) . ' />'
		);
	}
	public function rba_wt_word_count_number_input() {
		printf(
		'<input type="text" id="word_count_number" name="rba_wt_page_parameters_DBoptions[word_count_number]" value="%s" />' , isset( $this->page_parameter_options['word_count_number'] ) ? esc_attr( $this->page_parameter_options['word_count_number']) : ''
		);
	}
	
	/** 
	 * Print the Section text for the Content Group Settings
	 */
	public function rba_wt_settings_cg_text()
    {
        print 'Content Group settings for the Webtrekk plugin.<br />
		To define more or less Content Groups, change their number and save. Only then you will be able to set them up.<br />
		Please note that the "is dynamic" checkbox has precedence over the static name.';
    }

    /** 
     * Get the settings option array and print one of its values
     */
	public function rba_wt_cg_Counter_input() {
		printf(
			"\n".'<select id="rba_wt_cg_Counter" name="rba_wt_cg_DBoptions[rba_wt_cg_Counter]">'.
			"\n	".'<option value="0"' . selected( $this->cg_options['rba_wt_cg_Counter'], "0", false) . '>1</option>'.
			"\n	".'<option value="1"' . selected( $this->cg_options['rba_wt_cg_Counter'], "1", false) . '>2</option>'.
			"\n	".'<option value="2"' . selected( $this->cg_options['rba_wt_cg_Counter'], '2', false) . '>3</option>'.
			"\n	".'<option value="3"' . selected( $this->cg_options['rba_wt_cg_Counter'], '3', false) . '>4</option>'.
			"\n	".'<option value="4"' . selected( $this->cg_options['rba_wt_cg_Counter'], '4', false) . '>5</option>'.
			"\n	".'<option value="5"' . selected( $this->cg_options['rba_wt_cg_Counter'], '5', false) . '>6</option>'.
			"\n	".'<option value="6"' . selected( $this->cg_options['rba_wt_cg_Counter'], '6', false) . '>7</option>'.
			"\n	".'<option value="7"' . selected( $this->cg_options['rba_wt_cg_Counter'], '7', false) . '>8</option>'.
			"\n	".'<option value="8"' . selected( $this->cg_options['rba_wt_cg_Counter'], '8', false) . '>9</option>'.
			"\n	".'<option value="9"' . selected( $this->cg_options['rba_wt_cg_Counter'], '9', false) . '>10</option>'.
			"\n".'</select>'."\n"
        );
	}
	// Content Group Livello 1
	// Indice: 0
	public function rba_wt_cg_name_isDynamic_0_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_0" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_0]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_0'], false ) . '/>'
        );
	} 
	public function rba_wt_cg_name_0_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_0" name="rba_wt_cg_DBoptions[rba_wt_cg_name_0]" value="%s" />',
            isset( $this->cg_options['rba_wt_cg_name_0'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_0']) : ''
        );
	}
	// Content Group Livello 2
	// Indice: 1
	public function rba_wt_cg_name_isDynamic_1_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_1" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_1]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_1'], false ) . (intval($this->cg_options['rba_wt_cg_Counter']) > 0 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_1_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_1" name="rba_wt_cg_DBoptions[rba_wt_cg_name_1]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 0 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_1'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_1']) : ''
        );
	}
	// Content Group Livello 3
	// Indice: 2
	public function rba_wt_cg_name_isDynamic_2_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_2" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_2]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_2'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 1 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_2_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_2" name="rba_wt_cg_DBoptions[rba_wt_cg_name_2]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 1 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_2'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_2']) : ''
        );
	}
	// Content Group Livello 4
	// Indice: 3
	public function rba_wt_cg_name_isDynamic_3_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_3" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_3]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_3'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 2 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_3_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_3" name="rba_wt_cg_DBoptions[rba_wt_cg_name_3]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 2 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_3'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_3']) : ''
        );
	}
	// Content Group Livello 5
	// Indice: 4
	public function rba_wt_cg_name_isDynamic_4_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_4" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_4]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_4'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 3 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_4_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_4" name="rba_wt_cg_DBoptions[rba_wt_cg_name_4]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 3 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_4'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_4']) : ''
        );
	}
	// Content Group Livello 6
	// Indice: 5
	public function rba_wt_cg_name_isDynamic_5_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_5" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_5]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_5'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 4 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_5_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_5" name="rba_wt_cg_DBoptions[rba_wt_cg_name_5]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 4 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_5'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_5']) : ''
        );
	}
	// Content Group Livello 7
	// Indice: 6
	public function rba_wt_cg_name_isDynamic_6_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_6" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_6]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_6'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 5 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_6_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_6" name="rba_wt_cg_DBoptions[rba_wt_cg_name_6]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 5 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_6'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_6']) : ''
        );
	}
	// Content Group Livello 8
	// Indice: 7
	public function rba_wt_cg_name_isDynamic_7_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_7" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_7]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_7'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 6 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_7_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_7" name="rba_wt_cg_DBoptions[rba_wt_cg_name_7]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 6 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_7'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_7']) : ''
        );
	}
	// Content Group Livello 9
	// Indice: 8
	public function rba_wt_cg_name_isDynamic_8_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_8" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_8]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_8'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 7 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_8_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_8" name="rba_wt_cg_DBoptions[rba_wt_cg_name_8]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 7 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_8'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_8']) : ''
        );
	}
	// Content Group Livello 10
	// Indice: 9
	public function rba_wt_cg_name_isDynamic_9_input() {
		printf(
			'<input type="checkbox" id="rba_wt_cg_name_isDynamic_9" name="rba_wt_cg_DBoptions[rba_wt_cg_name_isDynamic_9]" value="1"' . checked( 1, $this->cg_options['rba_wt_cg_name_isDynamic_9'], false ) . ($this->cg_options['rba_wt_cg_Counter'] > 8 ? '' : 'disabled') . '/>'
        );
	} 
	public function rba_wt_cg_name_9_input() {
		printf(
            '<input type="text" id="rba_wt_cg_name_9" name="rba_wt_cg_DBoptions[rba_wt_cg_name_9]" value="%s"' . ($this->cg_options['rba_wt_cg_Counter'] > 8 ? '' : 'disabled') . ' />',
            isset( $this->cg_options['rba_wt_cg_name_9'] ) ? esc_attr( $this->cg_options['rba_wt_cg_name_9']) : ''
        );
	}
}

if( is_admin() )
    $my_settings_page = new rba_wt_settings_page();