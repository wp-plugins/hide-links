<?php
class AHidelinks {

	private static $initiated = false;
		
	public static function init() {
		
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
		
	}

	public static function init_hooks() {
		self::$initiated = true;
		
		add_shortcode( 'link', array( 'AHidelinks', 'hidelinks_shortcode_link') );
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'comment_text', 'do_shortcode' );
		
		add_filter( 'get_comment_author_link', array( 'AHidelinks', 'hidelinks_comment_author_link') );
		add_filter( 'get_comment_author_url_link', array( 'AHidelinks', 'hidelinks_comment_author_link') );
		
		add_action( 'wp_footer', array( 'AHidelinks', 'hidelinks_inlinescript') );
		
		wp_enqueue_script( 'jquery' );
	}
	
	
	/**
	 * Replace default link to tag <span> with special class 'link'
	 *
	 * @param string $link The HTML link to replacement
	 *
	 * @return string The HTML tag <span> with URL in data-link attribute and special class 'link'
	 */
	public static function linkreplace( $link ){
				
		//preg_match("/<([^>]+)*class=([\'|\"])+([^>|\'|\"].+)*/i", $link, $matches);
		//preg_match("/<([^>]+)*class=([\'|\"])+([^>\'\"]+)*(.*)>/i", $link, $matches);
		preg_match("/<a[^>]+class=([\'|\"])+/i", $link, $matches);
			
		$s = ($matches) 
			? array('<a', 'class='.$matches[1], 'href=', '/a>') // with class attr
			: array('<a', 'href=', '/a>'); // without class attr
		
		$r = ($matches) 
			? array('<span', 'class='.$matches[1].'link ', 'data-link=', '/span>')	// with class attr
			: array('<span class="link"', 'data-link=', '/span>');  // without class attr

		return str_replace( $s, $r, $link );

	}
	
	
	/**
	 * Replace link in [link] shorcode
	 *
	 * @param string $attr 	  Optional. Shortcode attributes not uses.
	 * @param string $content HTML link for replace (text in shorcode).
	 *                        Default null.
	 */
	public static function hidelinks_shortcode_link( $atts , $content = null ) {
		
		$new = self::linkreplace( $content );
		
		$s = array( 'rel=', 'target=' );
		$r = array( 'data-rel=', 'data-target=' );
		
		return str_replace( $s, $r, $new );
		
	}
	
	
	
	/**
	 * Replace link in comment author links
	 *
	 * @param string $link  HTML link in comments loop.
	 *                      
	 */
	public static function hidelinks_comment_author_link( $link ){
		
		$new = self::linkreplace( $link );		
		
		return str_replace( 'rel=', 'data-rel=', $new );
		
    }
	
	
	
	/**
	 * Echo`s inline replacement script
	 *
	 */
	public static function hidelinks_inlinescript(){
		echo <<<EOT

<script>
/*<![CDATA[*/
jQuery(document).ready(function($){
    $('.link').replaceWith(function(){
        var id = ( null != $(this).attr('id') ) ? ' id="' + $(this).attr('id') + '"' : '',
            target = ( null != $(this).attr('data-target') ) ? ' target="' + $(this).attr('data-target') + '"' : ' target="_blank"',
            title = ( null != $(this).attr('title') ) ? ' title="' + $(this).attr('title') + '"' : '',         
            style = ( null != $(this).attr('style') ) ? ' style="' + $(this).attr('style') + '"' : '',         
            rel = ( null != $(this).attr('data-rel') ) ? ' rel="' + $(this).attr('data-rel') + '"' : '',
            cl = ( null != $(this).attr('class') ) ? $(this).attr('class').replace('link','').trim() : '';
		cl = ( '' != cl ) ? ' class="' + cl + '"' : '';
		return '<a href="' + $(this).attr('data-link') + '" ' + title + id + cl + target + style + rel + ' >' + $(this).html() + '</a>';
    });
});
/*]]>*/
</script>

EOT;
	}
	
	
}

