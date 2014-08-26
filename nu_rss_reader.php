<?php

function get_rss_feed() {

	$tag = get_tag();

	$url = "http://www.nu.nl/feeds/rss/$tag";
	$xml_object = simplexml_load_file($url);
	
	$articles = array();

	foreach ($xml_object->channel->item as $item) {

		$related = array();
		
		$related_items = $item->related->a;
		if (isset($related_items)) {
			for ($i = 0; $i < count($related_items); $i++) {
				$related[$i]['url'] = xml_attribute($related_items[$i], 'href');
				$related[$i]['title'] = (string)$related_items[$i];
			}
		}

		$articles[] = array(
			'title' => (string)$item->title,
			'url' => (string)$item->link,	
			'newtime' => format_date((string)$item->pubDate),
			'category' => (string)$item->category,
			'description' => (string)$item->description,
			'image' => xml_attribute($item->enclosure, 'url'),
			'related' => $related,
		);
		
	}

	return $articles;
}

function get_options() {

	$categories = array(
		'algemeen.rss' => "Algemeen",
		'economie.rss' => "Economie",
		'sport.rss' => "Sport",
		'tech.rss' => "Tech",
		'internet.rss' => "Internet",
		'achterklap.rss' => "Achterklap",
		'opmerkelijk.rss' => "Opmerkelijk",
		'film.rss' => "Film",
		'boek.rss' => "Boek",
		'wetenschap.rss' => "Wetenschap",
		'gezondheid.rss' => "Gezondheid",
		'auto.rss' => "Auto",
	);
	
	return $categories;
}

function get_tag() {
	
	if (isset($_GET["tag"])) {
		$tag=$_GET["tag"];
	} else {
		$tag="algemeen.rss";
	}
	
	return $tag;
	
}

function xml_attribute($object, $attribute) {

    if(isset($object[$attribute])) {
        return (string) $object[$attribute];
	}
}

function format_date($timestring) {
	
	$timestamp = strtotime($timestring);
	$output_time = date('G:i \o\n l jS F Y', $timestamp);
	return $output_time;
}

?>
