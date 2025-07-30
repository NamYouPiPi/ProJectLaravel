  @extends('layout.app')
  @section('content')

  @section('title' , 'unit')
  @section('unit' , 'active' )
  @section('menu-open' , 'menu-open')
  

  <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
          <!--begin::Row-->
          <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-end">
                      {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                      <li class="breadcrumb-item"><a href="{{url('/unit/add')}}" class="btn btn-primary"><i class="bi bi-plus"></i> Add New</a> </li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
       <table class="table table-striped">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Name</th>
                          <th>Age</th>
                          <th>Action</th>
                          {{-- <th style="width: 40px">Label</th> --}}
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="align-middle">
                          <td>1.</td>
                          <td>You</td>
                          <td>21</td>
                       
                          <td class>
                            <a href="" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i>Delete</a>
                            <a href="" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill text-white"></i>Update</a>
                          </td>
                        </tr>
                       
                      </tbody>
                    </table>
                </div>
    </div>
                    @endsection