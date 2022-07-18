<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<!-- List des articles -->
<?php foreach ($articles as $article): ?>
  <url>
    <loc>https://wikiki.timdev0.com/article?id=<?= $article->id ?></loc>
    <lastmod><?= $article->updatedAt ?? $article->createdAt ?></lastmod>
    <changefreq>daily</changefreq>
  </url>
<?php endforeach; ?>
<!-- List des pages -->
<?php foreach ($pages as $page): ?>
  <url>
    <loc>https://wikiki.timdev0.com/page?id=<?= $page->id ?></loc>
    <lastmod><?= $page->updatedAt ?? $page->createdAt ?></lastmod>
    <changefreq>daily</changefreq>
  </url>
<?php endforeach; ?>
<!-- List des categories -->
<?php foreach ($categories as $category): ?>
  <url>
    <loc>https://wikiki.timdev0.com/category?id=<?= $category->id ?></loc>
    <changefreq>daily</changefreq>
  </url>
<?php endforeach; ?>
<!-- List des pages statics -->
<?php foreach ($staticUrls as $url => $config): ?>
<?php if (
  $url !== "/sitemap.xml"
  && $url !== "/article"
  && $url !== "/page"
  && $url !== "/install"
  && !isset($config['security'])
) : ?>
  <url>
    <loc>https://wikiki.timdev0.com<?= $url ?></loc>
  </url>
<?php endif; ?>
<?php endforeach; ?>
</urlset>
