# NEWSFEED UI UPDATE

## Changes applied
1. `userui/html/newsfeed.php`
- Updated the top navbar **Home** button to point to `newsfeed.php`.
  - This removes the unwanted “Homepage” screen from the feed flow.

2. `userui/html/homepage.php`
- Kept redirect to `newsfeed.php` (Home now always lands on the feed screen).

## Goal
- When user taps **Home**, they now stay on the **Newsfeed**/feed UI and can browse other people’s posts.


