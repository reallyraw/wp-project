<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

///////////////////////////////////////////////////////////////////////////////////////////////////
//Import / Exports settings page
///////////////////////////////////////////////////////////////////////////////////////////////////
//Export SEOPress Settings to JSON
function seopress_export_settings() {
    if( empty( $_POST['seopress_action'] ) || 'export_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_export_nonce'], 'seopress_export_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'export_settings' ) ) ) {
        return;
    }

    $settings["seopress_activated"]                             = get_option( 'seopress_activated' );
    $settings["seopress_titles_option_name"]                    = get_option( 'seopress_titles_option_name' );
    $settings["seopress_social_option_name"]                    = get_option( 'seopress_social_option_name' );
    $settings["seopress_google_analytics_option_name"]          = get_option( 'seopress_google_analytics_option_name' );
    $settings["seopress_advanced_option_name"]                  = get_option( 'seopress_advanced_option_name' );
    $settings["seopress_xml_sitemap_option_name"]               = get_option( 'seopress_xml_sitemap_option_name' );
    $settings["seopress_pro_option_name"]                       = get_option( 'seopress_pro_option_name' );
    $settings["seopress_pro_mu_option_name"]                    = get_option( 'seopress_pro_mu_option_name' );
    $settings["seopress_pro_license_key"]                       = get_option( 'seopress_pro_license_key' );
    $settings["seopress_pro_license_status"]                    = get_option( 'seopress_pro_license_status' );
    $settings["seopress_bot_option_name"]                       = get_option( 'seopress_bot_option_name' );
    $settings["seopress_toggle"]                                = get_option( 'seopress_toggle' );
    $settings["seopress_google_analytics_lock_option_name"]     = get_option( 'seopress_google_analytics_lock_option_name' );

    ignore_user_abort( true );
    nocache_headers();
    header( 'Content-Type: application/json; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=seopress-settings-export-' . date( 'm-d-Y' ) . '.json' );
    header( "Expires: 0" );
    echo json_encode( $settings );
    exit;
}
add_action( 'admin_init', 'seopress_export_settings' );

//Import SEOPress Settings from JSON
function seopress_import_settings() {
    if( empty( $_POST['seopress_action'] ) || 'import_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_import_nonce'], 'seopress_import_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'import_settings' ) ) ) {
        return;
    } 

    $extension = pathinfo( $_FILES['import_file']['name'], PATHINFO_EXTENSION );

    if( $extension != 'json' ) {
        wp_die( __( 'Please upload a valid .json file' ) );
    }
    $import_file = $_FILES['import_file']['tmp_name'];
    
    if( empty( $import_file ) ) {
        wp_die( __( 'Please upload a file to import' ) );
    }

    $settings = (array)json_decode( seopress_remove_utf8_bom(file_get_contents( $import_file )), true );

    if ( $settings["seopress_activated"] !==false ) {
        update_option( 'seopress_activated', $settings["seopress_activated"] );
    }
    if ( $settings["seopress_titles_option_name"] !==false ) {
        update_option( 'seopress_titles_option_name', $settings["seopress_titles_option_name"] );
    }
    if ( $settings["seopress_social_option_name"] !==false ) {
        update_option( 'seopress_social_option_name', $settings["seopress_social_option_name"] );
    }
    if ( $settings["seopress_google_analytics_option_name"] !==false ) {
        update_option( 'seopress_google_analytics_option_name', $settings["seopress_google_analytics_option_name"] );
    }
    if ( $settings["seopress_advanced_option_name"] !==false ) {
        update_option( 'seopress_advanced_option_name', $settings["seopress_advanced_option_name"] );
    }
    if ( $settings["seopress_xml_sitemap_option_name"] !==false ) {
        update_option( 'seopress_xml_sitemap_option_name', $settings["seopress_xml_sitemap_option_name"] );
    }
    if ( $settings["seopress_pro_option_name"] !==false ) {
        update_option( 'seopress_pro_option_name', $settings["seopress_pro_option_name"] );
    }
    if ( $settings["seopress_pro_mu_option_name"] !==false ) {
        update_option( 'seopress_pro_mu_option_name', $settings["seopress_pro_mu_option_name"] );
    }
    if ( $settings["seopress_pro_license_key"] !==false ) {
        update_option( 'seopress_pro_license_key', $settings["seopress_pro_license_key"] );
    }
    if ( $settings["seopress_pro_license_status"] !==false ) {
        update_option( 'seopress_pro_license_status', $settings["seopress_pro_license_status"] );
    }
    if ( $settings["seopress_bot_option_name"] !==false ) {
        update_option( 'seopress_bot_option_name', $settings["seopress_bot_option_name"] );
    }
    if ( $settings["seopress_toggle"] !==false ) {
        update_option( 'seopress_toggle', $settings["seopress_toggle"] );
    }
    if ( $settings["seopress_google_analytics_lock_option_name"] !==false ) {
        update_option( 'seopress_google_analytics_lock_option_name', $settings["seopress_google_analytics_lock_option_name"] );
    }

    wp_safe_redirect( admin_url( 'admin.php?page=seopress-import-export&success=true' ) );
    exit;
}
add_action( 'admin_init', 'seopress_import_settings' );

