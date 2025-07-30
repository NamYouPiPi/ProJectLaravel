@extends('layout.app')
@section('content')

  {{-- @section('title' , 'unit')
  {{-- @section('unit' , 'active' ) --}}
  @section('menu-open' , 'menu-open') 
 <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
       
 
  <div class="mb-3">
<div class="card mb-4">
    <!--begin::Header-->
    <div class="card-header">
        <div class="card-title">
            <h4 class="m-0">Create new unit</h4>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form>
        <!--begin::Body-->
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                />
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea id="note" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <!--end::Body-->
        <!--begin::Footer-->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary">Cancel</button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->
</div>
</div>
      </div>





  @endsection()