<?php
/*
Plugin Name: Extended-CR_es
Description: Extensions to ClimaRisk Genesis sites
Version: 1.0
Author: Angel Utset
License: GPLv2
*/

//Registering bootstrap
function cr_registers () {
	
	wp_deregister_script('jquery'); //Deregister custom WordPress Jquery
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'); // Registering Google lib
	wp_enqueue_style('bootstrap-style', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'); // Registering Bootstrap 4
    wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
	wp_enqueue_style( 'cr-css', plugin_dir_url( __FILE__ ).'css/cr.css');
	wp_enqueue_script('cr-js', plugin_dir_url( __FILE__ ).'js/cr.js');
}
add_action('wp_enqueue_scripts', 'cr_registers');

//Remove header
add_action('get_header', 'cr_remove_header');
function cr_remove_header() {
remove_action( 'genesis_header', 'genesis_do_header' ); }

//Custom header
add_action ('genesis_header', 'cr_custom_header');
function cr_custom_header() { ?>
<div class="row pt-1">
<div class="col-7">
<a href="<?php echo site_url() ?>/contacto/" title="Contactar ClimaRisk">
	<img  width="250" class="img-fluid float-left align-middle imgs imheader" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/climarisk-header.gz" 
		alt="ClimaRisk"></a></div>
		<div class="col-5">
		<a href="https://climarisk.com"> <img class="img-fluid float-right mt-2 pt-1 imgs" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/gb.gz" 
		alt="ClimaRisk in English" title="ClimaRisk in English"></a>
		<a href="https://twitter.com/climarisk" target="_blank"> <img class="img-fluid rounded float-right align-top mt-2 mr-4 imgs" style="height:20%;" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/twitter-climarisk.gif" 
		alt="ClimaRisk Twitter" title="ClimaRisk Twitter"></a>
		</div>
</div>
	 <?php
}

function find_browser () {
$info = $_SERVER['HTTP_USER_AGENT'];
 if(strpos($info,"Chrome") == true) {
	$browser = "Chrome";
 }
 	elseif (strpos($info,"Firefox") == true) {
		$browser="Firefox";
	}
		elseif (strpos($info,"IE") == true)
		$browser = "IE"; 
		else
		$browser = "Other";	
return $browser;
}	

//* Customize the Genesis credits
add_filter( 'genesis_footer_creds_text', 'cr_footer_creds_text' );
function cr_footer_creds_text() { ?>
	<div class="float-left">Copyright &copy
	<?php echo date('Y'); ?>
	&middot
	<a href="https://climarisk.com/es" title="ClimaRisk">
	<img  class="img-fluid mr-1 align-top" src="<?php echo plugin_dir_url( __FILE__ ) ?>/images/climarisk.png" 
		alt="ClimaRisk">ClimaRisk
	</a></div>
	
<?php 	
}


/** Load custom favicon to header 

add_filter( 'genesis_pre_load_favicon', 'custom_favicon_filter' );

function custom_favicon_filter( $favicon_url ) {

return get_stylesheet_directory_uri().'/images/mw_favicon.png';

}*/

function cr_login_logo() { // Customize login logo ?> 
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/climarisk-logo.gif);
            padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'cr_login_logo' );

function cr_login_logo_url_title() {
    return 'ClimaRisk - Entrada al Backend del sitio';
}
add_filter( 'login_headertitle', 'cr_login_logo_url_title' );

function cr_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'cr_login_logo_url' );


// HTML5
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'mwe_breadcrumb_args' );
function mwe_breadcrumb_args( $args ) {
	$args['home'] = 'Inicio';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = 'Est&aacute; aqu&iacute;: ';
	$args['labels']['author'] = 'Archivos de ';
	$args['labels']['category'] = ''; // Genesis 1.6 and later
	$args['labels']['tag'] = 'Archivos de  ';
	$args['labels']['date'] = 'Archivos de  ';
	$args['labels']['search'] = 'B&uacute;squeda para ';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = 'No se encuentra: '; // Genesis 1.5 and later
return $args;
}

add_action( 'get_header', 'remove_titles_from_pages' );
function remove_titles_from_pages() {
    if ( is_page(array(Inicio, Contacto) ) ) {
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    }
}

//* Customize the post meta function
add_filter( 'genesis_post_meta', 'cr_post_meta_filter' );
function cr_post_meta_filter($post_meta) {
if ( !is_page() ) {
	$post_meta = '[post_categories before="Archivado en: "] [post_tags before="Etiquetado en: "]';
	return $post_meta;
}}

//* Modify the length of post excerpts
add_filter( 'excerpt_length', 'cr_excerpt_length' );
function cr_excerpt_length( $length ) {
	return 30; // pull first 15 words
}

