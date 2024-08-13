@extends('admin.layouts.app')

@section('pagetitle')
    Manage Category
@endsection

@section('pagecss')
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>
        .table {
            word-wrap: break-word;
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
                        <li class="breadcrumb-item active" aria-current="page">Manage Career Categories</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Career Categories</h4>
            </div>
        </div>

        <div class="row row-sm">

            <!-- Start Filters -->
            <div class="col-md-12">

                <div class="filter-buttons mg-b-10">
                    <div class="d-md-flex bd-highlight">
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
                                                <input type="radio" id="orderBy2" name="orderBy" class="custom-control-input" value="name" @if ($filter->orderBy == 'name') checked @endif>
                                                <label class="custom-control-label" for="orderBy2">{{__('common.name')}}</label>
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
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if ($filter->showDeleted) checked @endif>
                                                <label class="custom-control-label" for="showDeleted">{{__('common.show_deleted')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group mg-b-40">
                                            <label class="d-block">{{__('common.item_displayed')}}</label>
                                            <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter->perPage }}"/>
                                        </div>
                                        <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>
                            <div class="list-search d-inline">
                                <div class="dropdown d-inline mg-r-10">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if(auth()->user()->has_access_to_route('career-categories.change.status'))
                                            <button id="publishedItems" class="dropdown-item">Published</button>
                                            <button id="privateItems" class="dropdown-item">Private</button>
                                            <form id="updateItemsForm" method="POST" class="d-none" action="{{ route('career-categories.change.status') }}" style="display: none;">
                                                @csrf
                                                <input name="ids" id="updateItemIds" type="hidden">
                                                <input name="is_active" id="updateItemStatus" type="hidden">
                                            </form>
                                        @endif

                                        @if(auth()->user()->has_access_to_route('career-categories.destroy_many'))
                                            <button id="deleteItems" class="dropdown-item tx-danger">Delete</button>
                                            <form id="itemsForm" method="POST" class="d-none" action="{{ route('career-categories.destroy_many') }}" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                                <input name="ids" id="itemIds" type="hidden">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto bd-highlight mg-t-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form mg-r-10">
                                    <input name="search" type="search" id="search" class="form-control" placeholder="Search by Name" value="{{ $filter->search }}">
                                    <button class="btn" type="button"><i data-feather="search"></i></button>
                                </div>
                                @if(auth()->user()->has_access_to_route('career-categories.create'))
                                    <a href="{{route('career-categories.create')}}" class="btn btn-primary btn-sm mg-b-5 mg-l-5">Create a Career Category</a>
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
                        <table class="table mg-b-0 table-light table-hover" style="width:100%;">
                            <thead>
                            <tr>
                                <th scope="col" width="8%">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                        <label class="custom-control-label" for="checkbox_all"></label>
                                    </div>
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col" width="15%">Total Careers</th>
                                <th scope="col" width="15%">Status</th>
                                <th scope="col" width="15%">Last Date Modified</th>
                                <th scope="col" width="15%">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $category)
                                <tr id="row{{$category->id}}" class="row_cb">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input cb" id="cb{{ $category->id }}" data-id="{{ $category->id }}">
                                            <label class="custom-control-label" for="cb{{ $category->id }}"></label>
                                        </div>
                                    </th>
                                    <td><strong @if($category->trashed()) style="text-decoration:line-through;" @endif> {{ $category->name }}</strong></td>
{{--                                    <td><a target="_blank" href="{{route('news.front.index')}}?type=category&criteria={{$category->id}}" @if($category->get_total_articles() == 0) class="disabled" @endif>--}}
{{--                                            {{route('news.front.index')."?type=category&criteria=".$category->id}}</a></td>--}}
                                    <td>{{ $category->total_careers() }}</td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-secondary">Private</span>
                                        @endif
                                    </td>
                                    <td>{{ Setting::date_for_listing($category->updated_at) }}</td>
                                    <td>
                                        @if($category->trashed() && auth()->user()->has_access_to_route('career-categories.restore'))
                                            <nav class="nav table-options justify-content-end">
                                                <form id="form{{$category->id}}" method="post" action="{{ route('career-categories.restore', $category->id) }}">
                                                    @csrf
                                                    @method('POST')
                                                    <a class="nav-link" href="#" title="Restore career category" onclick="document.getElementById('form{{$category->id}}').submit()"><i data-feather="rotate-ccw"></i></a>
                                                </form>
                                            </nav>
                                        @else
                                            <nav class="nav table-options justify-content-end">
                                                @if(auth()->user()->has_access_to_route('career-categories.edit'))
                                                    <a class="nav-link" href="{{ route('career-categories.edit', $category->id) }}" title="Edit career category" ><i data-feather="edit"></i></a>
                                                @endif
                                                <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="settings"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(auth()->user()->has_access_to_route('career-categories.change.status'))
                                                        @if ($category->is_active)
                                                            <button type="button" class="dropdown-item update-status" data-id="{{ $category->id }}" data-status="0">Private</button>
                                                        @else
                                                            <button type="button" class="dropdown-item update-status" data-id="{{ $category->id }}" data-status="1"> Publish</button>
                                                        @endif
                                                    @endif

                                                    @if(auth()->user()->has_access_to_route('career-categories.destroy'))
                                                        <button type="button" class="dropdown-item" data-target="#prompt-delete" data-toggle="modal" data-animation="effect-scale" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Delete</button>
                                                        <form id="itemForm{{ $category->id }}" method="POST" action="{{ route('career-categories.destroy', $category->id) }}" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endif
                                                </div>
                                            </nav>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="5" style="text-align: center;"> <p class="text-danger">No categories found.</p></th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Pages -->

            <!-- End Pages -->
            <div class="col-md-6">
                <div class="mg-t-5">
                    @if ($categories->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $categories->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-update-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.update_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You are about to <span id="statusMany"></span> the selected item/s. Do you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnUpdateStatusMany">Yes, Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-delete-many" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_mutiple_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.delete_mutiple_confirmation')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDeleteMany">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
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

    <div class="modal effect-scale" id="prompt-update-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.update_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You are about to <span id="status"></span> this item. Do you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnUpdateStatus">Yes, Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-update-status-many" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.update_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You are about to <span id="statusMany"></span> the selected items. Do you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnUpdateStatusMany">Yes, Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-no-selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.no_selected_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.no_selected')}}</p>
                </div>
                <div class="modal-footer">
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
        let listingUrl = "{{ route('career-categories.index') }}";
        let advanceListingUrl = "";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>

    <script>
        let ids;

        $('.update-status').on('click', function () {
            let status = $(this).data('status');
            $('#updateItemStatus').val($(this).data('status'));
            ids = [];
            ids.push($(this).data('id'));
            $('#statusMany').html((status == 1) ? 'publish' : 'private');
            $('#prompt-update-status').modal('show');
        });

        function validateCheckbox(method)
        {
            if($(".cb:checked").length <= 0){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else {
                ids = [];
                $.each($(".cb:checked"), function() {
                    ids.push($(this).data('id'));
                });

                if (method == 'delete') {
                    $('#prompt-delete-many').modal('show');
                } else if (method == 'update-status') {
                    $('#prompt-update-status-many').modal('show');
                }
            }
        }

        $('#publishedItems').on('click', function () {
            $('#statusMany').html('published');
            $('#updateItemStatus').val(1);
            validateCheckbox('update-status');
        });

        $('#privateItems').on('click', function () {
            $('#statusMany').html('private');
            $('#updateItemStatus').val(0);
            validateCheckbox('update-status');
        });

        $('#btnUpdateStatusMany').on('click', function () {
            $('#updateItemIds').val(ids);
            $('#updateItemsForm').submit();
        });

        $('#deleteItems').on('click', function () {
            validateCheckbox('delete');
        });

        $('#btnDeleteMany').on('click', function () {
            $('#itemIds').val(ids);
            $('#itemsForm').submit();
        });

        let itemId;
        $('#prompt-delete').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            let item = e.relatedTarget;
            itemId = $(item).data('id');
        });

        $('#btnDelete').on('click', function() {
            $('#itemForm'+itemId).submit();
        });
    </script>
@endsection
