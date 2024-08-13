@extends('admin.layouts.app')

@section('pagetitle')
    View Dentist
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Dentist</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">View Dentist</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form>
                <div class="form-group">
                    <label class="d-block">First Name *</label>
                    <input type="text" name="first_name" id="first_name" value="{{ $dentist->first_name }}" class="form-control @error('first_name') is-invalid @enderror" disabled>
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Last Name *</label>
                    <input type="text" name="last_name" id="last_name" value="{{ $dentist->last_name }}" class="form-control @error('last_name') is-invalid @enderror" disabled>
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Region *</label>
                    <input type="text" name="region" id="region" value="{{ $dentist->region }}" class="form-control @error('region') is-invalid @enderror" disabled>
                    @error('region')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Province *</label>
                    <input type="text" name="province" id="province" value="{{ $dentist->province }}" class="form-control @error('province') is-invalid @enderror" disabled>
                    @error('province')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">City/Municipality *</label>
                    <input type="text" name="city" id="city" value="{{ $dentist->city }}" class="form-control @error('city') is-invalid @enderror" disabled>
                    @error('city')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Full Address *</label>
                    <input type="text" name="full_address" id="full_address" value="{{ $dentist->full_address }}" class="form-control @error('full_address') is-invalid @enderror" disabled>
                    @error('full_address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Specialization *</label>
                    <input type="text" name="specialization" id="specialization" value="{{ $dentist->specialization }}" class="form-control @error('specialization') is-invalid @enderror" disabled>
                    @error('specialization')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Contact Number *</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ $dentist->contact_number }}" class="form-control @error('contact_number') is-invalid @enderror" disabled>
                    @error('contact_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <a class="btn btn-outline-secondary btn-sm btn-uppercase" href="{{ route('dentists.index') }}">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
@endsection

@section('customjs')
    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
