<?php

use OFFLINE\SiteSearch\Classes\Providers\ResultsProvider;

class CustomBlogSearchProvider extends ResultsProvider
{
    public function search()
    {
        $matching = DB::table('rainlab_blog_posts')
            -> join('rainlab_blog_posts_categories', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
            -> join('rainlab_blog_categories', 'rainlab_blog_posts_categories.category_id', '=', 'rainlab_blog_categories.id')
            -> select(DB::raw('rainlab_blog_posts.*, rainlab_blog_categories.name as cat_name,  rainlab_blog_categories.slug as cat_slug'))
            -> where('rainlab_blog_posts.published', '=', 1)
            ->where(function($query){
                return $query
                    -> where('title', 'like', "%{$this->query}%")
                    -> orWhere('content', 'like', "%{$this->query}%");
            })
            -> get();

        foreach ($matching as $match) {
            $result            = $this->newResult();

            $result->relevance = 1;
            $result->title     = $match->title;
            $result->excerpt   = $match->excerpt;
            $result->model     = $match;
            $result->url       = "/knowledge-hub/$match->cat_slug/$match->slug";
            $result->meta      = [
                'slug' => $match->slug,
                'cat_name' => $match->cat_name,
                'cat_slug' => $match->cat_slug
            ];

            // Add the results to the results collection
            $this->addResult($result);
        }

        return $this;
    }

    public function displayName()
    {
        return 'My Result';
    }

    public function identifier()
    {
        return 'VendorName.PluginName';
    }
}