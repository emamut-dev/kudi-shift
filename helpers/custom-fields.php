<?php
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_699ddb6bb0d78',
	'title' => 'Jornada',
	'fields' => array(
		array(
			'key' => 'field_699ddb6b8b816',
			'label' => 'Monitor/a',
			'name' => 'monitora',
			'aria-label' => '',
			'type' => 'user',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'role' => array(
				0 => 'contributor',
			),
			'return_format' => 'object',
			'multiple' => 0,
			'allow_null' => 0,
			'allow_in_bindings' => 0,
			'bidirectional' => 0,
			'bidirectional_target' => array(
			),
		),
		array(
			'key' => 'field_69d7d4cf507ac',
			'label' => 'Modelos',
			'name' => 'modelos',
			'aria-label' => '',
			'type' => 'user',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'role' => array(
				0 => 'subscriber',
			),
			'return_format' => 'object',
			'multiple' => 1,
			'allow_null' => 0,
			'allow_in_bindings' => 0,
			'bidirectional' => 0,
			'bidirectional_target' => array(
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'journals',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 1,
	'display_title' => '',
	'allow_ai_access' => false,
	'ai_description' => '',
) );

acf_add_local_field_group( array(
	'key' => 'group_6a60d895186cc',
	'title' => 'Sitios',
	'fields' => array(
		array(
			'key' => 'field_6a60d895e058f',
			'label' => '¿En dólares?',
			'name' => 'dollars',
			'aria-label' => '',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Si',
				'no' => 'No',
			),
			'default_value' => 'no',
			'return_format' => 'value',
			'allow_null' => 0,
			'other_choice' => 0,
			'allow_in_bindings' => 0,
			'layout' => 'vertical',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_6a60d97cc8120',
			'label' => 'Valor del Token',
			'name' => 'token_value',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_6a60d895e058f',
						'operator' => '==',
						'value' => 'no',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '0,05',
			'min' => '',
			'max' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'step' => '',
			'prepend' => '$',
			'append' => 'USD',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'sites',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'display_title' => '',
	'allow_ai_access' => false,
	'ai_description' => '',
) );
} );

