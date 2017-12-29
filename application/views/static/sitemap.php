<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">
 <sitemap>
    <loc><?php base_url();?></loc>
    <lastmod>2014-02-07</lastmod>
 </sitemap>
 <?php foreach($data as $url) { ?>
	<sitemap>
		<loc><?php $url;?></loc>
		<lastmod>2014-02-07</lastmod>
	 </sitemap>
 <?php } ?>
</sitemapindex>
