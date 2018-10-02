<!--Part 2 of registration, complies with requirements-->

<!--Start additional input here-->
    <!--Company Field-->
    <div class="form-group row">
            <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>
            <div class="col-md-6">
                <input id="company" type="text" class="form-control" name="company" required>
            </div>
        </div>
        <!--Gender Field-->
        <div class="form-group row">
            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
            <div class="col-md-6">
                <label for="gender" class="radio-inline"><input id="gender" type="radio" name="gender" value ="f" required>Female</label>
                <label for="gender" class="radio-inline"><input id="gender" type="radio" name="gender" value="m" >Male</label>
            </div>
        </div>
        <!--Date of Birth Field-->
        <div class="form-group row">
            <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('DOB') }}</label>
            <div class="col-md-6">
                <input type="date" id="date_of_birth" class="form-control" name="date_of_birth" required>
            </div>
        </div>    
        
        <!--Buttons-->
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
        <!--End-->
    