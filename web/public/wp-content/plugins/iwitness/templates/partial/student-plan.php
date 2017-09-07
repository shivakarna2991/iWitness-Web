<h3>Step 3) Choose your preferred program</h3>

<div class="form-horizontal">
    <h5 class="text-uppercase-transform">Special Student Pricing</h5>
    <div class="form-group">
        <div class="col-md-10 col-md-offset-2">
            <label class="control-label" for="plan">
                <input type="radio" id="plan" name="plan" value="student"
                       class="required" checked="checked"
                       aria-required="true">
                <span class="price" id="price">$<?= $plans['student']['price'] ?></span>
                <span>One year (Per Person)  Subscription (<strong>normally $<?= $plans['year']['price'] ?></strong>)</span>
            </label>
            <label for="plan" class="error" style="display:none;">Please choose your plan</label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Promo Code</label>
        <div class="col-md-7">
            <input type="text" name="promoCode" id="promoCode" class='form-control required'
                   value="<?= $view_model['promoCode'] ?>">
            <p class="help-block">
                Must be a current student.
            </p>
        </div>
    </div>
</div>

<hr>