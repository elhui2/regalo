<?php

class Deux_WooCommerce_VariationsLoopProduct {
	
	private static $_instance;

	public static function init() {
		if( is_null( self::$_instance ) ){
			self::$_instance = new self();
		}

		return self::$_instance;
	}
	
	public function __construct() {}

	/**
	 * Display product attribute
	 *
	 * @since 1.0
	 */
	public function Attribute() {

		$default_attribute = 'pa_' . sanitize_title( deux_get_option( 'product_attribute' ) );

		if ( $default_attribute == '' || $default_attribute == 'none' ) {
			return;
		}

		global $product;
		$attributes         = maybe_unserialize( get_post_meta( $product->get_id(), '_product_attributes', true ) );
		$product_attributes = maybe_unserialize( get_post_meta( $product->get_id(), 'attributes_extra', true ) );

		if ( $product_attributes == 'none' ) {
			return;
		}

		if ( $product_attributes == '' ) {
			$product_attributes = $default_attribute;
		}

		$variations = $this->getDataVariations( $product_attributes );

		if ( ! $attributes ) {
			return;
		}

		foreach ( $attributes as $attribute ) {


			if ( $product->get_type() == 'variable' ) {
				if ( ! $attribute['is_variation'] ) {
					continue;
				}
			}

			if ( sanitize_title( $attribute['name'] ) == $product_attributes ) {

				echo '<div class="variations-attr">';
				if ( $attribute['is_taxonomy'] ) {
					$post_terms = wp_get_post_terms( $product->get_id(), $attribute['name'] );

					$attr_type = '';

					if ( function_exists( 'TA_WCVS' ) ) {
						$attr = TA_WCVS()->get_tax_attribute( $attribute['name'] );
						if ( $attr ) {
							$attr_type = $attr->attribute_type;
						}
					}
					$found = false;
					foreach ( $post_terms as $term ) {
						$css_class = '';
						if ( is_wp_error( $term ) ) {
							continue;
						}
						if ( $variations && isset( $variations[$term->slug] ) ) {
							$attachment_id = $variations[$term->slug];
							$attachment    = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );
							//$image_srcset  = '';
							//if ( ! intval( deux_get_option( 'lazyload' ) ) ) {
								$image_srcset = wp_get_attachment_image_srcset( $attachment_id, 'shop_catalog' );
							//}

							if ( $attachment_id == get_post_thumbnail_id() && ! $found ) {
								$css_class .= ' selected';
								$found = true;
							}

							if ( $attachment ) {
								$css_class .= ' swatch-variation-image';
								$img_src = $attachment[0];
								echo $this->swatch_html( $term, $attr_type, $img_src, $css_class, $image_srcset );
							}

						}
					}
				}
				echo '</div>';
				break;
			}
		}

	}

	/**
	 * Print HTML of a single swatch
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function swatch_html( $term, $attr_type, $img_src, $css_class, $image_srcset ) {

		$html = '';
		$name = $term->name;

		switch ( $attr_type ) {
			case 'color':
				$color = get_term_meta( $term->term_id, 'color', true );
				list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
				$html = sprintf(
					'<span class="swatch swatch-color %s" data-src="%s" data-src-set="%s" title="%s"><span class="sub-swatch" style="background-color:%s;color:%s;"></span> </span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $image_srcset ),
					esc_attr( $name ),
					esc_attr( $color ),
					"rgba($r,$g,$b,0.5)"
				);
				break;

			case 'image':
				$image = get_term_meta( $term->term_id, 'image', true );
				if ( $image ) {
					$image = wp_get_attachment_image_src( $image );
					$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
					$html  = sprintf(
						'<span class="swatch swatch-image %s" data-src="%s" data-src-set="%s" title="%s"><img src="%s" alt="%s"></span>',
						esc_attr( $css_class ),
						esc_url( $img_src ),
						esc_attr( $image_srcset ),
						esc_attr( $name ),
						esc_url( $image ),
						esc_attr( $name )
					);
				}

				break;

			default:
				$label = get_term_meta( $term->term_id, 'label', true );
				$label = $label ? $label : $name;
				$html  = sprintf(
					'<span class="swatch swatch-label %s" data-src="%s" data-src-set="%s" title="%s">%s</span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $image_srcset ),
					esc_attr( $name ),
					esc_html( $label )
				);
				break;


		}

		return $html;
	}

	/**
	 * Get variations
	 *
	 * @since  1.0.0
	 * @return string
	 */
	function getDataVariations( $default_attribute ) {
		global $product;

		$variations = array();
		if ( $product->get_type() == 'variable' ) {
			$args = array(
				'post_parent' => $product->get_id(),
				'post_type'   => 'product_variation',
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'fields'      => 'ids',
				'post_status' => 'publish',
				'numberposts' => - 1
			);

			if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$args['meta_query'][] = array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '=',
				);
			}

			$thumbnail_id = get_post_thumbnail_id();

			$posts = get_posts( $args );

			foreach ( $posts as $post_id ) {
				$attachment_id = get_post_thumbnail_id( $post_id );
				$attribute     = $this->setDataVariation( $post_id, 'attribute_' . $default_attribute );

				if ( ! $attachment_id ) {
					$attachment_id = $thumbnail_id;
				}

				if ( $attribute ) {
					$variations[$attribute[0]] = $attachment_id;
				}

			}

		}

		return $variations;
	}

	/**
	 * Get variation attribute
	 *
	 * @since  1.0.0
	 * @return string
	 */
	private function setDataVariation( $child_id, $attribute ) {
		global $wpdb;

		$values = array_unique(
			$wpdb->get_col(
				$wpdb->prepare(
					"SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND post_id IN (" . $child_id . ")",
					$attribute
				)
			)
		);

		return $values;
	}
}