<?php

use OFFLINE\SiteSearch\Classes\Providers\ResultsProvider;

class CustomBlogSearchProvider extends ResultsProvider
{
    public function search()
    {
        // Get your matching models
        $matching = DB::table('rainlab_blog_posts')
                    -> join('rainlab_blog_posts_categories', 'rainlab_blog_posts_categories.post_id', '=', 'rainlab_blog_posts.id')
                    -> join('rainlab_blog_categories', 'rainlab_blog_categories.id', '=', 'rainlab_blog_posts_categories.category_id')
                    -> where('title', 'like', "%{$this->query}%")
                    -> orWhere('content', 'like', "%{$this->query}%")
                    -> get();

        // Create a new Result for every match
        foreach ($matching as $match) {
            $result            = $this->newResult();

            $result->relevance = 1;
            $result->title     = $match->title;
            $result->excerpt  = $match->slug;
            $result->model     = $match;
            $result->meta      = [
                'category' => $match->category_id,
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