/*add_filter( 'genesis_post_info', 'cr_post_info_filter' );
function cr_post_info_filter($post_info) {
	$post_info = '[post_categories sep=", " before="Archivado en: "]<span style="float:right;padding-right:1%"><a class="button" href="'.site_url().'" style="padding-left,padding-right:10%;padding-bottom:0%;padding-top:0%">Inicio</a></span>';
	return $post_info;
}

//* Customize the entry meta in the entry footer (requires HTML5 theme support)
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
	$post_meta = '[post_tags sep=", " before="Etiquetas: "]';
	return $post_meta;
}*/

//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'cr_read_more_link' );
function cr_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">[Continuar leyendo...]</a>';
}

// Para usar shortcodes en descripciones de categoria y en widgets
//add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');
add_filter( 'genesis_term_intro_text_output', 'do_shortcode' );


add_action( 'pre_get_posts', 'prefix_reverse_post_order' );
function prefix_reverse_post_order( $query ) {
	// Only change the query for post archives.
	if ( $query->is_main_query() && is_archive() && ! is_post_type_archive() ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'ASC' );
	}
}

// Enable PHP in widgets
add_filter('widget_text','execute_php',100);
function execute_php($html){
     if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'cr_next_page_link' );
function cr_next_page_link ( $text ) {
    return 'Siguiente &#x000BB;';
}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'cr_previous_page_link' );
function cr_previous_page_link ( $text ) {
    return '&#x000AB; Anterior';
}


function cr_custom_tag_cloud_widget($args) {
	$args['number'] = 20; //adding a 0 will display all tags
	$args['largest'] = 150; //largest tag
	$args['smallest'] = 120; //smallest tag
	$args['unit'] = '%'; //tag font unit
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'cr_custom_tag_cloud_widget' );

//* Customize search form input box text
add_filter( 'genesis_search_text', 'cr_search_text' );
function cr_search_text( $text ) {
	return esc_attr( 'Buscar en ClimaRisk...' );
}

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Customize the author box title
add_filter( 'genesis_author_box_title', 'custom_author_box_title' );
function custom_author_box_title() {
	//return '<strong>Sobre el autor:</strong>';
	$linea = do_shortcode('[post_author_link before="Autor: <em>" after="</em></br>"]');
	//$linea .= do_shortcode('[post_author_posts_link before = "</br>Otras contribuciones de " after=" en ClimaRisk"]');
	return $linea;
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'cr_author_box_gravatar_size' );
function cr_author_box_gravatar_size( $size ) {
	return '80';
}

//* Shortocodes

function utset_divider() {
	return '<div class="divider"></div>';
}
add_shortcode('divider', 'utset_divider');

function get_file_github( $atts ) {
  extract( shortcode_atts( array(
    'file' => ''
  ), $atts ) );
 
  if ($file!='') {
	  // Get remote HTML file
		$response = wp_remote_get( $file );
                       // Check for error
			if ( is_wp_error( $response ) ) {
				return;
			}
                // Parse remote HTML file
		$data = wp_remote_retrieve_body( $response );
                        // Check for error
			if ( is_wp_error( $data ) ) {
				return;
			}
  }
    return $data;
}
add_shortcode( 'get_file', 'get_file_github' );

function c_bmodal ($attr, $content) {

$divm = $attr['divm']; //Name of the modal div - Compulsory
$hrefr = get_permalink()."#$divm";
$mtitle = $attr['mtitle']; // Modal title
$content = esc_html($content);
$ppim = plugin_dir_url( __FILE__ ).'images/icon_info.gif';
	if (isset($attr['mtitle'])) {
$bmh = <<<bmht
<div class="modal-header">
<h4 class="modal-title">$mtitle</h4>
<button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
</div>
bmht;
	}
	else
$bmh = null;

if (isset($attr['divm'])) {
$bmd = <<<bdivm
<a data-target="#$divm" data-toggle="modal"> <img data-toggle="modal" class="align-top imgs" src="$ppim" title="Click para mas informacion"></a>
<div class="modal fade" id="$divm">
<div class="modal-dialog">
<div class="modal-content">
$bmh
<div class="modal-body text-justify">
$content
</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>
bdivm;
}
else
	$bmd = null;
return $bmd;

}

add_shortcode('bmodal', 'c_bmodal');

// Includes additional PHP file
function cr_include_func( $atts ) {
  extract( shortcode_atts( array(
    'include' => '',
  ), $atts ) );
  
  
  
  $include = $atts['include'];
  if ($include!='') { // Algo a incluir
    
      $ppi = plugin_dir_path( __FILE__ ) .'cr-includes/'.$include.'/';
      $file = $ppi.$include.'.php';
      ob_start(); // turn on output buffering
      include_once($file);
      $res = ob_get_contents(); 
      ob_end_clean(); 	  
	}
  return $res;
 }
 
add_shortcode( 'cr_include', 'cr_include_func' );

?>