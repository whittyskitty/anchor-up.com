<?php

GFForms::include_feed_addon_framework();

class GravityFormsColorFieldAddOn extends GFFeedAddOn {

	protected $_version = GRAVITY_FORMS_COLOR_FIELD_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'gravity-forms-color-field';
	protected $_path = 'gravity-forms-color-field/gravity-forms-color-field.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Color Field';
	protected $_short_title = 'Gravity Forms Color Field';

	private static $_instance = null;

	//Get an instance of this class
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GravityFormsColorFieldAddOn();
		}
		return self::$_instance;
	}
    

    public function pre_init() {
		parent::pre_init();

		if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
			require_once( 'inc/class-color-gf-field.php' );
		}
    }
    
    public function init_admin() {
		parent::init_admin();

		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );
		add_action( 'gform_field_appearance_settings', array( $this, 'field_appearance_settings' ), 10, 2 );
	}




    /**
	 * Include my_script.js when the form contains a 'color' type field.
	 *
	 * @return array
	 */
	public function scripts() {
		$scripts = array(
			array(
				'handle'  => 'js_color',
				'src'     => $this->get_base_url() . '/js/jscolor.js',
				'version' => $this->_version,
				// 'deps'    => array( 'jquery'),
				'enqueue' => array(
					array( 'field_types' => array( 'color' ) ),
				),
			),
			array(
				'handle'  => 'color_picker',
				'src'     => $this->get_base_url() . '/js/colorpicker.js',
				'version' => $this->_version,
				// 'deps'    => array( 'jquery'),
				'enqueue' => array(
					array( 'field_types' => array( 'color' ) ),
				),
			),
			array(
				'handle'  => 'my_script_js',
				'src'     => $this->get_base_url() . '/js/frontendscript.js',
				'version' => $this->_version,
				'deps'    => array( 'jquery'),
				'enqueue' => array(
					array( 'field_types' => array( 'color' ) ),
				),
			),
			

		);

		return array_merge( parent::scripts(), $scripts );
	}

	/**
	 * Include my_styles.css when the form contains a 'color' type field.
	 *
	 * @return array
	 */
	public function styles() {
		$styles = array(
			// array(
			// 	'handle'  => 'my_styles_css',
			// 	'src'     => $this->get_base_url() . '/css/frontendstyle.css',
			// 	'version' => $this->_version,
			// 	'enqueue' => array(
			// 		array( 'field_types' => array( 'color' ) )
			// 	)
			// )
			array(
				'handle'  => 'color_picker',
				'src'     => $this->get_base_url() . '/css/colorpicker.css',
				'version' => $this->_version,
				'enqueue' => array(
					array( 'field_types' => array( 'color' ) )
				)
			)
		);

		return array_merge( parent::styles(), $styles );
	}











    // # FIELD SETTINGS -------------------------------------------------------------------------------------------------

	/**
	 * Add the tooltips for the field.
	 *
	 * @param array $tooltips An associative array of tooltips where the key is the tooltip name and the value is the tooltip.
	 *
	 * @return array
	 */
	public function tooltips( $tooltips ) {
		$color_tooltips = array(
			'color_picker_type_setting' => sprintf( '<h6>%s</h6>%s', esc_html__( 'Color Picker Type', 'gravity-forms-color-field ' ), esc_html__( 'Choose whether to use the simple or advanced color picker.', 'gravity-forms-color-field ' ) ),
		);

		return array_merge( $tooltips, $color_tooltips );
	}

	/**
	 * Add the custom setting for the Color field to the Appearance tab.
	 *
	 * @param int $position The position the settings should be located at.
	 * @param int $form_id The ID of the form currently being edited.
	 */
	public function field_appearance_settings( $position, $form_id ) {
		// Add our custom setting just before the 'Custom CSS Class' setting.
		if ( $position == 250 ) {
			?>
			<li class="color_picker_type_setting field_setting">
				<label for="color_picker_type_setting">
					<?php esc_html_e( 'Color Picker Type', 'gravity-forms-color-field ' ); ?>
					<?php gform_tooltip( 'color_picker_type_setting' ) ?>
				</label>

				<select style="display: inherit !important;" id="color_picker_type_setting" class="fieldwidth-1" onchange="SetInputClassSetting(jQuery(this).val());">
				<?php 
				
					$options = array('Simple','Advanced');
					foreach($options as $option){
						echo '<option>'.$option.'</option>';
					}

				?>
				</select>


				<!-- <input id="color_picker_type_setting" type="text" class="fieldwidth-1" onkeyup="SetInputClassSetting(jQuery(this).val());" onchange="SetInputClassSetting(jQuery(this).val());"/> -->
			</li>

			<?php
		}
	}















    //create settings fields on the main gravity forms settings page
	public function plugin_settings_fields() {
		return array(
            
            array(
				'title'  => esc_html__( 'Licence Activation', 'gravity-forms-color-field' ),
				'fields' => array(
					array(
						'name'              => 'purchase-email-address',
						'label'             => esc_html__( 'Purchase email address', 'gravity-forms-color-field' ),
						'type'              => 'text',
						'class'             => 'medium',
						'feedback_callback' => array( $this, 'is_valid_email' ),
                        'tooltip'           => esc_html__('This was sent to you via email upon purchase of the plugin.', 'gravity-forms-color-field')
					),
                    array(
						'name'              => 'order-id',
						'label'             => esc_html__( 'Order ID', 'gravity-forms-color-field' ),
						'type'              => 'text',
						'class'             => 'medium',
                        'feedback_callback' => array( $this, 'is_valid_order' ),
                        'tooltip'           => esc_html__('This was sent to you via email upon purchase of the plugin.', 'gravity-forms-color-field')
					),
					array(
						'name' => 'force-plugin-updates',
						'type' => 'force_plugin_updates',
					),

				)
			),
            
	
		);
	}
    
	public function settings_force_plugin_updates( $field, $echo = true ) {
		color_field_gravityforms_connector_force_check_for_updates();
	}
    
    //validation of order id field
    public function is_valid_order($value) {
		return strlen( $value ) <= 8 && strlen( $value ) >= 4;
	}
    
    //validation of email settings field
    public function is_valid_email($value) {
        
        if(strpos($value,'@') !== false && strlen($value) < 100) {
            return true;
        } else {
            return false;
        }
        
	}


    
    

}