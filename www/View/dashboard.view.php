<h2>Good morning Admin 👋</h2>
<?php if($numberContents[0]["number"] <= 0) :?>
  <p>Your website doesn't have any article, you can create one by clicking on the button.</p>
<?php else : ?>
  <p>You have <?= $numberContents[0]["number"] ?> article(s) on your website.</p>
<?php endif; ?>
<div class="btn-container">
  <a href="/page-manager" class="button button--primary button--big">Add a page</a>
  <a href="/article-manager" class="button button--primary button--big">Add an article</a>
  <a href="/media-manager" class="button button--primary button--big">Add a media</a>
  <a href="/category-manager" class="button button--primary button--big">Add a category</a>
</div>
<div class="cards">
  <?php if($mostViewedArticle) :?>
    <div class="stat-card card">
      <div class="stat-card__top">
        <div class="stat-card__top__icon-container">
          <svg class="stat-card__top__icon-container__icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 19.2C17.7673 19.2 19.2 17.7673 19.2 16C19.2 14.2327 17.7673 12.8 16 12.8C14.2327 12.8 12.8 14.2327 12.8 16C12.8 17.7673 14.2327 19.2 16 19.2Z" fill="white" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.732422 16.0001C2.77122 9.50865 8.83571 4.79999 16 4.79999C23.1642 4.79999 29.2286 9.50859 31.2675 15.9999C29.2286 22.4913 23.1642 27.2 15.9999 27.2C8.83571 27.2 2.77126 22.4914 0.732422 16.0001ZM22.4 16C22.4 19.5346 19.5346 22.4 16 22.4C12.4654 22.4 9.60001 19.5346 9.60001 16C9.60001 12.4654 12.4654 9.59999 16 9.59999C19.5346 9.59999 22.4 12.4654 22.4 16Z" fill="white" />
          </svg>
        </div>
        <div class="stat-card__stat">
          <span class="stat-card__stat__title">Most viewed article</span>
          <span class="stat-card__stat__number"><?= $mostViewedArticle->title ?></span>
        </div>
      </div>
      <div class="stat-card__bottom">
        <div class="stat-card__stat">
          <span class="stat-card__stat__title">All time views</span>
          <span class="stat-card__stat__number"><?= $mostViewedArticle->clickedOn ?></span>
        </div>
        <div class="stat-card__stat">
          <span class="stat-card__stat__title">Subtitle</span>
          <span class="stat-card__stat__number"><?= $mostViewedArticle->subtitle ?></span>
        </div>
      </div>
    </div>
  <?php endif;?>
  <div class="chart-card">
    <div class="chart-card__desc">
      <span class="chart-card__desc__name">Total contents</span>
      <div class="chart-card__desc__data">
        <span class="chart-card__desc__data__number"><?=$numberContentsTotal?></span>
        <!-- <span class="chart-card__desc__data__trend chart-card__desc__data__trend__success">
          <span>12%</span>
          <svg class="chart-card__desc__data__trend__icon chart-card__desc__data__trend__icon__trend-up" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7C11.4477 7 11 6.55228 11 6C11 5.44772 11.4477 5 12 5H17C17.5523 5 18 5.44772 18 6V11C18 11.5523 17.5523 12 17 12C16.4477 12 16 11.5523 16 11V8.41421L11.7071 12.7071C11.3166 13.0976 10.6834 13.0976 10.2929 12.7071L8 10.4142L3.70711 14.7071C3.31658 15.0976 2.68342 15.0976 2.29289 14.7071C1.90237 14.3166 1.90237 13.6834 2.29289 13.2929L7.29289 8.29289C7.68342 7.90237 8.31658 7.90237 8.70711 8.29289L11 10.5858L14.5858 7H12Z" />
          </svg> -->
        </span>
      </div>

    </div>
    <div class="chart-card__chart">
    <canvas id="myChart" width="300" height="300"></canvas>
    </div>
  </div>
</div>

<script>
  const ctx = document.getElementById('myChart').getContext('2d');
  $data = [
    <?php foreach ($numberContents as $content) : ?>
      <?= $content['number'] ?>,
    <?php endforeach; ?>
  ];
  $label = [
    <?php foreach ($numberContents as $content) : ?> '<?= $content['name'] ?>',
    <?php endforeach; ?>
  ];
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: $label,
      datasets: [{
        label: 'number',
        data: $data,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>