//Import Redirections from CSV
function seopress_import_redirections_settings() {
    if( empty( $_POST['seopress_action'] ) || 'import_redirections_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_import_redirections_nonce'], 'seopress_import_redirections_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'import_settings' ) ) ) {
        return;
    }
    
    $extension = pathinfo( $_FILES['import_file']['name'], PATHINFO_EXTENSION );
    
    if( $extension != 'csv' ) {
        wp_die( __( 'Please upload a valid .csv file' ) );
    }
    $import_file = $_FILES['import_file']['tmp_name'];
    if( empty( $import_file ) ) {
        wp_die( __( 'Please upload a file to import' ) );
    }
    $extension = explode( '.', $import_file );
    $extension = end($extension);
    if( $extension != 'csv' ) {
        wp_die( __( 'Please upload a valid .csv file' ) );
    }

    $csv = array_map('str_getcsv', file($import_file));

    foreach ($csv as $key => $value) {
        foreach ($value as $_key => $_value) {
            $csv_line = explode ( ';', $_value );

            //Third column: redirections type
            if ($csv_line[2] =='301' || $csv_line[2] =='302' || $csv_line[2]=='307' || $csv_line[2]=='410' || $csv_line[2]=='451') {
                $csv_type_redirects[2] = $csv_line[2];
            }

            //Fourth column: redirections enabled
            if ($csv_line[3] =='yes') {
                $csv_type_redirects[3] = $csv_line[3];
            } else {
                $csv_type_redirects[3] = '';
            }

            //Fifth column: redirections query param
            if ($csv_line[4] =='exact_match' || $csv_line[4] =='with_ignored_param' || $csv_line[4] =='without_param') {
                $csv_type_redirects[4] = $csv_line[4];
            } else {
                $csv_type_redirects[4] = 'exact_match';
            }

            if (!empty($csv_line[0])) {
                $id = wp_insert_post(array('post_title' => urldecode($csv_line[0]), 'post_type' => 'seopress_404', 'post_status' => 'publish', 'meta_input' => array( '_seopress_redirections_value' => urldecode($csv_line[1]), '_seopress_redirections_type' => $csv_type_redirects[2], '_seopress_redirections_enabled' =>  $csv_type_redirects[3], '_seopress_redirections_param' => $csv_type_redirects[4])));
            }
        }
    }

    wp_safe_redirect( admin_url( 'edit.php?post_type=seopress_404' ) );
    exit;
}
add_action( 'admin_init', 'seopress_import_redirections_settings' );

