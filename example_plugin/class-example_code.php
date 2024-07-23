<?php

GFForms::include_addon_framework();

class GFExamplecode extends GFAddOn {

	/* original example: https://docs.gravityforms.com/category/developers/php-api/add-on-framework/ */

	protected $_version = EXAMPLE_CODE_ADDON_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'example_code';
	protected $_path = 'example_code/example_code.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms example Integration';
	protected $_short_title = 'example Integration';

	private static $_instance = null;

	/**
	 * Get an instance of this class.
	 *
	 * @return GFExamplecode
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFExamplecode();
		}
		return self::$_instance;
	}

	/**
	 * Handles hooks and loading of language files.
	 */
	public function init() {
		parent::init();
		add_action( 'gform_after_submission', array( $this, 'after_submission' ), 10, 2 );
	}

	/**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {
		return array(
			array(
				'title'  => esc_html__( 'example Integration Add-On Settings', 'example_code' ),
				'fields' => array(
					array(
						'name'              => 'example_apikey',
						'tooltip'           => esc_html__( 'This is the value setup in Marketing Automation in example', 'example_code' ),
						'label'             => esc_html__( 'example API Key', 'example_code' ),
						'type'              => 'text',
						'class'             => 'small',
					),
					array(
						'name'    => 'example_subdomain',
						'tooltip' => esc_html__( 'This maps to a datacenter, values are either app, app2, or app3', 'example_code' ),
						'label'   => esc_html__( 'example Subdomain', 'example_code' ),
						'type'    => 'select',
						'choices' => array(
							array(
								'label' => esc_html__( 'app', 'example_code' ),
								'value' => 'app',
							),
							array(
								'label' => esc_html__( 'app2', 'example_code' ),
								'value' => 'app2',
							),
							array(
								'label' => esc_html__( 'app3', 'example_code' ),
								'value' => 'app3',
							),
						),
					),
					array(
						'name'              => 'example_company_id',
						'tooltip'           => esc_html__( 'This is used in the url and represents a parent corporation ID', 'example_code' ),
						'label'             => esc_html__( 'example Company_ID', 'example_code' ),
						'type'              => 'text',
						'class'             => 'small',
					),
					array(
						'name'              => 'example_community_id',
						'tooltip'           => esc_html__( 'This is alphanumeric value which is the tenant key inside the example database', 'example_code' ),
						'label'             => esc_html__( 'example Community_ID', 'example_code' ),
						'type'              => 'text',
						'class'             => 'small',
					),
					array(
						'name'              => 'example_referral_id',
						'tooltip'           => esc_html__( 'This is alphanumeric value which is the tenant key inside the example database', 'example_code' ),
						'label'             => esc_html__( 'example Referral_ID', 'example_code' ),
						'type'              => 'text',
						'class'             => 'small',
					),
				)
			)
		);
	}

	/**
	 * Configures the settings which should be rendered on the Form Settings.
	 *
	 * @return array
	 */
	public function form_settings_fields( $form ) {
		return array(
			array(
				'title'  => esc_html__( 'Allow sending submission data to example', 'example_code' ),
				'fields' => array(
					array(
						'label'   => esc_html__( 'Enable sending data from this form to example', 'example_code' ),
						'type'    => 'checkbox',
						'name'    => 'sending',
						'tooltip' => esc_html__( 'This will enable the sending of form submission data to example', 'example_code' ),
						'choices' => array(
							array(
								'label' => esc_html__( 'Enabled', 'example_code' ),
								'name'  => 'sending_enabled',
							),
						),
					),
				)
			),
			array(
				'title'  => esc_html__( 'example Field Mapping', 'example_code' ),
				'fields' => array(
					array(
						'label'   => esc_html__( 'Party Type', 'example_code' ),
						'type'    => 'select',
						'name'    => 'type',
						'tooltip' => esc_html__( 'For related Party types, this will set the contact to be of type related party, and this information will be sent to automation for the lifetime of the record.', 'example_code' ),
						'choices' => array(
							array(
								'label' => esc_html__( 'Prospect', 'example_code' ),
								'value' => 'Prospect',
							),
							array(
								'label' => esc_html__( 'Inquiry', 'example_code' ),
								'value' => 'Inquiry',
							),
						),
					),
					array(
						'label'   => esc_html__( 'Referral Source Name', 'example_code' ),
						'type'    => 'text',
						'name'    => 'referralSourceName',
						'tooltip' => esc_html__( 'Max length 20, used to drive Prospect Review workflow', 'example_code' ),
						'class'   => 'medium',
					),
					array(
						'label'   => esc_html__( 'Choose a form field to map to example First Name:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'first_name',
					),
					array(
						'label'   => esc_html__( 'Choose a form field to map to example Last Name:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'last_name',
					),
					array(
						'label'   => esc_html__( 'Choose a form field to map to example Email:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'emails',
					),
					array(
						'label'   => esc_html__( 'Choose a form field to map to example Phone Number:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'phones',
					),
					array(
						'label'   => esc_html__( 'Choose a form field to map to example Notes:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'notes',
					),

				)
			),
			array(
				'title'  => esc_html__( 'example Custom Field Mapping', 'example_code' ),
				'fields' => array(

					// Custom Fields
					array(
						'label'   => esc_html__( 'Additional Fields 1 - Set a Name/Label for this field:', 'example_code' ),
						'type'    => 'text',
						'name'    => 'custom_1_label',
						'tooltip' => esc_html__( 'Send additional form field data to example', 'example_code' ),
						'class'   => 'medium',
					),
					array(
						'label'   => esc_html__( 'Additional Fields 1 - Choose a form field to map to example Additional Field:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'custom_1_data',
					),

					array(
						'label'   => esc_html__( 'Additional Fields 2 - Set a Name/Label for this field:', 'example_code' ),
						'type'    => 'text',
						'name'    => 'custom_2_label',
						'tooltip' => esc_html__( 'Send additional form field data to example', 'example_code' ),
						'class'   => 'medium',
					),
					array(
						'label'   => esc_html__( 'Additional Fields 2 - Choose a form field to map to example Additional Field:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'custom_2_data',
					),

					array(
						'label'   => esc_html__( 'Additional Fields 3 - Set a Name/Label for this field:', 'example_code' ),
						'type'    => 'text',
						'name'    => 'custom_3_label',
						'tooltip' => esc_html__( 'Send additional form field data to example', 'example_code' ),
						'class'   => 'medium',
					),
					array(
						'label'   => esc_html__( 'Additional Fields 3 - Choose a form field to map to example Additional Field:', 'example_code' ),
						'type'    => 'field_select',
						'tooltip' => esc_html__( 'Match field name together to form field', 'example_code' ),
						'name'    => 'custom_3_data',
					),

				)
			),
			array(
				'title'  => esc_html__( 'Form Submission Cleanup', 'example_code' ),
				'fields' => array(

					// Cleanup
					array(
						'label'   => esc_html__( 'Enable Form Submission Cleanup', 'example_code' ),
						'type'    => 'checkbox',
						'name'    => 'cleanup',
						'tooltip' => esc_html__( 'This will enable the form submission cleanup', 'example_code' ),
						'choices' => array(
							array(
								'label' => esc_html__( 'Enabled', 'example_code' ),
								'name'  => 'cleanup_enabled',
							),
						),
					),
					array(
						'label'   => esc_html__( 'If Form Submission Cleanup is enabled, delete submissions after x days:', 'example_code' ),
						'type'    => 'text',
						'tooltip' => esc_html__( 'If enabled this will delete submissions that are x days old or older', 'example_code' ),
						'name'    => 'cleanup_after',
						'class'   => 'medium',
					),

				),
			),
		);
	}


	/**
	 * Performing a custom action at the end of the form submission process.
	 *
	 * @param array $entry The entry currently being processed.
	 * @param array $form The form currently being processed.
	 */
	public function after_submission( $entry, $form ) {

		$example_fields = [];
		$example_fields[0] = [
			'type'       => '',
			'referralSourceName' => '',
			'first_name' => '',
			'last_name'  => '',
			'emails'     => [], // sent in array
			'phones'     => [], // sent in array
			'notes'      => '',
		];

		$custom_fields_obj = [];

		if( isset( $form['example_code'] )
			&& isset( $form['example_code']['sending_enabled'] )
			&& '1' == $form['example_code']['sending_enabled'] )
		{

			// for validation
			$has_errors = [];

			// not from the form
			if( isset( $form['example_code']['type'] ) && ! empty( $form['example_code']['type'] ) ) {
				$example_fields[0]['type'] = $form['example_code']['type'];
			}
			if( isset( $form['example_code']['referralSourceName'] ) && ! empty( $form['example_code']['referralSourceName'] ) ) {
				$example_fields[0]['referralSourceName'] = $form['example_code']['referralSourceName'];
			}

			// values from form with validation
			if( isset( $entry[ $form['example_code']['first_name'] ] ) && ! empty( $entry[ $form['example_code']['first_name'] ] ) ) {
				$example_fields[0]['first_name'] = $entry[ $form['example_code']['first_name'] ];
			} else {
				$has_errors[] = 'first_name was empty';
			}
			if( isset( $entry[ $form['example_code']['last_name'] ] ) && ! empty( $entry[ $form['example_code']['last_name'] ] ) ) {
				$example_fields[0]['last_name'] = $entry[ $form['example_code']['last_name'] ];
			} else {
				$has_errors[] = 'last_name was empty';
			}

			// values from form without validation
			if( isset( $entry[ $form['example_code']['emails'] ] ) && ! empty( $entry[ $form['example_code']['emails'] ] ) ) {
				$example_fields[0]['emails'][] = $entry[ $form['example_code']['emails'] ];
			}
			if( isset( $entry[ $form['example_code']['phones'] ] ) && ! empty( $entry[ $form['example_code']['phones'] ] ) ) {
				$example_fields[0]['phones'][] = $entry[ $form['example_code']['phones'] ];
			}
			if( isset( $entry[ $form['example_code']['notes'] ] ) && ! empty( $entry[ $form['example_code']['notes'] ] ) ) {
				$example_fields[0]['notes'] = $entry[ $form['example_code']['notes'] ];
			}

			// custom field 1
			if( isset( $form['example_code']['custom_1_data'] ) && ! empty( $form['example_code']['custom_1_data'] ) ) {
				$custom_1_label = 'custom_1';
				if( isset( $form['example_code']['custom_1_label'] ) && ! empty( $form['example_code']['custom_1_label'] ) ) {
					$custom_1_label = $form['example_code']['custom_1_label'];
				}
				$custom_fields_obj[$custom_1_label] = $entry[ $form['example_code']['custom_1_data'] ];
			}

			// custom field 2
			if( isset( $form['example_code']['custom_2_data'] ) && ! empty( $form['example_code']['custom_2_data'] ) ) {
				$custom_2_label = 'custom_2';
				if( isset( $form['example_code']['custom_2_label'] ) && ! empty( $form['example_code']['custom_2_label'] ) ) {
					$custom_2_label = $form['example_code']['custom_2_label'];
				}
				$custom_fields_obj[$custom_2_label] = $entry[ $form['example_code']['custom_2_data'] ];
			}

			// custom field 3
			if( isset( $form['example_code']['custom_3_data'] ) && ! empty( $form['example_code']['custom_3_data'] ) ) {
				$custom_3_label = 'custom_3';
				if( isset( $form['example_code']['custom_3_label'] ) && ! empty( $form['example_code']['custom_3_label'] ) ) {
					$custom_3_label = $form['example_code']['custom_3_label'];
				}
				$custom_fields_obj[$custom_3_label] = $entry[ $form['example_code']['custom_3_data'] ];
			}

			// add custom field data if any exists
			if( ! empty( $custom_fields_obj ) ) {
				//$example_fields[0]['custom_fields_obj'] = json_encode( $custom_fields_obj );
				$example_fields[0]['custom_fields_obj'] = $custom_fields_obj;

			}

			// plugin global settings variables
			$apikey       = $this->get_plugin_setting('example_apikey');
			$subdomain    = $this->get_plugin_setting('example_subdomain');
			$company_id   = $this->get_plugin_setting('example_company_id');
			$community_id = $this->get_plugin_setting('example_community_id');


			$example_fields[0]['referral_source_id'] = $this->get_plugin_setting('example_referral_id');


			//testing
			//$example_fields[0]['notes'] = 'Testing NOTES field';

			// validate
			if( empty( $apikey ) ) {
				$has_errors[] = 'apikey was empty';
			}
			if( empty( $subdomain ) ) {
				$has_errors[] = 'subdomain was empty';
			}
			if( empty( $company_id ) ) {
				$has_errors[] = 'company_id was empty';
			}
			if( empty( $community_id ) ) {
				$has_errors[] = 'community_id was empty';
			}

			// if no errors
			if( empty( $has_errors ) ) {
				// prepare
				$example_url = "https://{$subdomain}.example.com/api/{$company_id}/{$community_id}/data/leadReferral/new_contact?api_key={$apikey}";

				$example_body = json_encode( $example_fields );

				// send
				$example_request = new WP_Http();
				$example_response = $example_request->post( $example_url, array( 'body' => $example_body, 'content-type' => 'application/x-www-form-urlencoded' ) );

				// check for response errors and send to error log
				if( ! $example_response || \is_wp_error( $example_response ) ) {
					error_log( 'Error 2: ' . print_r( $example_response, true ) );
				}
				if( isset( $example_response['http_response'] ) && $example_response['http_response']->get_status() > 299 ) {
					error_log( 'Error 3: ' . print_r( $example_response, true ) );
				}

				// do the form submission purging
				if( isset( $form['example_code']['cleanup_enabled'] ) && '1' == $form['example_code']['cleanup_enabled'] ) {
					if( isset( $form['example_code']['cleanup_after'] ) && is_numeric( $form['example_code']['cleanup_after'] ) ) {
						$cleanup_after = trim( $form['example_code']['cleanup_after'] );
						$this->doCleanup( $form['id'], $cleanup_after );
					}
				}

			} else {
				// some value was probably missing and couldnt proceed

			}
		}
	}

	/**
	 * Deletes old form submissions
	 */
	public function doCleanup( $form_id, $cleanup_after ) {
		$cleanup_after = '-' . $cleanup_after . ' days';
		$search_criteria = [];
		$search_criteria['start_date'] = '2000-01-01 00:00:00';
		$search_criteria['end_date'] = date( 'Y-m-d H:m:s', strtotime( $cleanup_after ) );

		$results = GFAPI::get_entry_ids( $form_id, $search_criteria );

		foreach( $results as $result ) {
			GFAPI::delete_entry( $result );
		}
	}
}