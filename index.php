<?php 
/*
Plugin Name: ALT Lab Gravity Cloud
Plugin URI:  https://github.com/RVA-ALT-Lab/altlab-gravity-cloud
Description: Makes a word cloud of your gravity form based on the shortcode [gcloud id='' fields='' size=''] with ID being the gravity form ID. Uses wordcloud2.js to create the cloud. Will use form id=1 and fields=1 and size=1.6 if no variables are set.
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
    wp_enqueue_script('gravity-cloud-main-js', plugin_dir_url( __FILE__) . 'js/gravity-cloud-main.js',array(), '1.0', true); 
    wp_enqueue_style( 'gravity-cloud-main-css', plugin_dir_url( __FILE__) . 'css/gravity-cloud-main.css');  
    wp_enqueue_script('gravity-cloud-indiv-js', plugin_dir_url( __FILE__) . 'js/gravity-cloud-indiv.js',array('gravity-cloud-main-js'),'1.0', true); 
}


function get_gform_words($form_id, $fields){
	$search_criteria = array(
    'status'        => 'active',
);

  $sorting         = array();
  $paging          = array( 'offset' => 0, 'page_size' => 200);
  $total_count     = 0;

  $entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, $paging, $total_count );
  $raw = "";
  $tag_data = [];
  $fields_array = explode(',',$fields);
  foreach ($entries as $key => $value) {
  	# code...
  	 //print("<pre>".print_r($value[2],true)."</pre>");  	 
     foreach ($fields_array as $field_id) {
       $raw .= $value[$field_id];
     }
    
     //$common_removed = remove_common_words($raw);
  	 $no_punctuation = preg_replace("/(?![=$%-])\p{P}/u", "",$raw);
  	 $bits = preg_split('/\s+/', $no_punctuation);
     foreach ($bits as $key => $bit) {
       # code...
      if(multiKeyExists($tag_data, $bit)) {
        $i = $tag_data[$bit] = $tag_data[$bit]+1;
      } else {
        $tag_data[$bit] = 1;
      }
     }   
  }
 
     //print("<pre>".print_r($tag_data,true)."</pre>");
     //$formatted = '['.data_to_tag_format ($tag_data) . ']';
     //print("<pre>".print_r($formatted,true)."</pre>");
     return $tag_data;
}

function data_to_tag_format ($data){
  $cloud_data = array();
  foreach ($data as $key => $tag) {
    $cloud_data[$key]= $tag;
  }
  return $cloud_data;
}


//SHORTCODE THAT RETURNS THE ID
function gqcloud_make_the_list( $atts, $content = null ) {
    extract(shortcode_atts( array(
         'id' => '', //gform ID   
         'fields' => '',
         'size' => '',     
    ), $atts));         
    if($id){      
    	$id = $id;   
    } else {
      $id = 1;
    } 
    if ($fields){
      $fields = $fields;
    }  else {
      $fields = 1;
    }
     if ($size){
      $size = $size;
     } else {
      $size = 1.6;
     }
    $entries = get_gform_words($id, $fields);   
   //return $entries;
    $cloud_data = array(          
           'source' => json_encode($entries),
           'size' => $size,
       );
    wp_localize_script('gravity-cloud-indiv-js', 'cloudData', $cloud_data); //sends data to script as variable
	  return '<div id="gc-cloud" style="100%; height: 50vw; position: relative;">foo</div>';
}
add_shortcode( 'gcloud', 'gqcloud_make_the_list' );


//WORKER FUNCTIONS


//COUNTS THE WORD 
function increment_tag_count($array, $key){
   $array[$key] = (int)$array[$key]+1;
}


//CHECKS FOR DUCPLICATES
function multiKeyExists(array $arr, $key) {

    // is in base array?
    if (array_key_exists($key, $arr)) {
        return true;
    }

    // check arrays contained in this array
    foreach ($arr as $element) {
        if (is_array($element)) {
            if (multiKeyExists($element, $key)) {
                return true;
            }
        }

    }

    return false;
}



//REMOVE CERTAIN WORDS
// function remove_common_words($input){
//    $commonWords = array('a', 'the', 'and', 'these', 'an', 'am', 'is', 'that', 'are');
//    $input = preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
//    return $input;
//  }