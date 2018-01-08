<?php
/**
 * Created by PhpStorm.
 * User: Digi
 * Date: 08/01/2018
 * Time: 09:35
 */

function onStart() {
    $db_categories = Db::table('rainlab_blog_categories')->get();

    $cat_list = array();
    foreach ($db_categories as $category) {
        array_push($cat_list, $category);
    }
    $this['categories'] = $cat_list;



    $take_count = 3;

    $recent_categories = DB::table('rainlab_blog_posts')
        -> join('rainlab_blog_posts_categories', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
        -> join('rainlab_blog_categories', 'rainlab_blog_posts_categories.category_id', '=', 'rainlab_blog_categories.id')
        -> orderBy('published_at', 'desc')
        -> select(DB::raw('rainlab_blog_categories.slug as cat_slug'))
        -> take($take_count)
        -> get();

    $recent_cat_array = array();
    foreach ($recent_categories as $category) {
        if (!in_array($category, $recent_cat_array)) {
        array_push($recent_cat_array, $category);
    }
    }

    dd($recent_cat_array);


}