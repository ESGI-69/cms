<?php if ($template === 'front') : ?>
  <form class="form <?= $view ?? '' ?> <?= $formErrors ?? 'no error' ?>" method="<?= $data["config"]["method"] ?? "POST" ?>" action="<?= $data["config"]["action"] ?? "" ?>" <?php if (isset($data["config"]["enctype"])) {
                                                                                                                                                                                echo 'enctype="' . $data["config"]["enctype"] . '"';
                                                                                                                                                                              } ?>>

    <?php foreach ($data["inputs"] as $name => $input) : ?>
      <?php if ($input["type"] === 'textarea') : ?>
        <textarea name="<?= $name ?>" id="<?= $input["id"] ?? $name ?>" class="<?= $input["class"] ?? "" ?>" placeholder="<?= $input["placeholder"] ?? "" ?>" <?= $input["required"] ?? false ? 'required' : '' ?> <?= $input["min"] ?? false ? 'minlength="' . $input["min"] . '"' : '' ?> <?= $input["max"] ?? false ? 'maxlength="' . $input["max"] . '"' : '' ?>><?= $input["value"] ?? "" ?></textarea>
      <?php else : ?>
        <input type="<?= $input["type"] ?? "text" ?>" name="<?= $name ?>" placeholder="<?= $input["placeholder"] ?? "" ?>" id="<?= $input["id"] ?? "" ?>" class="<?= $input["class"] ?? "" ?>" <?= empty($input["required"]) ? "" : 'required="required"' ?> <?php if (!empty($input["accept"])) : ?> accept="<?= $input["accept"] ?? "" ?>" <?php endif; ?> value="<?= $input["value"] ?? "" ?>">
      <?php endif; ?>

    <?php endforeach; ?>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" />
    <input class="button button--secondary" type="submit" value="<?= $data["config"]["submit"] ?? "Valider" ?>">

    <?php if ($success === false && !is_null($errors) && !empty($errors)) : ?>
      <?php foreach ($errors as $error) : ?>
        <div class="error">
          <?= $error ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </form>
<?php else : ?>
  <form id="form" class="cards <?= $view ?? '' ?> <?= $formErrors ?? 'no error' ?>" method="<?= $data["config"]["method"] ?? "POST" ?>" action="<?= $data["config"]["action"] ?? "" ?>" <?php if (isset($data["config"]["enctype"])) {
                                                                                                                                                                                          echo 'enctype="' . $data["config"]["enctype"] . '"';
                                                                                                                                                                                        } ?>>
    <!-- Le CSRF token -->
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" />
    <?php foreach ($data as $side => $sideContent) : ?>
      <!-- selection du coté gauche ou droit -->
      <?php if ($side === 'left' || $side === 'right') : ?>
        <div class="card <?= $side ?>">

          <!-- Boucle dans les groupes -->
          <?php foreach ($sideContent as $groupName => $groupContent) : ?>
            <?php if (!empty($groupContent["inputs"])) : ?>
              <!-- Group title -->
              <span class="group-title"><?= $groupName ?></span>
            <?php endif; ?>
            <?php foreach ($groupContent["inputs"] as $name => $input) : ?>
              <!-- Affichage d'un input avec son label -->
              <div class="input-label-group <?= $input['input-label-group-additional-class'] ?? "" ?>">
                <label for="<?= $name ?>"><?= $input['label'] ?? $name ?></label>
                <?php if ($input["type"] === 'select') : ?>
                  <!-- SELECT -->
                  <select name="<?= $name ?>" id="<?= $input["id"] ?? "" ?>">
                    <?php foreach ($input['options'] as $option) : ?>
                      <?php $selected = "" ?>

                      <?php
                      if (gettype($input["selected"]) === "integer") {
                        $input['selected'] = strval($input['selected']);
                      }
                      if ($option->id === $input["selected"]) {
                        $selected = "selected";
                      }

                      ?>

                      <option value="<?= $option->{$input['valueKey']} ?>" <?= $selected ?>><?= $option->{$input['labelKey']} ?></option>
                    <?php endforeach; ?>
                  </select>
                <?php elseif ($input["type"] === 'media') : ?>
                  <!-- MEDIA -->
                  <div class="media-selector">
                    <?php
                    $selectedMedia;
                    // find the selected media
                    foreach ($input['medias'] as $media) {
                      if ($input['value'] == $media->id) {
                        $selectedMedia = $media;
                      }
                    }
                    ?>
                    <img class="media-selector__preview" id="<?= $input["id"] . "-img" ?>" src="<?= array_slice($input['medias'], 0, 1)[0]->path ?>">
                    <select class="media-selector__select" name="<?= $name ?>" id="<?= $input["id"] ?? "" ?>">
                      <?php foreach ($input['medias'] as $media) : ?>
                        <?php $selected = "" ?>
                        <?php
                        if ($media->id === $selectedMedia->id) {
                          $selected = "selected";
                        }
                        ?>
                        <option value="<?= $media->id ?>" <?= $selected ?>><?= $media->name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <script>
                    const medias = <?= json_encode($input['medias']) ?>;
                    document.querySelector('#<?= $input["id"] ?>').addEventListener('change', function(event) {
                      // Replace the image src with selected media
                      document.querySelector('#<?= $input["id"] ?>-img').src = medias.find(media => media.id === event.target.value).path;
                    });
                  </script>
                <?php else : ?>
                  <?php if ($input["type"] === 'wysiwyg') : ?>
                    <script>
                      const beforeSumbit = (event) => {
                        event.preventDefault();
                        // Send the content of the wysiwyg to the hidden input
                        tinymce.triggerSave();
                        document.querySelector('#form').requestSubmit();
                      };
                    </script>
                  <?php endif; ?>
                  <!-- INPUT -->
                  <input type="<?= $input["type"] ?? "text" ?>" name="<?= $name ?>" placeholder="<?= $input["placeholder"] ?? "" ?>" id="<?= $input["id"] ?? "" ?>" class="<?= $input["class"] ?? "" ?>" <?= empty($input["required"]) ? "" : 'required="required"' ?> value="<?= html_entity_decode($input["value"]) ?? '' ?>" <?= empty($input["accept"]) ? "" : 'accept="' . $input["accept"] . '"' ?>>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php endforeach; ?>

          <?php if ($side === 'left') : ?>
            <!-- Boutton de validation -->
            <div class="actions">
              <input onclick="beforeSumbit(event)" class="button button--primary button--big" type="submit" value="<?= $data["config"]["submit"] ?? "Valider" ?>">
            </div>
          <?php endif ?>

          <?php if (isset($errors) && $side === 'left') : ?>
            <?php foreach ($errors as $error) : ?>
              <div class="error">
                <?= $error ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </form>
<?php endif ?>