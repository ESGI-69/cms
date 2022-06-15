<form
  class="form <?= $view ?? '' ?> <?= $formErrors ?? 'no error' ?>"
  method="<?= $data["config"]["method"]??"POST" ?>"  action="<?= $data["config"]["action"]??"" ?>"
>

  <?php foreach ($data["inputs"] as $name=>$input) :?>

    <input
      type="<?= $input["type"]??"text" ?>"
      name="<?= $name?>"
      placeholder="<?= $input["placeholder"]??"" ?>"
      id="<?= $input["id"]??"" ?>"
      class="<?= $input["class"]??"" ?>"
      <?= empty($input["required"])?"":'required="required"' ?>
    >

  <?php endforeach;?>
  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" />
  <input class="button button--secondary" type="submit" value="<?= $data["config"]["submit"]??"Valider" ?>">

  <?php if ($success === false && !is_null($errors) && !empty($errors)) : ?>
    <?php foreach ($errors as $error) : ?>
      <div class="error">
        <?= $error ?>
      </div>
    <?php endforeach;?>
  <?php endif;?>
</form>
