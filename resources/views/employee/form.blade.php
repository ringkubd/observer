
    {{csrf_field()}}
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="branch_name">
            Client Name
        </label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="client_name" name="client_name" value="{{$model->client_name}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="contact_person">Contact Person</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="contact_person" name="contact_person" value="{{$model->contact_person}}">
    </div>

    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="mobile_no">Mobile</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="mobile_no" name="mobile_no"  value="{{$model->mobile_no}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="branch_id">Branch</label>
        <select class="form-control mr-sm-2 mb-2 mb-sm-0" name="branch_id" id="branch_id">
            <option value="">Select a branch</option>
            {!! $branch !!}
        </select>
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="code">Code</label>
        <input type="text" class="form-control mr-sm-2 mb-2 mb-sm-0" id="code" name="code"  value="{{$model->code}}">
    </div>
    <div class="form-group">
        <label class="mr-sm-2 mb-0" for="code_converter">Code Converter</label>
        <input type="checkbox" class="form-control mr-sm-2 mb-2 mb-sm-0" id="code_converter" name="code_converter" @if($model->code_converter) checked @endif  value="1">
    </div>


