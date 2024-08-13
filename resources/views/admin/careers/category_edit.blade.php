@extends('admin.layouts.app')

@section('pagecss')
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('career-categories.index')}}">Career Category</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Career Category</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Edit Career Category</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('career-categories.update', $careerCategory->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="d-block">Category Name <i class="tx-danger">*</i></label>
                        <input required type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $careerCategory->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="d-block">Visibility</label>
                        <div class="custom-control custom-switch @error('is_active') is-invalid @enderror">
                            <input type="checkbox" class="custom-control-input" name="is_active" {{ old("is_active", $careerCategory->is_active) ? "checked":"" }} id="customSwitch1">
                            <label class="custom-control-label" id="label_visibility" for="customSwitch1">@if ($careerCategory->is_active) Published @else Private @endif</label>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Update Category</button>
                    <a class="btn btn-outline-secondary btn-sm btn-uppercase" href="{{ route('career-categories.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
@endsection

@section('customjs')
    <script>
        $(function() {
            $("#customSwitch1").change(function () {
                if (this.checked) {
                    $('#label_visibility').html('Published');
                } else {
                    $('#label_visibility').html('Private');
                }
            });
        });
    </script>
@endsection
