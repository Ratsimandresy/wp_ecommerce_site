<?php

namespace Depicter\Modules;

use Depicter\Modules\Elementor\SliderWidget;
use WPEmerge\ServiceProviders\ServiceProviderInterface;

/**
 * Register widgets.
 */
class ModulesServiceProvider implements ServiceProviderInterface {
	/**
	 * {@inheritDoc}
	 */
	public function register( $container ) {
		// Nothing to register.
	}

	/**
	 * {@inheritDoc}
	 */
	public function bootstrap( $container ) {
		add_action( 'elementor/widgets/widgets_registered', [$this, 'registerElementorWidgets'] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueueEditorScripts'] );
		add_action( 'wp_enqueue_scripts', [ $this, 'load_elementor_widget_script'] );
		
		add_action( 'init', [ $this, 'create_depicter_block_init'] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_gutenberg_widget_scripts'] );
	}

	/**
	 * Register Elementor widgets.
	 *
	 * @return void
	 */
	public function registerElementorWidgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new SliderWidget() );
	}

	/**
	 * load required script for elementor widget in elementor editor env
	 */
	public function load_elementor_widget_script() {
		if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			\Depicter::front()->assets()->enqueueScripts('widget');
		}
	}

	public function enqueueEditorScripts() {
		\Depicter::core()->assets()->enqueueScript(
			'depicter-admin',
			\Depicter::core()->assets()->getUrl() . '/resources/scripts/admin/index.js',
			['jquery'],
			true
		);

		wp_localize_script( 'depicter-admin', 'depicterParams',[
			'editorUrl' => \Depicter::editor()->getEditUrl('1')
		]);
	}

	public function load_gutenberg_widget_scripts() {

		$current_screen = get_current_screen();
		if ( !$current_screen->is_block_editor() ) {
			return;
		}

		$list = \Depicter::app()->documentRepository()->getList(['name','id']);
		if ( !empty( $list ) ) {
			foreach ( $list as $key => $item ) {
				$list[ $key ]['label'] = $item['name'];
				unset( $list[ $key ]['name'] );

				$list[ $key ]['value'] = $item['id'];
				unset( $list[ $key ]['id'] );
			}
		}
		wp_localize_script( 'wp-block-editor', 'depicterSliders',[
			'list' => $list
		]);

	}

	public function create_depicter_block_init() {
		register_block_type( __DIR__ . '/Gutenberg/build', [
			'render_callback' => [ $this, 'renderGutenbergBlock' ]
		] );
	}

	public function renderGutenbergBlock( $blockAttributes ) {

		if ( function_exists( 'get_current_screen' ) ) {
			$current_screen = get_current_screen();
			if ( $current_screen->is_block_editor() ) {
				return;
			}
		}
	
		if ( !empty( $blockAttributes['id'] ) ) {
			$id = (int) $blockAttributes['id'];
			depicter( $id );
		} else {
			echo esc_html__( 'Slider ID required', PLUGIN_DOMAIN );
		}

	}
}
