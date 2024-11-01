=== tradetracker affiliates ===
Contributors: Peter Scheepens, wordpressprogrammeurs.nl, owagu, digidownload.nl
Donate link: http://portaljumper.com/
Tags: affiliate,tradetracker,shop,builder,datafeed
Requires at least: 3.4
Tested up to: 3.4
Stable tag: 1.7
License: GPLv2 or later

Automatically convert tradetracker datafeeds into live and dynamic wordpress shop pages

== Description ==
This plugin will take your tradetracker affiliate ID, contact the affiliate network, present you with 1000's of merchant feeds, and lets you select one. 
Then it instantly turns this feed into a dynamic wordpress shopping page. Use the keyword limiter to only show products that contain your keyword.
Build one, or build 100 ! No extra load on your database and products are updated automatically. Great for SEO too, all products embed in the page.

= Live Demo =
see http://tradetracker.portaljumper.com for several live demo's

= features =
	. automatic product updates
	. keyword selection for niche stores
	. short-code support for posts,pages,widgets and PHP
	. over 40.000.000 products to promote
	. extremely user-friendly and fast

This plugin will contact the linksalt.com servers to get the latest descriptions, images and pricing on the products
that you selected. 
Linksalt.com retrieves this information from all the associated affiliate networks and updates product information
on a frequent basis. (Sometimes up to 12 x per day).
On every page-load the latest information is fetched so your shopping page products are always up-to-date. You also never have to
worry about penalties from your merchants again for advertising wrong prices and/or product descriptions ( e.g. German
networks and merchants are very strict with that, other merchants are following suit).

Need other affiliate networks ?
Download them free from http://portaljumper.com
You can also get the free affiliate suite 'feedmonster for wordpress' which incorporates this plugin alongside other networks.
	
== Installation ==
install and activate the plugin. Then visit SETTINGS tab in the admin panel.

Our plugins are all built around the user-friendly shortcodes in WordPress. A shortcode is a ‘command’ enclosed in square brackets that executes certain functions. For our affiliate plugins we have developed shortcode as follows  (Square brackets are replaced by standing bars | to show example)

|tt_affi_code search=jeans net=tradetracker layout=layout3 feed=Wehkamp_nl_Mode count=6 ident=65027 |

shortcode can be used in POSTS, in PAGES, inside WIDGETS, and even in PHP like so : < ?php echo do_shortcode( ’ [tt_affi_code net=tradetracker layout=layout5 feed=Wehkamp_nl_Mode count=6 ident=65027 ] ’) ?>

code explained:

tt_affi_code  ->  the code to call upon our functions. This is how the correct shortcode handler is targeted

search=jeans  -> Using our search capabilities, only products that contain a certain keyword will be shown

net=tradetracker -> calls the correct affiliate network

layout=layout3 -> selects the preferred layout

feed=Wehkamp_nl_Mode -> tells the system which merchant or store to get products from

count=6 -> the amount of products you want shown in your store (high values > 40 will slow your site down)

ident=65027 -> the affiliate ID that you want to use for the links

== Frequently Asked Questions ==
= Can I earn with this ? =
Absolutely ! We've been around since 2008 and use these plugins ourselves daily to generate our income !

= How do I use the shortcode to put items in sidebars or posts ? =
See "installation" tab for shortcode information.