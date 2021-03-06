<?php
/**
 * General Settings
 *
 * Register General section, settings and controls for Theme Customizer
 *
 * @package Poseidon
 */


/**
 * Adds all general settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object
 */
function poseidon_customize_register_general_settings( $wp_customize ) {

	// Add Section for Theme Options
	$wp_customize->add_section( 'beetle_section_general', array(
        'title'    => esc_html__( 'General Settings', 'poseidon' ),
        'priority' => 10,
		'panel' => 'poseidon_options_panel' 
		)
	);
	
	// Add Settings and Controls for Layout
	$wp_customize->add_setting( 'poseidon_theme_options[layout]', array(
        'default'           => 'right-sidebar',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_select'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[layout]', array(
        'label'    => esc_html__( 'Theme Layout', 'poseidon' ),
        'section'  => 'beetle_section_general',
        'settings' => 'poseidon_theme_options[layout]',
        'type'     => 'radio',
		'priority' => 1,
        'choices'  => array(
            'left-sidebar' => esc_html__( 'Left Sidebar', 'poseidon' ),
            'right-sidebar' => esc_html__( 'Right Sidebar', 'poseidon' )
			)
		)
	);
	
	// Add Sticky Header Setting
	$wp_customize->add_setting( 'poseidon_theme_options[sticky_header_title]', array(
        'default'           => '',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Poseidon_Customize_Header_Control(
        $wp_customize, 'poseidon_theme_options[sticky_header_title]', array(
            'label' => esc_html__( 'Sticky Header', 'poseidon' ),
            'section' => 'beetle_section_general',
            'settings' => 'poseidon_theme_options[sticky_header_title]',
            'priority' => 2
            )
        )
    );
	$wp_customize->add_setting( 'poseidon_theme_options[sticky_header]', array(
        'default'           => false,
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_checkbox'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[sticky_header]', array(
        'label'    => esc_html__( 'Enable sticky header feature', 'poseidon' ),
        'section'  => 'beetle_section_general',
        'settings' => 'poseidon_theme_options[sticky_header]',
        'type'     => 'checkbox',
		'priority' => 3
		)
	);
	
	
	// Add Post Layout Settings for archive posts
	$wp_customize->add_setting( 'poseidon_theme_options[post_layout_archives]', array(
        'default'           => 'left',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_select'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[post_layout_archives]', array(
        'label'    => esc_html__( 'Post Layout (archive pages)', 'poseidon' ),
        'section'  => 'beetle_section_general',
        'settings' => 'poseidon_theme_options[post_layout_archives]',
        'type'     => 'select',
		'priority' => 4,
        'choices'  => array(
            'left' => esc_html__( 'Show featured image beside content', 'poseidon' ),
            'top' => esc_html__( 'Show featured image above content', 'poseidon' ),
			'none' => esc_html__( 'Hide featured image', 'poseidon' )
			)
		)
	);
	
	// Add Post Layout Settings for single posts
	$wp_customize->add_setting( 'poseidon_theme_options[post_layout_single]', array(
        'default'           => 'header',
		'type'           	=> 'option',
        'transport'         => 'refresh',
        'sanitize_callback' => 'poseidon_sanitize_select'
		)
	);
    $wp_customize->add_control( 'poseidon_theme_options[post_layout_single]', array(
        'label'    => esc_html__( 'Post Layout (single post)', 'poseidon' ),
        'section'  => 'beetle_section_general',
        'settings' => 'poseidon_theme_options[post_layout_single]',
        'type'     => 'select',
		'priority' => 5,
        'choices'  => array(
            'header' => esc_html__( 'Show featured image as header image', 'poseidon' ),
            'top' => esc_html__( 'Show featured image above content', 'poseidon' ),
			'none' => esc_html__( 'Hide featured image', 'poseidon' )
			)
		)
	);

	
}
add_action( 'customize_register', 'poseidon_customize_register_general_settings' );