//Import Redirections from Yoast Premium (CSV)
function seopress_import_yoast_redirections() {
    if( empty( $_POST['seopress_action'] ) || 'import_yoast_redirections' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_import_yoast_redirections_nonce'], 'seopress_import_yoast_redirections_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'import_settings' ) ) ) {
        return;
    } 
    
    $extension = pathinfo( $_FILES['import_file']['name'], PATHINFO_EXTENSION );

    if( $extension != 'csv' ) {
        wp_die( __( 'Please upload a valid .csv file' ) );
    }
    $import_file = $_FILES['import_file']['tmp_name'];
    if( empty( $import_file ) ) {
        wp_die( __( 'Please upload a file to import' ) );
    }
    $extension = explode( '.', $import_file );
    $extension = end($extension);
    if( $extension != 'csv' ) {
        wp_die( __( 'Please upload a valid .csv file' ) );
    }

    $csv = array_map('str_getcsv', file($import_file));

    foreach (array_slice($csv,1) as $_key => $_value) {
        $csv_line = $_value;

        //Third column: redirections type
        if ($csv_line[2] =='301' || $csv_line[2] =='302' || $csv_line[2]=='307' || $csv_line[2]=='410' || $csv_line[2]=='451') {
            $csv_type_redirects[2] = $csv_line[2];
        }

        //Fourth column: redirections enabled
        $csv_type_redirects[3] = 'yes';

        //Fifth column: redirections query param
        $csv_type_redirects[4] = 'exact_match';

        if (!empty($csv_line[0])) {
            $csv_line[0] = substr($csv_line[0], 1);
            if (!empty($csv_line[1])) {
                if ($csv_line[1] ==='//') {
                    $csv_line[1] = '/';
                } else {
                    $csv_line[1] = home_url().$csv_line[1];
                }
            }
            $id = wp_insert_post(array('post_title' => urldecode($csv_line[0]), 'post_type' => 'seopress_404', 'post_status' => 'publish', 'meta_input' => array( '_seopress_redirections_value' => urldecode($csv_line[1]), '_seopress_redirections_type' => $csv_type_redirects[2], '_seopress_redirections_enabled' =>  $csv_type_redirects[3], '_seopress_redirections_param' => $csv_type_redirects[4])));
        }
    }
    wp_safe_redirect( admin_url( 'edit.php?post_type=seopress_404' ) );
    exit;
}
add_action( 'admin_init', 'seopress_import_yoast_redirections' );

//Export Redirections to CSV file
function seopress_export_redirections_settings() {
    if( empty( $_POST['seopress_action'] ) || 'export_redirections' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_export_redirections_nonce'], 'seopress_export_redirections_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'export_settings' ) ) ) {
        return;
    }

    //Init
    $redirects_html = '';

    $args = array(
        'post_type' => 'seopress_404',
        'posts_per_page' => '-1',
        'meta_query' => array(
            array(
                'key'     => '_seopress_redirections_type',
                'value'   => array('301','302','307','410','451'),
                'compare' => 'IN',
            ),
        ),
    );
    $seopress_redirects_query = new WP_Query( $args );

    if ( $seopress_redirects_query->have_posts() ) {
        while ( $seopress_redirects_query->have_posts() ) {
            $seopress_redirects_query->the_post();
            $redirects_html .= '"'.urldecode(urlencode(esc_attr(wp_filter_nohtml_kses(get_the_title())))).'"';
            $redirects_html .= ';';
            $redirects_html .= '"'.urldecode(urlencode(esc_attr(wp_filter_nohtml_kses(get_post_meta(get_the_ID(),'_seopress_redirections_value',true))))).'"';
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(),'_seopress_redirections_type',true);
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(),'_seopress_redirections_enabled',true);
            $redirects_html .= ';';
            $redirects_html .= get_post_meta(get_the_ID(),'_seopress_redirections_param',true);
            $redirects_html .= ';';
            $redirects_html .= "\n";
        }
        wp_reset_postdata();
    }

    ignore_user_abort( true );
    nocache_headers();
    header( 'Content-Type: application/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=seopress-redirections-export-' . date( 'm-d-Y' ) . '.csv' );
    header( "Expires: 0" );
    echo $redirects_html;
    exit;
}
add_action( 'admin_init', 'seopress_export_redirections_settings' );

//Import Redirections from Redirections plugin JSON file
function seopress_import_redirections_plugin_settings() {
    if( empty( $_POST['seopress_action'] ) || 'import_redirections_plugin_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_import_redirections_plugin_nonce'], 'seopress_import_redirections_plugin_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'import_settings' ) ) ) {
        return;
    }
    
    $extension = pathinfo( $_FILES['import_file']['name'], PATHINFO_EXTENSION );

    if( $extension != 'json' ) {
        wp_die( __( 'Please upload a valid .json file' ) );
    }
    $import_file = $_FILES['import_file']['tmp_name'];
    if( empty( $import_file ) ) {
        wp_die( __( 'Please upload a file to import' ) );
    }

    $extension = explode( '.', $import_file );
    $extension = end($extension);
    if( $extension != 'json' ) {
        wp_die( __( 'Please upload a valid .json file' ) );
    }

    $settings = (array) json_decode( file_get_contents( $import_file ), true );

    foreach ($settings['redirects'] as $redirect_key => $redirect_value) {
        $type = '';
        if (!empty($redirect_value['action_code'])) {
            $type = $redirect_value['action_code'];
        } else {
            $type = '301';
        }

        $param = '';
        if (!empty($redirect_value['match_data']['source']['flag_query'])) {
            $flag_query = $redirect_value['match_data']['source']['flag_query'];
            if ($flag_query =='pass') {
                $param = 'with_ignored_param';
            } elseif ($flag_query =='ignore') {
                $param = 'without_param';
            } else {
                $param = 'exact_match';
            }
        }

        $enabled ='';
        if (!empty($redirect_value['enabled'] ==true)) {
            $enabled ='yes';
        }

        wp_insert_post(array('post_title' => ltrim(urldecode($redirect_value['url']), '/'), 'post_type' => 'seopress_404', 'post_status' => 'publish', 'meta_input' => array( '_seopress_redirections_value' => urldecode($redirect_value['action_data']['url']), '_seopress_redirections_type' => $type, '_seopress_redirections_enabled' => $enabled, '_seopress_redirections_param' => $param)));
    }

    wp_safe_redirect( admin_url( 'edit.php?post_type=seopress_404' ) );
    exit;
}
add_action( 'admin_init', 'seopress_import_redirections_plugin_settings' );

