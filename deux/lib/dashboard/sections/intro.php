<?php $theme = wp_get_theme(); ?>
<div class="col two-col" style="margin-bottom: 1.618em; overflow: hidden;">
	<div class="col">
		<h1 style="margin-right: 0;"><?php echo '<strong>' . esc_html( $theme->name ) . '</strong> <sup style="font-weight: bold; font-size: 50%; padding: 5px 10px; border-radius:4px; color: #666; background: #fff;">' . esc_html( $theme->version ) . '</sup>'; ?></h1>

		<p style="font-size: 1.2em;"><?php printf( esc_html__( 'Excellent! You\'ve activated %s, we hope you enjoy this premium ecommerce theme.', 'deux' ), '<strong>'. esc_html( $theme->name ) .'</strong>' ); ?></p>


		<p><?php printf( __( 'This page will help you get up and running quickly with <strong>%1$s</strong>. Please read the <a href="%3$s">Documentation</a> or drop an email to <strong>qedqod.cs@gmail.com</strong> if you have an issues with this theme.', 'deux' ), esc_html( $theme->name ), esc_url( 'http://qedqod.com/support/theme/deux' ), esc_url( 'http://docs.qedqod.com/deux' ) ) ?></p>

		<p><?php printf( __( 'Please check our <a href="%1$s">change log</a> to make sure you are using the latest version of this theme.', 'deux' ), esc_url( 'http://qedqod.com/support/theme/deux' )) ?></p>

		<?php $tf_link = 'https://themeforest.net/downloads'; ?>

		<hr>

		<p><?php echo sprintf( esc_html__( 'Why not show your love to %1$s by leaving a 5 stars rating on %2$sthemeforest.net%3$s? We\'d really appreciate it!.', 'deux' ), esc_html( $theme->name ), '<a href="'.esc_url( $tf_link ).'" target="_blank">', '</a>' ); ?></p>
	</div>

	<div class="col">
		<img src="<?php echo esc_url( $theme->get_screenshot() ); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'deux' ); ?>">
	</div>
</div>