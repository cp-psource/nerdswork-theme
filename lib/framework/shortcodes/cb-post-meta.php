<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Post Shortcode helper class. 
 * 
 * It generates shortcodes to assist playing with various post features like post-thumbnail, author-name, author-posts-link etc
 * 
 * Also, we use it in the theme options to show post meta(single post header/footer)
 */
class CB_Post_Shortcodes_Helper {

	private static $instance;

	private function __construct() {
		$this->register_shortcodes();
	}

	/**
	 * Register  shortcodes
	 * 
	 */
	private function register_shortcodes() {
		//author name
		//author-link
		//author-avatar
		//author-total-posts
		//author-comments
		//post-date
		//post-modified-date
		//post time
		//post modified time
		//post-thumbnail
		//attachment
		//post-categories
		//post-tags
		//post-excerpt
		//post-meta 
		//author

		//todo
		//[author-profile]
		//[category text]
		//[tags text]
		//[terms text]

		add_shortcode( 'author-name', array( $this, 'get_author_name' ) );
		add_shortcode( 'author-posts-link', array( $this, 'get_author_posts_link' ) );
		add_shortcode( 'author-avatar', array( $this, 'get_author_avatar' ) );
		add_shortcode( 'author-total-posts', array( $this, 'get_author_total_posts' ) );
		//comment link
		add_shortcode( 'post-comment-link', array( $this, 'get_comment_link' ) );

		//Date 
		add_shortcode( 'post-date', array( $this, 'get_post_date' ) );
		add_shortcode( 'post-modified-date', array( $this, 'get_post_modified_date' ) );
		
		//post title
		add_shortcode( 'post-title', array( $this, 'get_post_title' ) );

		//Time
		add_shortcode( 'post-time', array( $this, 'get_post_time' ) );
		add_shortcode( 'post-modified-time', array( $this, 'get_post_modified_time' ) );

		//Category & Tags
		add_shortcode( 'post-categories', array( $this, 'get_post_categories' ) );
		add_shortcode( 'post-tags', array( $this, 'get_post_tags' ) );

		//post-thumbnail
		add_shortcode( 'post-thumbnail', array( $this, 'get_post_thumbnail' ) );

		//post meta
		add_shortcode( 'post-meta', array( $this, 'get_post_meta' ) );
	}

	/**
	 * Get Instance
	 * 
	 * Use singleton pattern
	 * @return string
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}

	/**
	 * Author Display Name
	 * Usage: [author-name], [author-name class=SomeClass]
	 */
	public function get_author_name( $atts, $content = '' ) {

		extract( shortcode_atts( array(
				'class' => 'post-author-name'
				),
				$atts 
		) );

		return '<span class="' . esc_attr( $class ) . '">' . get_the_author() . '</span>';
	}

	/**
	 * Author post link
	 * Links to the author archive page for the current author
	 * 
	 * [author-posts-link], [author-posts-link class=SomeClass]
	 * 
	 * @param type $atts
	 * @return type
	 */
	public function get_author_posts_link( $atts, $content = '' ) {

		extract( shortcode_atts( array(
				'class' => 'post-author-link'
				),
				$atts 
		) );
		
		global $authordata;

		if ( ! is_object( $authordata ) ) {
			return '';
		}

		return '<span  class="' . esc_attr( $class ) . '">' . '<a href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '">' . get_the_author() . '</a>' . '</span>';
	}

	/**
	 * Get Author Avatar
	 * 
	 * [author-avatar], [author-avatar link=0 class=MyClass size=64]
	 * 
	 * @global type $current_user
	 * @return strin
	 */
	public function get_author_avatar( $atts, $content = '' ) {

		global $authordata;

		if ( ! is_object( $authordata ) ) {
			return '';
		}

		extract( shortcode_atts( array(
				'class' => 'post-author-avatar',
				'size'	=> 32,
				'link'	=> 1
				), 
				$atts 
		) );
		
		$html = '<span class="' . esc_attr( $class ) . '">';

		if ( ! empty( $link ) ) {
			$html .= '<a href="' . get_author_posts_url( $authordata->ID, $authordata->user_nicename ) . '">';
		}
		
		$html .= get_avatar( $authordata->ID, $size );

		if ( ! empty( $link ) ) {
			$html .='</a>';
		}

		$html .='</span>';

		return $html;
	}

	/**
	 * Get the count of total no. of posts written by current aauthor
	 * 
	 * [author-total-posts], [author-total-posts class=ClassName]
	 * 
	 * @param mixed $atts
	 * @param string $content
	 * @return mixed
	 */
	function get_author_total_posts( $atts, $content = '' ) {

		extract( shortcode_atts( 
				array(
					'class' => 'post-author-total-posts-count'
				),
				$atts 
		) );

		return '<span class="' . esc_attr( $class ) . '">' . get_the_author_posts() . '</span>';
	}

	/**
	 * Get Post Date
	 * 
	 * [post-date],[post-date format=""]
	 * 
	 * @param type $atts
	 * @return type
	 */
	public function get_post_date( $atts, $content = '' ) {

		extract( shortcode_atts( 
				array(
					'format' => '',
					'class' => 'post-date',
				),
				$atts 
		) );

		return '<span  class="' . esc_attr( $class ) . '">' . get_the_date( $format ) . '</span>';
	}

