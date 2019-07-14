
    {{csrf_field()}}
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="branch_name">
            Branch Name
        </label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="branch_name" name="branch_name" value="{{$model->branch_name}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="parent_branch">Parent Branch</label>
        <select name="parent_branch" id="parent_branch" class="form-control mr-sm-2 mb-sm-0"  value="{{$model->parent_branch}}" onload="selectedOption(this)">
            <option value="">Please select a branch</option>
            {!! $parentBranch ?? null !!}
        </select>
    </div>

    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="mobile">Mobile</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="mobile" name="mobile"  value="{{$model->mobile}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="email">Email</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="email" name="email"  value="{{$model->email}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="address">Address</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="address" name="address"  value="{{$model->address}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="emergency_mobile">Emergency Mobile</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="emergency_mobile" name="emergency_mobile"  value="{{$model->emergency_mobile}}">
    </div>

