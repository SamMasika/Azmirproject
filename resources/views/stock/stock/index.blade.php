@extends('layouts.master')

@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Datatables</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Datatables</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            @if(session()->has('success')) 
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session()->has('error')) 
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Items
                                    <button type="button" class="btn btn-success add-btn float-right" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Stock</button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10px;">
                                            <div class="form-check">
                                                <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                            </div>
                                        </th>
                                        <th data-ordering="false">StockID</th>
                                        <th data-ordering="false">Item Name</th>
                                        <th data-ordering="false">Current Stock</th>
                                        <th data-ordering="false">Price/Item</th>
                                        <th data-ordering="false">Total Amount</th>
                                        <th data-ordering="false" width="15%" >Add Stock</th>
                                        <th data-ordering="false" width="15%">Remove Stock</th>
                                        <th data-ordering="false" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input fs-15" type="checkbox" name="checkAll" value="option1">
                                            </div>
                                        </th>
                                        <td>{{$item['id']}}</td>
                                        <td>{{$item['item']['name']}}</td>
                                        <td>{{$item['current_stock']}}</td>
                                        <td>{{$item['price']}}</td>
                                        <td>{{$item['total']}}</td>
                                        <td>
                                            <form action="{{url('stock-control/'.$item['id'])}}" method="POST" style="display: inline-block;" class="form-inline">
                                                <div class="input-group">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="action" value="add">
                                                    <input type="number" name="current_stock" class="form-control form-control-sm col-4" min="1">
                                                    <input type="submit" class="btn btn-xs btn-success" value="Add">
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{url('stock-control/'.$item['id'])}}" method="POST" style="display: inline-block;" class="form-inline">
                                                <div class="input-group">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="action" value="remove">
                                                    <input type="number" name="current_stock" class="form-control form-control-sm col-4" min="1">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="Remove">
                                                </div>
                                            </form>
                                        </td>
                                      
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                    <li><a class="dropdown-item edit-item-btn"   data-bs-toggle="modal" data-bs-target="#EditModal{{$item['id']}}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                    <li>
                                                        <a class="dropdown-item remove-item-btn"  data-bs-toggle="modal" data-bs-target="#ModalDelete{{$item['id']}}">
                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @include('stock.stock.delete')
                                        </td>
                                        @include('stock.stock.edit')
                                    </tr>
                                    @endforeach
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

          
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © Azmir.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by SamChard
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>


<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" >Add Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form action="{{url('stock-store')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="price" class="form-label">Item Name</label>
                            <select class="form-control" name="item_id">
                                <option value="">--Select Item--</option>
                                @foreach ($data_item as $item) 
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Current Stock</label>
                        <input type="number" name="current_stock" id="price" class="form-control" placeholder="Stock" required />
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price per Item</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="Price" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-btn">Add Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection