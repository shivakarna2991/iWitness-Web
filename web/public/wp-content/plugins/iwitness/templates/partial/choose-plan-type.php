<div class="well supported-devices">
    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-3">
            <label class="control-label">
                
                <input type="radio" name="plan-type" id="individual" value="individual"
                   class="required" <?= $view_model['originalPlan'] == 'individual' ? 'checked' : '' ?>  onclick="return setStep3();"/>
								<span class="price">Individual User Plan</span>
            </label>
        </div>


        <div class="col-xs-12 col-sm-6 col-md-3">
            <label class="control-label">
                <input type="radio" name="plan-type" id="family" value="family"
                   class="required" <?= $view_model['originalPlan'] == 'family' ? 'checked' : '' ?> onclick="return setStep3();" />
								<span class="price">Family/Group Plan</span>
            </label>
        </div>


        <label for="phone_model" class="error" style="display:none">Please choose your plan</label>

    </div>
</div>
