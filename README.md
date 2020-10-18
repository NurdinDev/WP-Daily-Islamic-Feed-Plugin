# Daily Islamic Feed #
**Tags:** Islamic feed, Ramadan, Ayat, Hadith  
**Requires at least:** 4.5  
**Tested up to:** 5.5.1  
**Requires PHP:** 5.6  
**Stable tag:** 0.1.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

A WordPress Plugin that Adds a new post type for Islamic content and adds a new REST-API to get daily posts randomly or by scheduled time like Ramadan feed.
For now, it's just a rest API plugin later I'll add shortcodes and widget to show the data on the theme.

## Why I built this plugin? ##

During my daily work I've involved moving the CMS that [Quran Journey](http://app.quranjourney.co) use to WordPress, this app provides daily Islamic feeds in the inspiration section from Haith, Ayat, and Quote
- The easiest way to start is to create a custom field on each post to select the post type (Haith, Ayat, Quote) and `show/end date` if this post should show and ending a specific date, and fetch them as normal using default WordPress RestAPI.
	But I found it difficult to manage custom fields in WordPress, for example, if you decide to rename the field you should go to each post and rename it or use a custom SQL query to alter the field name directly on the database.
- The next solution for this, is to use the Advanced Custom Field plugin and Custom Post Type UI plugin, and this way working well.
	But in the frontend app, I need to make 4 requests to check if there are scheduled posts on a specific date and another 4 requests to get random feed if there is no schedule on the same date.
	so the app will make a lot of requests to fetch inspiration feed and in my opinion, that's a lot.
- My solution, I think if I create a single rest API route and manage everything on the server and return the final result to the user that will be awesome, but I don't have any experience in PHP and WordPress development 😅
	- What I solve?
		- A single request to fetch the daily feed in the inspiration section
		- A cache on each day that helps all users get the same random posts each day with less talk to the database
		- fast change and mange, if there is a new post type coming or some requirement changed like show us Ayat before Hadith in the page, instead of change this on the frontend and build IOS, and Android, publish the app and wait for hours and days,
			instead, it's just a small change in the plugin, and later I'll add a setting page to control the order and other stuff from the UI and manage the feed like a pro ;)


## Description ##

This plugin adds:

- `Haith` `Ayat` and `Names Of Allah` as a new post type under the Inspiration menu.
- `schedule` as a taxonomy to group posts on a specific schedule
	- for example if you want to show a specific Post or Haith you can create a new schedule for Ramadan and select the start and end date range on the schedule page.
- After you activate this plugin you have access to a new GET RestAPI called `today` following by the date as a parameter like this `wp-json/dif/v1/today/day/month/year`.
	- this API returns a single daily feed from each type `Hadith` `Ayat` `Names Of Allah` and `Post`.
	- example:
		- curl http://localhost:8888/wp-json/dif/v1/today/06/10/2020
		- the response:
		```json
		[
			{
				"id": 5,
				"date": "2020-10-17 19:58:59",
				"date_gmt": "2020-10-17 19:58:59",
				"modified": "2020-10-17 19:58:59",
				"modified_gmt": "2020-10-17 19:58:59",
				"slug": "ayha-1",
				"status": "publish",
				"type": "ayah",
				"link": "http://localhost:8888/ayah/ayha-1/",
				"title": {
				"rendered": "ayha 1"
				},
				"content": {
				"rendered": ""
				},
				"excerpt": {
				"rendered": ""
				},
				"author": 1,
				"featured_image": {
				"thumbnail": false,
				"medium": false,
				"large": false
				},
				"sticky": false
			},
			{
				"id": 7,
				"date": "2020-10-17 19:59:19",
				"date_gmt": "2020-10-17 19:59:19",
				"modified": "2020-10-17 19:59:19",
				"modified_gmt": "2020-10-17 19:59:19",
				"slug": "hadith-2",
				"status": "publish",
				"type": "hadith",
				"link": "http://localhost:8888/hadith/hadith-2/",
				"title": {
				"rendered": "hadith 2"
				},
				"content": {
				"rendered": ""
				},
				"excerpt": {
				"rendered": ""
				},
				"author": 1,
				"featured_image": {
				"thumbnail": false,
				"medium": false,
				"large": false
				},
				"sticky": false
			},
			{
				"id": 9,
				"date": "2020-10-17 19:59:39",
				"date_gmt": "2020-10-17 19:59:39",
				"modified": "2020-10-17 19:59:39",
				"modified_gmt": "2020-10-17 19:59:39",
				"slug": "name-2",
				"status": "publish",
				"type": "names-of-allah",
				"link": "http://localhost:8888/names-of-allah/name-2/",
				"title": {
				"rendered": "name 2"
				},
				"content": {
				"rendered": ""
				},
				"excerpt": {
				"rendered": ""
				},
				"author": 1,
				"featured_image": {
				"thumbnail": false,
				"medium": false,
				"large": false
				},
				"sticky": false
			},
			{
				"id": 1,
				"date": "2020-10-15 11:08:26",
				"date_gmt": "2020-10-15 11:08:26",
				"modified": "2020-10-15 11:08:26",
				"modified_gmt": "2020-10-15 11:08:26",
				"slug": "hello-world",
				"status": "publish",
				"type": "post",
				"link": "http://localhost:8888/hello-world/",
				"title": {
				"rendered": "Hello world!"
				},
				"content": {
				"rendered": "\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n"
				},
				"excerpt": {
				"rendered": ""
				},
				"author": 1,
				"featured_image": {
				"thumbnail": false,
				"medium": false,
				"large": false
				},
				"sticky": false
			}
		]
		```


### Note:
- The random posts are saved in a cache in order to get the same random sequence for all users daily.
- If there is no schedule in the selected date range you will see random posts from all types.

you can stick a post on the top by checking the `sticky` option inside the post setting.


## Installation ##

1. Upload `daily-islamic-feed` directory or clone the repo to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

## development ##
I use to use wp-env in my development so this is fast and awesome way to start fast.
Note: make sure you have docker

1. clone the repo
2. `cd daily-islamic-feed`
3. `wp-env start`
4. now open `http://localhost:8888` 👏🏻


## Screenshots ##

### 1. This is the Inspiration menu contains custom post type. ###
![This is the Inspiration menu contains custom post type.](http://ps.w.org/daily-islamic-feed/assets/screenshot-1.png)

### 2. This is the schedule taxonomy under posts. ###
![This is the schedule taxonomy under posts.](http://ps.w.org/daily-islamic-feed/assets/screenshot-2.png)

### 3. This is when you add new schedule and selecte show and end date using daterange input. ###
![This is when you add new schedule and selecte show and end date using daterange input.](http://ps.w.org/daily-islamic-feed/assets/screenshot-3.png)

