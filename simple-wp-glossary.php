<?php
/*
Plugin Name: Simple WP Glossary
Description: A simplified WordPress plugin for creating and displaying glossary terms.
Version: 1.0
Author: Priit Tammets
*/

// Security check
if (!defined('ABSPATH')) {
    exit;
}

// Register Custom Post Type for Glossary Terms
function swpgl_register_glossary_post_type() {
    $labels = [
        'name'                  => 'Glossary Terms',
        'singular_name'         => 'Glossary Term',
        'menu_name'             => 'Glossary',
        'name_admin_bar'        => 'Glossary Term',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Glossary Term',
        'edit_item'             => 'Edit Glossary Term',
        'new_item'              => 'New Glossary Term',
        'view_item'             => 'View Glossary Term',
        'all_items'             => 'All Glossary Terms',
        'search_items'          => 'Search Glossary Terms',
        'not_found'             => 'No glossary terms found.',
        'not_found_in_trash'    => 'No glossary terms found in Trash.',
    ];

    $args = [
        'labels'                => $labels,
        'public'                => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-book-alt', // Icon in the admin menu
        'supports'              => ['title', 'editor'],
        'has_archive'           => false,
        'show_in_rest'          => true, // Enables Gutenberg editor
    ];

    register_post_type('glossary_term', $args);
}
add_action('init', 'swpgl_register_glossary_post_type');

// Shortcode to Display Glossary Terms
function swpgl_display_glossary_terms($atts) {
    // Fetch all glossary terms
    $glossary_query = new WP_Query([
        'post_type'      => 'glossary_term',
        'posts_per_page' => -1, // Show all terms
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);

    if ($glossary_query->have_posts()) {
        $output = '<ul class="glossary-terms">';
        while ($glossary_query->have_posts()) {
            $glossary_query->the_post();
            $output .= '<li>';
            $output .= '<strong>' . get_the_title() . ':</strong> ';
            $output .= get_the_content();
            $output .= '</li>';
        }
        $output .= '</ul>';
        wp_reset_postdata();

        return $output;
    } else {
        return '<p>No glossary terms found.</p>';
    }
}
add_shortcode('glossary_terms', 'swpgl_display_glossary_terms');

// Shortcode for Hover Link to Display Glossary Term
function swpgl_hover_glossary_term($atts, $content = null) {
    $atts = shortcode_atts(
        ['id' => 0], // Expecting the glossary term ID
        $atts,
        'glossary_hover'
    );

    if (!$atts['id']) {
        return $content; // If no ID is provided, return the original content
    }

    $term_post = get_post($atts['id']);
    if (!$term_post || $term_post->post_type !== 'glossary_term') {
        return $content; // If the term doesn't exist, return the original content
    }

    // Prepare the term's title and description for display
    $title = esc_html($term_post->post_title);
    $description = esc_html(wp_trim_words($term_post->post_content, 30));

    // Return the hover link with a data attribute for the popup content
    return '<span class="glossary-term" data-term-title="' . $title . '" data-term-desc="' . $description . '">' . $content . '</span>';
}
add_shortcode('glossary_hover', 'swpgl_hover_glossary_term');

// Enqueue Scripts and Styles
function swpgl_enqueue_assets() {
    // Enqueue CSS
    wp_enqueue_style(
        'swpgl-style',
        plugin_dir_url(__FILE__) . 'assets/css/swpgl-style.css'
    );

    // Enqueue JavaScript
    wp_enqueue_script(
        'swpgl-script',
        plugin_dir_url(__FILE__) . 'assets/js/swpgl-script.js',
        ['jquery'],
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'swpgl_enqueue_assets');