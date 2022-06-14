<span class="username">Bonjour <?= $userInfos["firstname"] ?? 'étranger' ?> 👋 </span>
<span class="question">Que veux tu apprendre aujourd'hui ?</span>
<form class="search" action="search.php" method="get">
  <input class="input" type="text" name="search" placeholder="Rechercher un article" />
  <button class="button button--primary button--big" type="submit">Search</button>
</form>