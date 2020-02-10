
<div class="container">
    {form_open('','class="form-signin" autocomplete="something-new"')}
    <div class="row">
        <div class="col-12 col-md-3 d-flex justify-content-center">
            <div>
                <div>
                    <span class="small text-muted">Inscrit depuis le 10/02/2020</span>
                </div>

                <img class="w-100 img-fluid" src="{base_url('uploads/avatar/default.jpg')}" alt="">
                <div class="custom-file">
                    <input type="file" class="form-control-file " accept="image/png, image/jpeg" id="inputAvatar">
                </div>

            </div>

        </div>

        <div class="col-12 col-md-9">

            <div class="form-row">

                {foreach from=$inputArray item=arrGroup}
                    <div class="form-group col-12 col-md-6">
                        {foreach from=$arrGroup item=item}
                            {$item}
                        {/foreach}
                    </div>
                {/foreach}

                <div class="form-group col-12 col-md-6">
                    <label for="inputEmail" class="small text-muted" >Sexe</label>
                    <select id="inputGender" name="gender" class="form-control">
                        <option></option>
                        <option value="1">Homme</option>
                        <option value="2">Femme</option>
                    </select>
                </div>


            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn bn_btn-green">MODIFIER</button>

            </div>


        </div>

    </div>
    {form_close()}
    <div class="bn_gap-100"></div>
</div>
