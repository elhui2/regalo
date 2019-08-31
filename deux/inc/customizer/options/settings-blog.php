<?php
// Blog
$options[] = array( 
		'settings'    => 'divider-blog-header',
		'type'        => 'custom',
		'section'     => 'blog-section',
		'default'     => '<h4 class="customize-subtitle">'. esc_html__('Blog Single', 'deux') .'</h4>',
);
$options['single_post_layout'] = array( 
	'settings' => 'single_post_layout'                 ,
	'type'        => 'toggle',
	'label'       => esc_html__( 'Modern Single Post', 'deux' ),
	'description' => esc_html__( 'Display single post layout modern', 'deux' ),
	'section'     => 'blog-section',
	'default'     => false,
);
$options['post_navigation'] = array( 
	'settings' => 'post_navigation'   ,
	'type'    => 'toggle',
	'label'   => esc_html__( 'Post Navigation', 'deux' ),
	'section' => 'blog-section',
	'default' => true,
);
$options['post_author_box'] = array( 
	'settings' => 'post_author_box'   ,
	'type'    => 'toggle',
	'label'   => esc_html__( 'Author Box', 'deux' ),
	'section' => 'blog-section',
	'default' => true,
);
$options['post_related_posts'] = array( 
	'settings' => 'post_related_posts',
	'type'    => 'toggle',
	'label'   => esc_html__( 'Related Posts', 'deux' ),
	'section' => 'blog-section',
	'default' => true,
);
$options[] = array( 
		'settings'    => 'divider-blog-page',
		'type'        => 'custom',
		'section'     => 'blog-section',
		'default'     => '<h4 class="customize-subtitle">'. esc_html__('Blog Page', 'deux') .'</h4>',
);
$options['blog_layout'] = array( 
	'settings' => 'blog_layout'       ,
	'type'    => 'radio',
	'label'   => esc_html__( 'Blog Layout', 'deux' ),
	'section' => 'blog-section',
	'default' => 'classic',
	'choices' => array(
		'classic' => esc_html__( 'Classic', 'deux' ),
		'grid'    => esc_html__( 'Grid', 'deux' ),
	),
);
$options['excerpt_length'] = array( 
	'settings' => 'excerpt_length'    ,
	'type'    => 'number',
	'label'   => esc_html__( 'Excerpt Length', 'deux' ),
	'section' => 'blog-section',
	'default' => 30,
);