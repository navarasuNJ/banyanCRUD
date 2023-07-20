@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Supplier</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('supplier.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Supplier Code <span class="text-danger">*</span></label>
                                <input type="text" name="supplier_code" id="supplier_code" class="form-control" value="{{ $code }}" readonly/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Supplier Group <span class="text-danger">*</span></label>
                                <input type="text" name="supplier_group" id="supplier_group" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" id="company_name" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Address 1 <span class="text-danger">*</span></label>
                                <input type="text" name="address1" id="address1" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Addreres 2</label>
                                <input type="text" name="address2" id="address2" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-control" name="country" id="country" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}" data-iso2="{{ $country->iso2 }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <select class="form-control" name="state" id="state" required>
                                    <option value="">Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <select class="form-control" name="city" id="city" required>
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email_id" id="email_id" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="mobile_number" id="mobile_number" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Website URL</label>
                                <input type="text" name="website_url" id="website_url" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Credit Period <span class="text-danger">*</span></label>
                                <input type="text" name="credit_period" id="credit_period" class="form-control" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">GST <span class="text-danger">*</span></label>
                                <br>
                                <input type="radio" name="gst" value="Yes" required/> Yes
                                <input type="radio" name="gst" value="No" checked="checked" required/> No
                            </div>
                        </div>
                        <div class="col-md-4" id="gst_field">
                        </div>
                    </div>
                    <hr/>
                    <p><b>Contact Details ( <input type="checkbox" id="hide"/> Hide )</b></p>
                    <div class="table-response" id="cont" name="chk">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>Salutation <span class="text-danger">*</span></th>
                                    <th>Name <span class="text-danger">*</span></th>
                                    <th>Designation <span class="text-danger">*</span></th>
                                    <th>Department</th>
                                    <th>Email <span class="text-danger">*</span></th>
                                    <th>Mobile</th>
                                    <th>Profile Picture</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    <td><input type="text" class="form-control" name="salutation[]" required/></td>
                                    <td><input type="text" class="form-control" name="name[]" required/></td>
                                    <td><input type="text" class="form-control" name="designation[]" required/></td>
                                    <td><input type="text" class="form-control" name="department[]"/></td>
                                    <td><input type="email" class="form-control" name="email[]" required/></td>
                                    <td><input type="text" class="form-control" name="mobile[]"/></td>
                                    <td><input type="file" class="form-control" name="profile_picture[]"/></td>
                                    <td> <a class="btn btn-primary" onclick="add(this)" href="javascript:;">+</a> <a class="btn btn-danger" onclick="rmv(this)" href="javascript:;">-</a> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br/><br/>
                    <div><a class="btn btn-secondary" href="{{ route('supplier.index') }}">Back to List</a> <span style="float:right"><input type="submit" value="Submit" class="btn btn-primary"/></span></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#country').change(function(){
            var iso2=$(this).find(':selected').attr('data-iso2');
            $.ajax({
                type: "get",
                url: '/states/'+iso2,
                success: function(data)
                {
                    $('#state').html(data);
                }
            });
        });

        $('#state').change(function(){
            var iso2=$('#country').find(':selected').attr('data-iso2');
            var ciso2=$(this).find(':selected').attr('data-iso2');
            $.ajax({
                type: "get",
                url: '/cities/'+iso2+'/'+ciso2,
                success: function(data)
                {
                    $('#city').html(data);
                }
            });
        });

        $('input[name=gst]').change(function(){
            var gst=$(this).val();
            if(gst=="Yes"){
                $('#gst_field').html('<div class="form-group"><label class="form-label">GST Number <span class="text-danger">*</span></label><input type="text" name="gst_number" id="gst_number" class="form-control" required/></div>');
            }else{
                $('#gst_field').html('');
            }
        });

        $('input[name=chk]').change(function(){
            var atLeastOneIsChecked = $('input[name=chk]:checked').length > 0;
            if(atLeastOneIsChecked){
                $('#cont').hide();
            }
        });
    });

    function add(row)
    {
        var ss = $(row).parent().parent().html();
        console.log(ss);
        $('#tbody').append('<tr>'+ss+'</tr>');
    }

    function rmv(row)
    {
        $(row).parent().parent().remove();
    }
</script>
@endsection
