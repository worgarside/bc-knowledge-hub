<?php
function onStart()
{



    $db_categories = Db::table('rainlab_blog_categories')->get();

    $cat_list = array();

    $valid_category = false;

    foreach ($db_categories as $category) {
        if ($category->slug == $this -> param('category')) { $valid_category = true; }
        array_push($cat_list, $category);
    }

    $this['valid_category'] = $valid_category;

    if ($valid_category) {

        $this['category_count'] = sizeof($cat_list);
        $this['categories'] = $cat_list;

        $current_category = $db_categories
            -> where('slug', $this -> param('category'))
            -> first();

        $this['category'] = $current_category;

        $master_table = DB::table('rainlab_blog_posts_categories')
            -> join('rainlab_blog_posts', 'rainlab_blog_posts_categories.post_id', '=', 'rainlab_blog_posts.id')
            -> join('backend_users', 'rainlab_blog_posts.user_id', '=', 'backend_users.id')
            -> where('rainlab_blog_posts_categories.category_id', '=', $current_category->id)
            -> where('rainlab_blog_posts.published', '=', 1)
            -> select('title', 'slug', 'content_html', 'excerpt', 'first_name', 'last_name', 'published_at')
            -> orderBy('published_at', 'desc')
            -> take(5)
            -> get();

        $articles = array();
        foreach ($master_table as $post) {
            array_push($articles, $post);
        }
        $this['articles'] = $articles;
    }
}