	/**
	 * Get last modified date of the post
	 * 
	 * [post-modified-date],[post-modified-date format=""]
	 * @param type $atts
	 * @return type
	 */
	public function get_post_modified_date( $atts ) {

		extract( shortcode_atts( 
				array(
					'format'	=> '',
					'class'		=> 'post-modified-date',
				), 
				$atts 
		) );

		return '<span  class="' . esc_attr( $class ) . '">' . get_the_modified_date( $format ) . '</span';
	}

	/**
	 * get time
	 * 
	 * [post-time],[post-time format=""]
	 * 
	 * @param type $atts
	 * @return type
	 */
	public function get_post_time( $atts ) {

		extract( shortcode_atts( 
				array(
					'format'	=> '',
					'class'		=> 'post-time',
				), 
				$atts
		) );

		return '<span class="' . esc_attr( $class ) . '">' . get_the_time( $format ) . '</span>';
	}

	/**
	 * Get last modified time
	 * 
	 * [post-modified-time],[post-modified-time format=""]
	 * 
	 * @param type $atts
	 * @return type
	 */
	public function get_post_modified_time( $atts ) {

		extract( shortcode_atts( 
				array(
					'format'	=> '',
					'class'		=> 'post-modified-time',
				), 
				$atts
		) );

		return '<span  class="' . esc_attr( $class ) . '">' . get_the_modified_time( $format ) . '</span>';
	}

	public function get_post_title( $atts, $content = '' ) {

		extract( shortcode_atts( 
				array(
					'before_title' => '<h1 class="post-title">',
					'after_title' => '</h1>',
				), 
				$atts
		) );

		if ( ! is_single( get_the_ID() ) ) {
			$title = "<a href='" . get_permalink() . "' title='" . the_title_attribute( array( 'echo' => false ) ) . "'>" . get_the_title() . "</a>";
		} else {
			$title = get_the_title();
		}
		
		return $before_title . $title . $after_title;
	}

	/**
	 * List Categories
	 * 
	 * [post-categories]
	 * 
	 * @param type $atts
	 * @param type $content
	 * @return type
	 */
	public function get_post_categories( $atts, $content = null ) {

		extract( shortcode_atts( 
				array(
					'class'		=> 'post-categories',
					'separator' => ', ',
				), 
				$atts 
		) );

		return '<span  class="' . esc_attr( $class ) . '">' . get_the_category_list( $separator ) . '</span>';
	}

	/**
	 * Tags
	 * 
	 * [post-tags]
	 * 
	 * @param mixed $atts
	 * @param string $content
	 * @return type string
	 */
	public function get_post_tags( $atts, $content = null ) {
		
		extract( shortcode_atts( 
				array(
					'class'		=> 'post-tag-cloud',
					'separator' => '',
					'before'	=> '',
					'after'		=> ''
				), 
				$atts 
		) );

		return '<span  class="' . esc_attr( $class ) . '">' . get_the_tag_list( $before, $separator, $after ) . '</span>';
	}

	public function get_post_thumbnail( $atts, $content = '' ) {

		$atts = shortcode_atts( array(
			'size' => '',
		), $atts );
		return '<div class="post-thumbnail">' . get_the_post_thumbnail( get_the_ID(), $atts['size'] ) . '</div>';
	}

	/**
	 * [post-meta key="some_key"], [post-meta key="some-key" label="Some label" single="0|1" separator ="," class="someclass"  ...]
	 *
	 * @param mixed $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function get_post_meta( $atts, $content = '' ) {

		extract( shortcode_atts( 
				array(
					'key'			=> '',
					'label'			=> '',
					'single'		=> 1,
					'separator'		=> ',', //in case of multiple value
					'class'			=> 'post-meta-item',
					'key_class'		=> '',
					'value_class'	=> '',
					'key_tag'		=> 'span',
					'value_tag'		=> 'span',
					'tag'			=> 'span'
				), 
				$atts 
		) );

		$value = get_post_meta( get_the_ID(), $key, $single );
		
		if ( is_array( $value ) ) {
			$value = join( $separator, $value );
		}
		
		if ( ! $label ) {
			$label = ucwords( str_replace( '_', " ", $key ) );
		}
		
		$html = "<{$tag} class='" . esc_attr( $class ) . "'><{$key_tag} class='" . esc_attr( $key_class ) . "'>{$label}</$key_tag><{$value_tag} class='" . esc_attr( $value_class ) . "'>{$value}</$value_tag></{$tag}>";

		return $html;
	}

	/**
	 * 
	 * [post-comment-link]
	 * @param mixed $atts
	 * @param string $content
	 * @return string
	 */
	public function get_comment_link( $atts, $content = '' ) {

		$html = '<a href="' . get_comments_link() . '">';
		$html .= cb_get_comment_count();
		$html .= '</a>';

		return $html;
	}
}

CB_Post_Shortcodes_Helper::get_instance();
