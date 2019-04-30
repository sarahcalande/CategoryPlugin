<?php
/*
Plugin Name: AMP for WP Pagebuilder Custom
Plugin URI: https://wordpress.org/plugins/accelerated-mobile-pages/
Description: AMP for WP - Accelerated Mobile Pages for WordPress
Version: 0.1
Author: AMPforWP Team + Sarah Calande
Author URI: https://ampforwp.com/ ; https://sarahcalande.herokuapp.com
Donate link: https://www.paypal.me/Kaludi/25
License: GPL2+
Text Domain: ampforwp-pb-custom-code
Domain Path: /languages/
*/


if (! defined( 'ABSPATH') ){
  exit;
}

add_filter('ampforwp_pagebuilder_modules_filter','sarah_ampforwp_pb_cntmod_loopHtml');
if( !function_exists('sarah_ampforwp_pb_cntmod_loopHtml') ){
  function sarah_ampforwp_pb_cntmod_loopHtml($module){
    $module['contents']['front_loop_content'] = preg_replace('#{{if_condition_content_layout_type==1}}(.*)}}#si',' {{if_condition_content_layout_type==1}}
                              <li>
                                  <div class="cat_mod_l">
                                   <a href="{{ampforwp_post_url}}">
                                   {{if_image}}<amp-img  class="ampforwp_wc_shortcode_img"  src="{{image}}" width="{{width}}" height="{{height}}" layout="responsive" alt="{{image_alt}}"> </amp-img>{{ifend_image}}</a>
                                  </div>
                                  <div class="cat_mod_r">
                                    <a href="{{ampforwp_post_url}}">{{title}}</a>
                                    {{excerptContent}}
                                    <span class="custom_cat_format">{{category}}
                                    {{format}}</span>
                                    </div>
                                </li></a>
                           {{ifend_condition_content_layout_type_1}}', $module['contents']['front_loop_content']);
    return $module;
  }
}

add_filter('ampforwp_pb_cntmod_rawhtml', 'sarah_ampforwp_pb_cntmod_rawhtml');
if( !function_exists('sarah_ampforwp_pb_cntmod_rawhtml') ){
  function sarah_ampforwp_pb_cntmod_rawhtml($rawhtml){
    $format = get_post_format(ampforwp_get_the_ID());
    $category = get_the_category();
      if(is_array($category) && count($category) > 0){
        $category = $category[0]->name;
      }

      $rawhtml = str_replace(array(
          "{{category}}",
          "{{format}}"
      ),
      array(
      $category,
      $format,
      ),
      $rawhtml
      );
      $rawhtml = ampforwp_replaceIfContentConditional("category", $category, $rawhtml);
      $rawhtml = ampforwp_replaceIfContentConditional("format", $format, $rawhtml);
      return $rawhtml;
  }
}

?>
