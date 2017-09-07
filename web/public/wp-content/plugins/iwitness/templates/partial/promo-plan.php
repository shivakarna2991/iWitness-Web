<h3>Step 3) Choose your preferred program</h3>

<div class="form-horizontal">
    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <label class="control-label" for="plan">
                <input type="hidden" value="promo" name="plan" id="plan">
                <span>Please enter your promotional code below.</span>
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Promo Code</label>
        <div class="col-md-7">
            <input type="text" name="promoCode" id="promoCode" class='form-control required'
                   value="<?= $view_model['promoCode'] ?>">
        </div>
    </div>
</div>

<hr>