//Import Redirections from Rank Math plugin TXT file
//@since 3.8.2
//@author Benjamin Denis
function seopress_import_rk_redirections() {
    if( empty( $_POST['seopress_action'] ) || 'import_rk_redirections' != $_POST['seopress_action'] )
        return;
    if( ! wp_verify_nonce( $_POST['seopress_import_rk_redirections_nonce'], 'seopress_import_rk_redirections_nonce' ) )
        return;
    if( ! current_user_can( seopress_capability( 'manage_options', 'import_settings' ) ) )
        return;
    $extension = explode( '.', $_FILES['import_file']['name'] );
    $extension = end($extension);
    if( $extension != 'txt' ) {
        wp_die( __( 'Please upload a valid .txt file' ) );
    }
    $import_file = $_FILES['import_file']['tmp_name'];
    if( empty( $import_file ) ) {
        wp_die( __( 'Please upload a file to import' ) );
    }

    $settings = (array) json_decode( file_get_contents( $import_file ), true );

    foreach ($settings['redirections'] as $redirect_key => $redirect_value) {
        $type = '';
        if (!empty($redirect_value['header_code'])) {
            $type = $redirect_value['header_code'];
        }

        $source = '';
        if (!empty($redirect_value['sources'])) {
            $source = maybe_unserialize($redirect_value['sources']);
            $source = ltrim(urldecode($source[0]['pattern']), '/');
        }

        $param = 'exact_match';

        $enabled ='';
        if (!empty($redirect_value['status'] =="active")) {
            $enabled ='yes';
        }

        $redirect ='';
        if (!empty($redirect_value['url_to'])) {
            $redirect = urldecode($redirect_value['url_to']);
        }

        $count ='';
        if (!empty($redirect_value['hits'])) {
            $count = $redirect_value['hits'];
        }

        wp_insert_post(
            array(
                'post_title' => $source, 
                'post_type' => 'seopress_404', 
                'post_status' => 'publish', 
                'meta_input' => array( 
                    '_seopress_redirections_value' => $redirect, 
                    '_seopress_redirections_type' => $type, 
                    '_seopress_redirections_enabled' => $enabled, 
                    'seopress_404_count' => $count,
                    '_seopress_redirections_param' => $param
                )
            )
        );
    }

    wp_safe_redirect( admin_url( 'edit.php?post_type=seopress_404' ) ); exit;
}
add_action( 'admin_init', 'seopress_import_rk_redirections' );

//Clean all 404
function seopress_clean_404_query_hook($args) {
    unset($args['date_query']);
    return $args;
}


function seopress_clean_404() {
    if( empty( $_POST['seopress_action'] ) || 'clean_404' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_clean_404_nonce'], 'seopress_clean_404_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', '404' ) ) ) {
        return;
    }

    add_filter('seopress_404_cleaning_query', 'seopress_clean_404_query_hook');
    do_action('seopress_404_cron_cleaning');
    wp_safe_redirect( admin_url( 'edit.php?post_type=seopress_404' ) );
    exit;
}
add_action( 'admin_init', 'seopress_clean_404' );

//Reset SEOPress Notices Settings
function seopress_reset_notices_settings() {
    if( empty( $_POST['seopress_action'] ) || 'reset_notices_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_reset_notices_nonce'], 'seopress_reset_notices_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'reset_settings' ) ) ) {
        return;
    }

    global $wpdb;

    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'seopress_notices' ");

    wp_safe_redirect( admin_url( 'admin.php?page=seopress-import-export' ) );
    exit;
}
add_action( 'admin_init', 'seopress_reset_notices_settings' );

