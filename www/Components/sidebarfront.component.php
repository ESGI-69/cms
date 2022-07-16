<div id="mySidebar" class="front-sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#">All Categories</a>
  <?php foreach($sidebarFront as $sidebarElement)  : ?>
    <a href="/page?id=<?= $sidebarElement->id; ?>"><?= $sidebarElement->title; ?></a>
  <?php endforeach; ?>
</div>

<script>
  function openNav() {
    document.getElementById("mySidebar").classList.add("front-sidebar--open");
  }

  function closeNav() {
    document.getElementById("mySidebar").classList.remove("front-sidebar--open");
  }
</script>