<?php

class Deux_Widgets_SocialLinks extends WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $default;

	/**
	 * List of supported socials
	 *
	 * @var array
	 */
	protected $socials;

	/**
	 * Constructor
	 */
	function __construct() {
		$socials = array(
			'facebook'    => esc_html__( 'Facebook', 'deux' ),
			'twitter'     => esc_html__( 'Twitter', 'deux' ),
			'google' 	  => esc_html__( 'Google Plus', 'deux' ),
			'tumblr'      => esc_html__( 'Tumblr', 'deux' ),
			'linkedin'    => esc_html__( 'Linkedin', 'deux' ),
			'pinterest'   => esc_html__( 'Pinterest', 'deux' ),
			'flickr'      => esc_html__( 'Flickr', 'deux' ),
			'instagram'   => esc_html__( 'Instagram', 'deux' ),
			'dribbble'    => esc_html__( 'Dribbble', 'deux' ),
			'stumbleupon' => esc_html__( 'StumbleUpon', 'deux' ),
			'github'      => esc_html__( 'Github', 'deux' ),
			'rss'         => esc_html__( 'RSS', 'deux' ),
		);

		$this->socials = apply_filters( 'deux_social_media', $socials );
		$this->default = array(
			'title' => '',
		);
		foreach ( $this->socials as $k => $v ) {
			$this->default["{$k}_title"] = $v;
			$this->default["{$k}_url"]   = '';
		}

		parent::__construct(
			'social-links-widget',
			esc_html__( 'Deux - Social Links', 'deux' ),
			array(
				'classname'   => 'social-links-widget social-links',
				'description' => esc_html__( 'Display links to social media networks.', 'deux' ),
				'customize_selective_refresh' => true,
			),
			array( 'width' => 600 )
		);
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 *
	 * @return void Echoes it's output
	 */
	function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->default );

		echo $args['before_widget'];

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<ul class="share-container">';
		foreach ( $this->socials as $social => $label ) {
			if ( ! empty( $instance[$social . '_url'] ) ) {
				printf(
					'<li>
						<a href="%s" class="center social-icon si-light  si-rounded si-%s" rel="nofollow" title="%s">
							<i class="fa fa-%s"></i>
							<i class="fa fa-%s"></i>
						</a>
					</li>',
					esc_url( $instance[$social . '_url'] ),
					esc_attr( $social ),
					esc_attr( $instance[$social . '_title'] ),
					esc_attr( $social ),
					esc_attr( $social )
				);
			}
		}
		echo '</ul>';

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ){
		$new_instance['title'] = strip_tags( $new_instance['title'] );

		foreach ( $this->socials as $social ) {
			$new_instance[ $social . '_url'] = esc_url( $new_instance[ $social . '_url'] );
		}

		return $new_instance;
	} 

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->default );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'deux' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<?php
		foreach ( $this->socials as $social => $label ) {
			printf(
				'<div style="width: 280px; float: left; margin-right: 10px;">
					<label>%s</label>
					<p><input type="text" class="widefat" name="%s" placeholder="%s" value="%s"></p>
				</div>',
				esc_html( $label ),
				esc_attr( $this->get_field_name( $social . '_url' ) ),
				esc_attr__( 'URL', 'deux' ),
				esc_url( $instance[$social . '_url'] )
			);
		}
	}
}
