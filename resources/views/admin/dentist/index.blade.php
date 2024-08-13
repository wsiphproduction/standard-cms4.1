@extends('admin.layouts.app')

@section('pagetitle')
    Manage Dentists
@endsection

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>
        .row-selected {
            background-color: #92b7da !important;
        }

        button.nav-link {
            border: none;
            background: none;
            outline: none;
        }

        button.nav-link:focus {
            outline: none;
        }

    </style>
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dentists</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Dentists</h4>
            </div>
        </div>

        <div class="row row-sm">

            <!-- Start Filters -->
            <div class="col-md-12">
                <div class="filter-buttons">
                    <div class="d-md-flex bd-highlight">
                        <!-- Filters And Actions -->   
                        <div class="bd-highlight mg-r-10 mg-t-10">
                            <div class="dropdown d-inline mg-r-5">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('common.filters')}}
                                </button>
                                <div class="dropdown-menu">
                                    <form id="filterForm" class="pd-20">
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_by')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy1" name="orderBy" class="custom-control-input" value="updated_at" @if ($filter->orderBy == 'updated_at') checked @endif>
                                                <label class="custom-control-label" for="orderBy1">{{__('common.date_modified')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy2" name="orderBy" class="custom-control-input" value="first_name" @if ($filter->orderBy == 'first_name') checked @endif>
                                                <label class="custom-control-label" for="orderBy2">Name</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_order')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByAsc" name="sortBy" class="custom-control-input" value="asc" @if ($filter->sortBy == 'asc') checked @endif>
                                                <label class="custom-control-label" for="sortByAsc">{{__('common.ascending')}}</label>
                                            </div>

                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByDesc" name="sortBy" class="custom-control-input" value="desc"  @if ($filter->sortBy == 'desc') checked @endif>
                                                <label class="custom-control-label" for="sortByDesc">{{__('common.descending')}}</label>
                                            </div>
                                        </div>
                                        <!--
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if ($filter->showDeleted) checked @endif>
                                                    <label class="custom-control-label" for="showDeleted">{{__('common.show_deleted')}}</label>
                                                </div>
                                            </div>
                                        -->
                                        <div class="form-group mg-b-40">
                                            <label class="d-block">{{__('common.item_displayed')}}</label>
                                            <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter->perPage }}"/>
                                        </div>
                                        <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>
                           @if(auth()->user()->has_access_to_route('dentists.destroy'))
                                <div class="list-search d-inline">
                                    <div class="dropdown d-inline mg-r-10">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if(auth()->user()->has_access_to_route('dentists.delete'))
                                                <a class="dropdown-item tx-danger" href="javascript:void(0)" onclick="delete_page()">{{__('common.delete')}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- End of Filters And Actions -->

                        <div class="ml-auto bd-highlight mg-t-10 mg-r-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form mg-r-10">
                                    <input name="search" type="search" id="search" class="form-control"  placeholder="Search by Title" value="">
                                    <button class="btn filter" id="btnSearch"><i data-feather="search"></i></button>
                                </div>
                                @if(auth()->user()->has_access_to_route('dentists.create'))
                                    <a class="btn btn-primary btn-sm mg-b-5 mt-lg-0 mt-md-0 mt-sm-0 mt-1 mg-r-5" href="{{route('dentists.create')}}">Add Dentist</a>
                                    <a class="btn btn-info btn-sm mg-b-5 mt-lg-0 mt-md-0 mt-sm-0 mt-1" href="javascript:void(0)" data-toggle="modal" data-target="#uploadProductModal"><i class="fa fa-upload"></i> Import</a>
                                @endif
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Filters -->


            <!-- Start Pages -->
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover" style="width:100%;word-wrap: break-word;min-width:700px">
                            <thead>
                            <tr>
                                <th style="width: 5%;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                        <label class="custom-control-label" for="checkbox_all"></label>
                                    </div>
                                </th>
                                <th style="width: 15%;overflow: hidden;">Name</th>
                                <th style="width: 20%;">Specialization</th>
                                <th style="width: 35%;">Address</th>
                                <th style="width: 10%;">Contact Number</th>
                                <th style="width: 10%;">Last Date Modified</th>
                                <th style="width: 10%;">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($dentists as $dentist)
                                    <tr id="row{{$dentist->id}}" class="row_cb">
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input cb" id="cb{{$dentist->id}}" >
                                                <label class="custom-control-label" for="cb{{$dentist->id}}"></label>
                                            </div>
                                        </th>
                                        <td><strong>Dr. {{ $dentist->first_name.' '.$dentist->last_name }}</strong></td>
                                        <td>{{ $dentist->specialization }}</td>
                                        <td>{{ $dentist->full_address }}</td>
                                        <td>{{ $dentist->contact_number }}</td>
                                        <td><span class="text-nowrap">{{ Setting::date_for_listing($dentist->updated_at) }}</span></td>
                                        <td>
                                            <nav class="nav table-options flex-nowrap">
                                                @if(auth()->user()->has_access_to_route('dentists.show'))
                                                    <a class="nav-link" href="{{ route('dentists.show', $dentist->id) }}" title="View Dentist"><i data-feather="eye"></i></a>
                                                @endif
                                                @if(auth()->user()->has_access_to_route('dentists.edit'))
                                                    <a class="nav-link" href="{{ route('dentists.edit', $dentist->id) }}" title="Edit Dentist"><i data-feather="edit"></i></a>
                                                @endif
                                                @if(auth()->user()->has_access_to_route('dentists.destroy'))
                                                    <button type="submit" class="nav-link" title="Delete Dentist" data-target="#prompt-delete" data-toggle="modal" data-animation="effect-scale" data-id="{{ $dentist->id }}" data-name="{{ $dentist->first_name }}">
                                                        <i data-feather="trash"></i>
                                                    </button>
                                                    <form id="pageForm{{ $dentist->id }}" method="POST" action="{{ route('dentists.destroy', $dentist->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </nav>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center;"> <p class="text-danger">No dentists found.</p></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Pages -->

            <!-- Start Navigation -->
            <div class="col-md-6">
                <div class="mg-t-5">
                    @if ($dentists->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{$dentists->firstItem()}} to {{$dentists->lastItem()}} of {{$dentists->total()}} dentists</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $dentists->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
            <!-- End Navigation -->

        </div>
    </div>

    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="pages" name="pages">
        <input type="text" id="status" name="status">
    </form>

    <div id="uploadProductModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="upload_excel" method="POST" action="{{ route('dentists.import') }}" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Import Multiple Dentists</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="file" name="file" id="file" accept=".xls, .xlsx" required>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ asset('files/Dentist-Upload-Template.xlsx') }}" type="button" class="btn btn-success mr-auto" download><i class="fa fa-download"></i> Template</a>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <input type="submit" value="Upload" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.delete_confirmation')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDelete">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-multiple-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_mutiple_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{__('common.delete_mutiple_confirmation')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDeleteMultiple">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        let listingUrl = "{{ route('dentists.index') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
    <script>
        function post_form(url,status,pages){

            $('#posting_form').attr('action',url);
            $('#pages').val(pages);
            $('#status').val(status);
            $('#posting_form').submit();

        }

        /*** handles the changing of status of multiple pages ***/

        let selected_pages = '';
        let new_status = '';
        function change_status(status) {
            new_status = status;
            var counter = 0;
            selected_pages = '';
            $(".cb:checked").each(function () {
                counter++;
                fid = $(this).attr('id');
                selected_pages += fid.substring(2, fid.length) + '|';
            });

            if (parseInt(counter) < 1) {
                $('#prompt-no-selected').modal('show');
                return false;
            } else {
                if (parseInt(counter) > 1) { // ask for confirmation when multiple pages was selected
                    status = (status == 'PUBLISHED') ? 'PUBLISH' : status;
                    $('#pageStatus').html(status)
                    $('#prompt-update-status').modal('show');
                } else {
                    post_form('{{route('pages.change.status')}}', status, selected_pages);
                }
            }

        }

        $('#btnUpdateStatus').on('click', function() {
            post_form('{{route('pages.change.status')}}', new_status, selected_pages);
        });

        function delete_page(){
            var counter = 0;
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_pages += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                $('#prompt-multiple-delete').modal('show');
            }
        }

        $('#btnDeleteMultiple').on('click', function() {
            post_form('{{route('dentists.delete')}}','',selected_pages);
        });

        function check_date(feld){
            if($('#search_datestart').val() && $('#search_dateend').val()){
                if($('#search_datestart').val() > $('#search_dateend').val()){
                    alert('Date Start should not be later than Date End!');
                    $('#'+feld).val('');
                    return false;
                }
            }
            else{
                return true;
            }
        }

        let pageId;
        $('#prompt-delete').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            let album = e.relatedTarget;
            pageId = $(album).data('id');
            let pageName = $(album).data('name');

            $('#pageName').html(pageName);
        });

        $('#btnDelete').on('click', function() {
            $('#pageForm'+pageId).submit();
        });

    </script>
@endsection
