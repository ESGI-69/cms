<div id="mySidebar" class="front-sidebar">
  <button aria-label="Close sidemenu" class="closebtn button button--primary" id="closebtn">&times;</button>
  <a class="front-sidebar__first" href="/categories">All Categories</a>
  <?php foreach ($sidebarFront as $sidebarElement) : ?>
    <a href="/page?id=<?= $sidebarElement->id; ?>"><?= $sidebarElement->title; ?></a>
  <?php endforeach; ?>
</div>

<script>
  const buttons = [
    document.getElementById('closebtn'),
    document.getElementById('burgerMenu'),
  ];
  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const mySidebar = document.getElementById('mySidebar');
      mySidebar.classList.toggle('front-sidebar--open');
    });
  });
</script>