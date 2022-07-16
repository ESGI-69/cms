<footer class="front-footer">
  <?php foreach ($footer as $footerElement) : ?>
    <a class="front-footer__item" href="/page?id=<?php echo $footerElement->id; ?>"><?php echo $footerElement->title; ?></a>
  <?php endforeach; ?>
  <a class="front-footer__item" href="/sitemap.xml">Sitemap</a>
</footer>