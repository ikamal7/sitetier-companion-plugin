<?php 

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
class Slider_Widget extends \Elementor\Widget_Base {
    

    
    public function get_name() {
        return 'custom_slider';
    }

    public function get_title() {
        return __('Custom Slider', 'stel');
    }

    public function get_icon() {
        return 'eicon-slider-push st_icon';
    }

    public function get_categories() {
        return ['general'];
    }
    public function get_style_depends() {
     return [ 'owl-carousel', 'stel-style' ];
  }
  public function get_script_depends() {
     return [ 'owl-carousel', 'stel-script' ];
  }

    protected function _register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slider_title', [
				'label' => __( 'Title', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Slider Title' , 'plugin-domain' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_content', [
				'label' => __( 'Content', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Slider Content' , 'plugin-domain' ),
				'show_label' => false,
			]
		);
        $repeater->add_control(
			'sl_bg',
			[
				'label' => __( 'Slider Background Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => WPSC_ASSETS . '/images/sitetie_wp_hero.png',
				],
			]
		);
        $repeater->add_control(
			'image',
			[
				'label' => __( 'Slider Image', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => WPSC_ASSETS . '/images/left-slider.png',
				],
			]
        );
        $repeater->add_control(
			'button_title',
			[
				'label' => __( 'Button Title', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Get started', 'plugin-domain' ),
				'placeholder' => __( 'Type your title here', 'plugin-domain' ),
			]
        );
        $repeater->add_control(
			'button_link',
			[
				'label' => __( 'Link', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'plugin-domain' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'slider',
			[
				'label' => __( 'Slider Items', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'slider_title' => __( 'Title #1', 'plugin-domain' ),
						'slider_content' => __( 'Item content. Click the edit button to change this text.', 'plugin-domain' ),
					],
					[
						'slider_title' => __( 'Title #2', 'plugin-domain' ),
						'slider_content' => __( 'Item content. Click the edit button to change this text.', 'plugin-domain' ),
					],
				],
				'title_field' => '{{{ slider_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_style_sec',
			[
				'label' => __( 'Title', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .slider-left h2' => 'color: {{VALUE}}',
				],
				'default' => '#FFFFFF'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'plugin-domain' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .slider-left h2',
			]
		);

		$this->end_controls_section();

		// Content Style section
		$this->start_controls_section(
			'slider_cont_style_sec',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .slider-content' => 'color: {{VALUE}}',
				],
				'default' => '#FFFFFF'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'plugin-domain' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .slider-content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_settings',
			[
				'label' => __( 'Settings', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'nav',
			[
				'label' => __( 'Nav', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		$this->add_control(
			'dots',
			[
				'label' => __( 'Dots', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'center',
			[
				'label' => __( 'Center', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);
		$this->add_control(
			'autoplaytimeout',
			[
				'label' => __( 'Autoplay Timout', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 10000,
				'step' => 1000,
				'default' => 0,
			]
		);
		$this->add_control(
			'items',
			[
				'label' => __( 'Slide Items', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 1,
			]
		);
		$this->add_control(
			'items_mobile',
			[
				'label' => __( 'Slide Items Mobile', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 99,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $sliders = $settings['slider'];
        ?>

			<div id="custom_slider" class="owl-carousel owl-theme" 
			data-items="[<?php echo esc_attr( $settings['items'] ); ?>,<?php echo esc_attr( $settings['items_mobile'] ); ?>]" 
			data-margin="0" 
			data-autoplay="<?php echo esc_attr($settings['autoplay']); ?>" 
			data-center="<?php echo esc_attr( $settings['center'] ); ?>" 
			data-loop="<?php echo esc_attr( $settings['loop'] ); ?>" 
			data-nav="<?php echo esc_attr( $settings['nav'] ); ?>" 
			data-dots="<?php echo esc_attr( $settings['dots'] ); ?>"
			data-autoplaytimeout="<?php echo esc_attr( $settings['autoplaytimeout'] ); ?>"
			>
                <?php foreach($sliders as $slider) : ?>
                <div class="single-slider" style="background-image: url(<?php echo $slider['sl_bg']['url']; ?>);">
                    <div class="slider-container">
						<div class="slider-left">
							<h2><?php echo $slider['slider_title']; ?></h2>
							<div class="slider-content">
								<?php echo $slider['slider_content']; ?>
							</div>
							<a href="<?php echo $slider['button_link']['url']; ?>" class="slider-btn btn st-btn-2"><?php echo $slider['button_title']; ?></a>
						</div>
						<div class="slider-right">
							<img src="<?php echo $slider['image']['url']; ?>" title="<?php echo $slider['slider_title']; ?>">
						</div>
					</div>
                </div>
            <?php endforeach; ?>
            </div>

        <?php
       
    }

    protected function _content_template() {}

}