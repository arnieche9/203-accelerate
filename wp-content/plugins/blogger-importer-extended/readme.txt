=== Plugin Name ===
Contributors: pipdig
Tags: blogger, blogspot, importer
Requires at least: 4.4
Tested up to: 5.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Import posts, pages, tags, comments, images and links from your Blogger blog.

== Description ==

Blogger Importer Extended is the easiest way to import your posts, pages, tags, comments, images and authors from **Blogger to WordPress**.

Blogger Importer Extended can:

* Import posts
* Import pages
* Import tags/labels
* Import comments
* Import images
* Import links
* Import/assign authors
* Convert formatting
* Preserve slugs

= Notes =

1. Due to Google APIs daily quota limitations the importer can be unavailable, try later.
2. Due to Google policies, the Blogger API v3 can only be accessed by approved web services. This means you will need to connect to Blogger via your Google account, which is passed through our app at https://bloggerimporter.pipdig.rocks/api. This is for your own protection (the app is audited and approved by Google) and we do not have access to your private/personal information. The only data which is processed by the app is a disposable access token.

= Privacy and GDPR =

This plugin requires a connection to your [Blogger](https://www.blogger.com) account via the [Google Blogger API](https://developers.google.com/blogger/). Pipdig Ltd, the creator of this plugin, does not gather or store any personal information, nor do we claim any responsibility for the data controlled by your Google account or website. Any data transferred between the Blogger API v3 and your WordPress website must comply with the applicable laws in your jurisdiction. By connecting your site to the Google Blogger API v3 you must accept Google's [Privacy Policy](https://policies.google.com/privacy).

== Installation ==

1. Install the plugin by going to the 'Plugins > Add New' section of your WordPress dashboard.
2. When the plugin is installed and active, click the "Run Importer" button. This can be found next to the plugin's name in the "Plugins" page of your dashboard.
3. Connect to your Blogger account. Select the blog you want to import.
4. Sit back and relax. The import will now do the work for you :)

== Frequently Asked Questions ==

= The importer stopped unexpectedly, why? =
The importer can stop for several reasons, most frequently reasons are:

* Restart: when you refresh the browser page 2 or more import processes can be together active, so, BIE waits for the first one finish its work.
* Timeout: the browser, a proxy, or something else, breaks the import process for some reason, usually a timeout.
* Quota exceeded: BIE uses the Google Blogger APIs, these grant a limited number of requests per day and per second, if the quota is exceeded, the importer stops.

== Screenshots ==

1. Authorization
2. Blog list
3. Importing
4. Author assignment

== Changelog ==

= 1.3.3 =
* Update GDPR section in plugin description.

= 1.3.2 =
* Don't strip span tags.

= 1.3.1 =
* Improvements on formatting conversion

= 1.2.2 =
* Fix for page comments

= 1.2.1 =
* Fix for unexpected timeout

= 1.2 =
* Fix for alert loop
* Workaround for imprecision in denormalized counters

= 1.1 =
* Fix for posts without slug