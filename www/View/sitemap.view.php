<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<!-- List des articles -->
<?php foreach ($articles as $article): ?>
  <url>
    <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/article?id=<?= $article->id ?></loc>
    <lastmod><?= $article->updatedAt ?? $article->createdAt ?></lastmod>
    <changefreq>daily</changefreq>
  </url>
<?php endforeach; ?>
<!-- List des pages -->
<?php foreach ($pages as $page): ?>
  <url>
    <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/page?id=<?= $page->id ?></loc>
    <lastmod><?= $page->updatedAt ?? $page->createdAt ?></lastmod>
    <changefreq>daily</changefreq>
  </url>
<?php endforeach; ?>
<!-- List des categories -->
<?php foreach ($categories as $category): ?>
  <url>
    <loc>http://<?= $_SERVER['SERVER_NAME'] ?>/category?id=<?= $category->id ?></loc>
    <changefreq>daily</changefreq>
  </url>
<?php endforeach; ?>
<!-- List des pages statics -->
<?php foreach ($staticUrls as $url => $config): ?>
<?php if (
  $url !== "/sitemap.xml"
  && $url !== "/article"
  && $url !== "/page"
  && !isset($config['security'])
) : ?>
  <url>
    <loc>http://<?= $_SERVER['SERVER_NAME'] ?><?= $url ?></loc>
  </url>
<?php endif; ?>
<?php endforeach; ?>
</urlset>