//Reset SEOPress Settings
function seopress_reset_settings() {
    if( empty( $_POST['seopress_action'] ) || 'reset_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_reset_nonce'], 'seopress_reset_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'reset_settings' ) ) ) {
        return;
    }

    global $wpdb;

    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'seopress_%' ");

    wp_safe_redirect( admin_url( 'admin.php?page=seopress-import-export' ) );
    exit;
}
add_action( 'admin_init', 'seopress_reset_settings' );

//Export SEOPress BOT Links to CSV
function seopress_bot_links_export_settings() {
    if( empty( $_POST['seopress_action'] ) || 'export_csv_links_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_export_csv_links_nonce'], 'seopress_export_csv_links_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'export_settings' ) ) ) {
        return;
    }
    $args = array(
        'post_type' => 'seopress_bot',
        'posts_per_page' => 1000,
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'date',
    );
    $the_query = new WP_Query( $args );

    $settings["URL"] = array();
    $settings["Source"] = array();
    $settings["Source_Url"] = array();
    $settings["Status"] = array();
    $settings["Type"] = array();

    $csv_fields = array();
    $csv_fields[] = 'URL';
    $csv_fields[] = 'Source';
    $csv_fields[] = 'Source URL';
    $csv_fields[] = 'Status';
    $csv_fields[] = 'Type';

    $output_handle = @fopen( 'php://output', 'w' );

    //Insert header row
    fputcsv( $output_handle, $csv_fields );

    //Header
    ignore_user_abort( true );
    nocache_headers();
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=seopress-links-export-' . date( 'm-d-Y' ) . '.csv' );
    header( 'Expires: 0' );
    header( 'Pragma: public' );

    // The Loop
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            array_push($settings["URL"], get_the_title());

            array_push($settings["Source"], get_post_meta( get_the_ID(), 'seopress_bot_source_title', true ));

            array_push($settings["Source_Url"], get_post_meta( get_the_ID(), 'seopress_bot_source_url', true ));

            array_push($settings["Status"], get_post_meta( get_the_ID(), 'seopress_bot_status', true ));

            array_push($settings["Type"], get_post_meta( get_the_ID(), 'seopress_bot_type', true ));

            fputcsv( $output_handle, array_merge($settings["URL"], $settings["Source"], $settings["Source_Url"], $settings["Status"], $settings["Type"]));

            //Clean arrays
            $settings["URL"] = array();
            $settings["Source"] = array();
            $settings["Source_Url"] = array();
            $settings["Status"] = array();
            $settings["Type"] = array();

        }
        wp_reset_postdata();
    }

    // Close output file stream
    fclose( $output_handle );

    exit;
}
add_action( 'admin_init', 'seopress_bot_links_export_settings' );

