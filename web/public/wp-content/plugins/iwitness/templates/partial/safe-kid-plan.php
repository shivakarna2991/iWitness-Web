<h3>Step 3) Choose your preferred program</h3>

<div class="form-horizontal">
    <h5 class="text-uppercase-transform">Special boys & girls clubs pricing</h5>
    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <label class="control-label" for="plan">
                <input type="radio" id="plan" name="plan" value="safekidyear"
                       class="required" <?= ($view_model['plan'] == 'safekidyear' ? 'checked="checked"' : '') ?> aria-required="true">
                <span class="price" id="price">$<?= $plans['safekidyear']['price'] ?></span>
                <span>One year ( Per Person)  subscription (<strong>normally $<?=  $plans['year']['price'] ?></strong>)</span>
            </label>
            <label for="plan" class="error" style="display:none;">Please choose your plan</label>
            <p class="help-block">
                For every subscription purchased, iWitness will make a $10 donation to Boys & Girls Clubs of King County.
            </p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="promoCode">Promo Code </label>
        <div class="col-md-7">
            <input type="text" name="promoCode" id="promoCode" class="required form-control" value="<?= $view_model['promoCode'] ?>">
            <p class="help-block">Must be the parent of a Boys & Girls Club member to purchase.)</p>
        </div>
    </div>
</div>

<hr>