@extends('admin.layouts.app')

@section('pagetitle')
    Add a Dentist
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .inner{
            max-height: 200px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0168fa !important;
            color: #fff !important;
        }

        .select2-selection__choice__remove {
            color: #fff !important;
        }

        .select2-selection__choice__remove:hover {
            color: black !important;
        }    
    </style>
    
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add a Dentist</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Add a Dentist</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('dentists.store') }}" method="post">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label class="d-block">First Name *</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name')}}" class="form-control @error('first_name') is-invalid @enderror" required>
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Last Name *</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name')}}" class="form-control @error('last_name') is-invalid @enderror" required>
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Clinic Name *</label>
                    <input type="text" name="clinic_name" id="clinic_name" value="{{ old('clinic_name')}}" class="form-control @error('clinic_name') is-invalid @enderror" required>
                    @error('clinic_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Region *</label>
                    <select name="region" id="region" class="selectpicker mg-b-5 @error('region') is-invalid @enderror" data-style="btn btn-outline-light btn-md btn-block tx-left" title="Select Region" data-width="100%" required>
                    </select>
                    @error('region')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Province *</label>
                    <select name="province" id="province" class="selectpicker mg-b-5 @error('province') is-invalid @enderror" data-style="btn btn-outline-light btn-md btn-block tx-left" title="Select Province" data-width="100%">
                    </select>
                    @error('province')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">City/Municipality *</label>
                    <select name="city" id="city" class="selectpicker mg-b-5 @error('city') is-invalid @enderror" data-style="btn btn-outline-light btn-md btn-block tx-left" title="Select City" data-width="100%" required>
                    </select>
                    @error('city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Full Address *</label>
                    <input type="text" name="full_address" id="full_address" value="{{ old('full_address')}}" class="form-control @error('full_address') is-invalid @enderror" required>
                    @error('full_address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Specialization *</label>
                     <select id="dentist-specialization" name="specialization[]" multiple="multiple" class="selectpicker mg-b-5 @error('specialization') is-invalid @enderror select2" data-style="btn btn-outline-light btn-md btn-block tx-left" title="Select specialization" data-width="100%" required>
                        @foreach($dentistSpecialties as $specialty)
                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                    @error('specialization')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Contact Number *</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number')}}" class="form-control @error('contact_number') is-invalid @enderror" required>
                    @error('contact_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save</button>
                <a class="btn btn-outline-secondary btn-sm btn-uppercase" href="{{ route('dentists.index') }}">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
      <script src="{{ asset('js/select2.min.js') }}"></script>
@endsection

@section('customjs')
    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
        
          $('#dentist-specialization').select2({
            minimumInputLength: 0,
        });

        getRegions();

        function getRegions(){
            $.ajax({
                type: 'GET',
                url: 'https://psgc.cloud/api/regions',
                success: function(response){
                    var options = '';
                    $.each(response, function(index, region) {
                        options += '<option value="' + region.name + '" data-code="'+region.code+'">' + region.name + '</option>';
                    });
                    $("#region").html(options).selectpicker('refresh');
                }
            });
        }

        function getProvinces(regionCode){
            $.ajax({
                type: 'GET',
                url: 'https://psgc.cloud/api/regions/'+regionCode+'/provinces',
                success: function(response){
                    var options = '';
                    $.each(response, function(index, province) {
                        options += '<option value="' + province.name + '" data-code="'+province.code+'">' + province.name + '</option>';
                    });
                    $("#province").html(options).selectpicker('refresh');
                    if(options == ''){
                        getCities(regionCode, 'regions');
                    }
                }
            });
        }

        function getCities(code_, type = 'provinces'){
            $.ajax({
                type: 'GET',
                url: 'https://psgc.cloud/api/'+type+'/'+code_+'/cities-municipalities',
                success: function(response){
                    var options = '';
                    $.each(response, function(index, city) {
                        options += '<option value="' + city.name + '" data-code="'+city.code+'">' + city.name + '</option>';
                    });
                    $("#city").html(options).selectpicker('refresh');
                }
            });
        }

        $('#region').change(function() {
            $("#province").html("").selectpicker('refresh');
            $("#city").html("").selectpicker('refresh');
            var selectedCode = $(this).find(':selected').data('code');
            getProvinces(selectedCode)
        });

        $('#province').change(function() {
            $("#city").html("").selectpicker('refresh');
            var selectedCode = $(this).find(':selected').data('code');
            getCities(selectedCode)
        });
    </script>
@endsection