//Export SEOPress Backlinks to CSV
function seopress_backlinks_export_settings() {
    if( empty( $_POST['seopress_action'] ) || 'export_backlinks_settings' != $_POST['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_POST['seopress_export_backlinks_nonce'], 'seopress_export_backlinks_nonce' ) ) {
        return;
    }
    if( ! current_user_can( seopress_capability( 'manage_options', 'export_settings' ) ) ) {
        return;
    }
    $args = array(
        'post_type' => 'seopress_backlinks',
        'posts_per_page' => 1000,
        'post_status' => 'publish',
        'order' => 'DESC',
        'orderby' => 'date',
    );
    $the_query = new WP_Query( $args );

    $settings["URL"] = array();
    $settings["Anchor_text"] = array();
    $settings["Source_citation_flow"] = array();
    $settings["Source_trust_flow"] = array();
    $settings["Target_citation_flow"] = array();
    $settings["Target_trust_flow"] = array();
    $settings["Found_date"] = array();
    $settings["Last_update"] = array();

    $csv_fields = array();
    $csv_fields[] = 'URL';
    $csv_fields[] = 'Anchor Text';
    $csv_fields[] = 'Source Citation Flow';
    $csv_fields[] = 'Source Trust Flow';
    $csv_fields[] = 'Target Citation Flow';
    $csv_fields[] = 'Target Trust Flow';
    $csv_fields[] = 'First indexed';
    $csv_fields[] = 'Last Update';

    $output_handle = @fopen( 'php://output', 'w' );

    //Insert header row
    fputcsv( $output_handle, $csv_fields );

    //Header
    ignore_user_abort( true );
    nocache_headers();
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=seopress-backlinks-export-' . date( 'm-d-Y' ) . '.csv' );
    header( 'Expires: 0' );
    header( 'Pragma: public' );

    // The Loop
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            array_push($settings["URL"], get_the_title());

            array_push($settings["Anchor_text"], get_post_meta( get_the_ID(), 'seopress_backlinks_anchor_text', true ));

            array_push($settings["Source_citation_flow"], get_post_meta( get_the_ID(), 'seopress_backlinks_source_citation_flow', true ));

            array_push($settings["Source_trust_flow"], get_post_meta( get_the_ID(), 'seopress_backlinks_source_trust_flow', true ));

            array_push($settings["Target_citation_flow"], get_post_meta( get_the_ID(), 'seopress_backlinks_target_citation_flow', true ));

            array_push($settings["Target_trust_flow"], get_post_meta( get_the_ID(), 'seopress_backlinks_target_trust_flow', true ));

            array_push($settings["Found_date"], get_post_meta( get_the_ID(), 'seopress_backlinks_found_date', true ));

            array_push($settings["Last_update"], get_post_meta( get_the_ID(), 'seopress_backlinks_last_update', true ));

            fputcsv( $output_handle, array_merge(
                        $settings["URL"],
                        $settings["Anchor_text"],
                        $settings["Source_citation_flow"],
                        $settings["Source_trust_flow"],
                        $settings["Target_citation_flow"],
                        $settings["Target_trust_flow"],
                        $settings["Found_date"],
                        $settings["Last_update"]
                    )
            );

            //Clean arrays
            $settings["URL"] = array();
            $settings["Anchor_text"] = array();
            $settings["Source_citation_flow"] = array();
            $settings["Source_trust_flow"] = array();
            $settings["Target_citation_flow"] = array();
            $settings["Target_trust_flow"] = array();
            $settings["Found_date"] = array();
            $settings["Last_update"] = array();

        }
        wp_reset_postdata();
    }

    // Close output file stream
    fclose( $output_handle );

    exit;
}
add_action( 'admin_init', 'seopress_backlinks_export_settings' );

//Export metadata
function seopress_download_batch_export() {
    if( empty( $_GET['seopress_action'] ) || 'seopress_download_batch_export' != $_GET['seopress_action'] ) {
        return;
    }
    if( ! wp_verify_nonce( $_GET['nonce'], 'seopress_csv_batch_export_nonce' ) ) {
        return;
    }
    if ( current_user_can( seopress_capability( 'manage_options', 'export_settings' ) && is_admin() ) ) {

        if (get_option('seopress_metadata_csv') !='') {
            $csv = get_option('seopress_metadata_csv');

            $csv_fields = array();
            $csv_fields[] = 'id';
            $csv_fields[] = 'post_title';
            $csv_fields[] = 'url';
            $csv_fields[] = 'meta_title';
            $csv_fields[] = 'meta_desc';
            $csv_fields[] = 'fb_title';
            $csv_fields[] = 'fb_desc';
            $csv_fields[] = 'fb_img';
            $csv_fields[] = 'tw_title';
            $csv_fields[] = 'tw_desc';
            $csv_fields[] = 'tw_img';
            $csv_fields[] = 'noindex';
            $csv_fields[] = 'nofollow';
            $csv_fields[] = 'noodp';
            $csv_fields[] = 'noimageindex';
            $csv_fields[] = 'noarchive';
            $csv_fields[] = 'nosnippet';
            $csv_fields[] = 'canonical_url';
            $csv_fields[] = 'target_kw';
            ob_start();
            $output_handle = @fopen( 'php://output', 'w' );

            //Insert header row
            fputcsv( $output_handle, $csv_fields, ';' );

            //Header
            ignore_user_abort( true );
            nocache_headers();
            header( 'Content-Type: text/csv; charset=utf-8' );
            header( 'Content-Disposition: attachment; filename=seopress-metadata-export-' . date( 'm-d-Y' ) . '.csv' );
            header( 'Expires: 0' );
            header( 'Pragma: public' );

            if (!empty($csv)) {
                foreach($csv as $value) {
                    fputcsv( $output_handle, $value, ';');
                }
            }

            // Close output file stream
            fclose( $output_handle );

            //Clean database
            delete_option('seopress_metadata_csv');
            exit;
        }
    }
}
add_action( 'admin_init', 'seopress_download_batch_export' );