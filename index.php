<?php 
/*
Plugin Name: ALT Lab Gravity Cloud
Plugin URI:  https://github.com/
Description: Makes a word cloud of your gravity form based on the shortcode [gcloud id=''] with ID being the gravity form ID. Use wordcloud2.js
Version:     1.0
Author:      ALT Lab
Author URI:  http://altlab.vcu.edu
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('wp_enqueue_scripts', 'gqcloud_load_scripts');

function gqcloud_load_scripts() {                           
    $deps = array();
    $version= '1.0'; 
    $in_footer = false;    
    wp_enqueue_script('gravity-cloud-main-js', plugin_dir_url( __FILE__) . 'js/gravity-cloud-main.js',$deps, $version, $in_footer); 
    wp_enqueue_style( 'gravity-cloud-main-css', plugin_dir_url( __FILE__) . 'css/gravity-cloud-main.css');  
}



//TEMPooooooorary

function my_the_content_filter($content) {
  // assuming you have created a page/post entitled 'debug'
 $script = "<script>
let list = [['bar', 56], ['buzz', 72], ['spanish', 21], ['green', 11]];
var attempt = WordCloud(document.getElementById('demo'), { list: list } );
</script>";

  return $content . $script;
}

add_filter( 'the_content', 'my_the_content_filter' );


function get_gform_words($form_id){
	$search_criteria = array(
    'status'        => 'active',
);

  $sorting         = array();
  $paging          = array( 'offset' => 0, 'page_size' => 200);
  $total_count     = 0;

  $entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, $paging, $total_count );
  $raw = "";
  foreach ($entries as $key => $value) {
  	# code...
  	 //print("<pre>".print_r($value[2],true)."</pre>");
  	 $raw .= $value[2];
     //$common_removed = remove_common_words($raw);
  	 $no_punctuation = preg_replace("/(?!['=$%-])\p{P}/u", "",$raw);
  	 $bits = preg_split('/\s+/', $no_punctuation);
		print("<pre>".print_r($bits,true)."</pre>");
  }
 

}

function gqcloud_make_the_list( $atts, $content = null ) {
    extract(shortcode_atts( array(
         'id' => '', //gform ID        
    ), $atts));         

    if($id){
    	$entries = get_gform_words($id);
       return $entries;
    }    
	
}
add_shortcode( 'gcloud', 'gqcloud_make_the_list' );


//REMOVE CERTAIN WORDS
// function remove_common_words($input){
//    $commonWords = array('a', 'the', 'and', 'these', 'an', 'am', 'is', 'that', 'are');
//    $input = preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
//    return $input;
//  }