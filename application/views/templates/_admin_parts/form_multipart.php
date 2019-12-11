<?php echo (!isset($detail)) ? form_open_multipart($form_action) : null; ?>
<?php foreach ($form_data as $key => $value) : ?>
  <?php if ($value['type'] != 'hidden') : ?>
    <div class="col-sm-12">
      <?php if ($value["type"] == "file") : ?>
        <div class="row clearfix">
          <div class="col-lg-1 col-md-1 col-sm-2 col-xs-4 form-control-label">
            <label for="<?php echo $value['name']?>" style="font-weight: normal"><?php echo ucfirst($value['placeholder'])?></label>
          </div>
          <div class="col-lg-11 col-md-11 col-sm-10 col-xs-8">
            <div class="form-group">
              <div class="form-line">
                <?php echo form_input($value); ?>
              </div>
            </div>
          </div>
        </div>
      <?php else : ?>
        <div class="form-group form-float">
          <div class="form-line">
            <?php
                  switch ($value['type']) {
                    case 'select':
                      $label =  $value['placeholder'];
                      $options =  $value['option'];
                      $name = $value['name'];
                      $selected = $value['value'];
                      unset($value['placeholder']);
                      unset($value['option']);
                      unset($value['name']);
                      echo "<p' class='text-mute'>" . ucfirst($label) . "</p>";
                      echo form_dropdown($name, $options, $selected, $value);
                      break;
                    case 'textarea':
                      $label =  $value['placeholder'];
                      unset($value['placeholder']);
                      echo "<p text-mute'>" . ucfirst($label) . "</p><br>";
                      echo form_textarea($value);
                      break;
                    default:
                      $label =  $value['placeholder'];
                      unset($value['placeholder']);
                      echo "<label class='form-label'>" . ucfirst($label) . "</label>";
                      echo form_input($value);
                      break;
                  }
                  ?>
          </div>
        </div>
      <?php endif ?>
    </div>
  <?php else : ?>
    <?php
        $name = $value['name'];
        $val = $value['value'];
        echo form_hidden($name, $val);
        ?>
  <?php endif; ?>

<?php endforeach; ?>
<?php if (!isset($detail)) : ?>
  <div class="col-sm-12 ">
    <button type="clear" class="btn float-left btn-warning waves-effect">Clear</button>
    <button type="submit" class="btn float-left btn-primary waves-effect">Simpan</button>
  </div>
  <?php echo form_close(); ?>
<?php endif; ?>