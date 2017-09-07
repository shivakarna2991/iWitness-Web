<div class="form-group">
    <label for="phone" class="col-md-2 control-label">Billing Phone Number</label>
    <div class="col-md-7">
        <input type="text" name="originalPhone" class="wireless-phone required form-control"
               value="<?= $view_model['originalPhone'] ?>"
               placeholder="e.g. 12345678900"/>

        <div class="text-warning"></div>
    </div>
</div>

<?php if(!isset($view_model['iwitness_renew_nonce'])) $view_model['iwitness_renew_nonce'] = ''; ?>

<input type="hidden" name="iwitness_renew_nonce"
       value="<?php echo $view_model['iwitness_renew_nonce'] ?>"/>
<hr>

<button id="next" type="submit" class="btn btn-primary">Place order</button>