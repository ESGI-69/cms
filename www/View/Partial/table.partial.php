<!-- Table partial -->
<?php if (empty($data['data'])) : ?>
  <div class="container-table">
    <table class="container-table__table">
      <thead class="container-table__table__header">
        <tr class="container-table__table__header__tr">
          <th class="container-table__table__header__tr__th">/</th>
        </tr>
      </thead>
      <tbody class="container-table__table__body">
        <tr class="container-table__table__body__tr">
          <td class="container-table__table__body__tr__td">Pas de données à afficher</td>
        </tr>
      </tbody>
    </table>
  </div>
<?php else : ?>
  <div class="container-table">
    <table class="container-table__table">
      <thead class="container-table__table__header">
        <tr class="container-table__table__header__tr">
          <?php foreach (get_object_vars($data['data'][0]) as $columnName => $content) : ?>
            <th class="container-table__table__header__tr__th"><?= $columnName ?></th>
          <?php endforeach; ?>
          <?php if ($data['config']['editButton'] === true) : ?>
            <th class="container-table__table__header__tr__th">Editer</th>
          <?php endif; ?>
          <?php if ($data['config']['deleteButton'] === true) : ?>
            <th class="container-table__table__header__tr__th">Supprimer</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody class="container-table__table__body">
        <?php foreach ($data['data'] as $row) { ?>
          <tr class="container-table__table__body__tr">
            <?php foreach (get_object_vars($row) as $column) : ?>
              <td class="container-table__table__body__tr__td">
                <?php
                $column = substr(strip_tags(html_entity_decode(html_entity_decode($column))), 0, 100);
                $ellipsis = strlen($column) >= 100 ? '...' : '';
                ?>
                <?= $column . $ellipsis ?>
              </td>
            <?php endforeach; ?>
            <?php if ($data['config']['editButton'] === true) : ?>
              <td class="container-table__table__body__tr__td">
                <a href="<?= $data['config']['editUrl'] ?>?id=<?= $row->id ?>">
                  Editer
                </a>
              </td>
            <?php endif; ?>
            <?php if ($data['config']['deleteButton'] === true) : ?>
              <td class="container-table__table__body__tr__td">
                <a href="<?= $data['config']['deleteUrl'] ?>?deletedId=<?= $row->id ?>">
                  Supprimer
                </a>
              </td>
            <?php endif; ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>