# Business Comparison Knowledge Hub

## Dependencies/Plugins

- [Rainlab.Blog](https://octobercms.com/plugin/rainlab-blog) is used to create, edit and manages the articles and categories of the BC Knowledge Hub.
    - To access the CMS part of the plugin, visit [/backend/rainlab/blog/posts](https://www.businesscomparison.com/knowledge-hub/backend/rainlab/blog/posts)
    - When creating a new post, a title, (auto-generated) slug, and category **must** be assigned before publishing the article. If no category is chosen, the article will not appear.
        - When publishing an article, the date is required but time is set as the current time.
        - Any of these fields can be edited at any time, even post-publish. 
    - A new category can be added at any time, and all pages will update to reflect this.
        - However, for correct display of the icon on the homepage, CSS rules must be added and icons added to the assets folder.
        - The CSS rules and icon names are based on the category slug.
    - The article can be formatted using [standard markdown formatting](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet)
        - The in-built controls can be used to add images, videos, audio and documents.
    - The tag-line of the category is set by the description field of the category in the October CMS side.
- [Offline.SiteSearch](https://octobercms.com/plugin/offline-sitesearch) is used to search the articles for keywords. It also generates the search results page.
    - It has been slightly modified to allow for correct URL generation regarding categories.
    
## Installation

Run `composer install` in the root directory

## Edited Plugin Files: 
These were [changed](https://goo.gl/obsbDC) to return custom Rainlab.Blog post results *containing the category* for correct URL creation. If either plugin is updated, ensure that the changes listed below remain unchanged to allow search functionality.


- `plugins/offline/sitesearch/classes/providers/RainlabBlogResultsProvider.php`
    - Edited `search` function just to check for `isInstalledAndEnabled` flag
        ```
        public function search() {
            if ( ! $this->isInstalledAndEnabled()) {
                return $this;
            }
        }
- `plugins/rainlab/blog/Plugin.php`
    - Added `use CustomBlogSearchProvider;`
    - Added `offline.sitesearch` listener to return custom provider
        ```
        Event::listen('offline.sitesearch.extend', function () {
             return new CustomBlogSearchProvider();
        });