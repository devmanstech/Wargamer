
<div class="row" style="margin-bottom: 15px;">
    <div class="col-lg-12">
        <label><?php echo get_phrase('select_roster'); ?></label>
        <select class="form-control selectboxit" name="<?php echo 'roster'; ?>" id="<?php echo 'roster'; ?>">

            <?php foreach($rosters as $roster){ ?>
                <option value="<?php echo $roster['id']; ?>"> <?php echo $roster['name'] ?> </option>
            <?php } ?>
        </select>
    </div>
</div>

<hr>
