# Business Comparison Knowledge Hub

## Installation

Run `composer install` in the root directory

## Edited Plugin Files:
These were changed to return custom Rainlab.Blog post results _containing the category_ for correct URL creation. If either plugin is updated, ensure that the changes listed below remain unchanged to allow search functionality.

- `plugins/offline/sitesearch/classes/providers/RainlabBlogResultsProvider.php`
    - Edited `search` function just to check for `isInstalledAndEnabled` flag
- `plugins/rainlab/blog/Plugin.php`
    - Added `use CustomBlogSearchProvider`
    - Added `offline.sitesearch` listener to return custom provider