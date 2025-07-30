@include('partials.header')
<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-dark">
                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo">
                    <span class="app-brand-logo demo">
                        <img src="assets/img/logo.png" alt="Brand Logo" class="img-fluid">
                    </span>
                    <a href="index.html" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Bhumlu</a>
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <div class="sidenav-divider mt-0"></div>

          @include('partials.sidebar')            
            </div>
            <div class="layout-container">
                @include('partials.navbar')
                <div class="layout-content">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                <li class="breadcrumb-item active">Data</li>
                            </ol>
                        </div>
                        <div class="row">
                            <!-- 1st row Start -->
                            <div class="col-lg-7">
                                <div class="card mb-4">
                                    <div class="card-header with-elements">
                                        <h6 class="card-header-title mb-0">Statistics</h6>
                                        <div class="card-header-elements ml-auto">
                                            <label class="text m-0">
                                                <span class="text-light text-tiny font-weight-semibold align-middle">SHOW STATS</span>
                                                <span class="switcher switcher-sm d-inline-block align-middle mr-0 ml-2"><input type="checkbox" class="switcher-input" checked><span class="switcher-indicator"><span class="switcher-yes"></span><span
                                                            class="switcher-no"></span></span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="statistics-chart-1" style="height:270px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-2-dark">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-gift display-4 text-primary"></div>
                                                    <div class="ml-3">
                                                        <div class="text-muted small">Products</div>
                                                        <div class="text-large">985</div>
                                                    </div>
                                                </div>
                                                <div id="ecom-chart-3" class="mt-3 chart-shadow-primary" style="height:40px"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-2 bg-primary text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-cart display-4"></div>
                                                    <div class="ml-3">
                                                        <div class="small">Monthly sales</div>
                                                        <div class="text-large">2362</div>
                                                    </div>
                                                </div>
                                                <div id="order-chart-1" class="mt-3 chart-shadow" style="height:40px"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="card d-flex w-100 mb-4">
                                            <div class="row no-gutters row-bordered row-border-light h-100">
                                                <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                                    <div class="card-body media align-items-center text-dark">
                                                        <i class="lnr lnr-diamond display-4 d-block text-primary"></i>
                                                        <span class="media-body d-block ml-3"><span class="text-big mr-1 text-primary">$1584.78</span>
                                                            <br>
                                                            <small class="text-muted">Earned this month</small>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                                    <div class="card-body media align-items-center text-dark">
                                                        <i class="lnr lnr-clock display-4 d-block text-primary"></i>
                                                        <span class="media-body d-block ml-3"><span class="text-big"><span class="mr-1 text-primary">152</span>Working Hours</span>
                                                            <br>
                                                            <small class="text-muted">Spent this month</small>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                                    <div class="card-body media align-items-center text-dark">
                                                        <i class="lnr lnr-hourglass display-4 d-block text-primary"></i>
                                                        <span class="media-body d-block ml-3"><span class="text-big"><span class="mr-1 text-primary">54</span> Tasks</span>
                                                            <br>
                                                            <small class="text-muted">Completed this month</small>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">
                                                    <div class="card-body media align-items-center text-dark">
                                                        <i class="lnr lnr-license display-4 d-block text-primary"></i>
                                                        <span class="media-body d-block ml-3"><span class="text-big"><span class="mr-1 text-primary">6</span> Projects</span>
                                                            <br>
                                                            <small class="text-muted">Done this month</small>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 1st row Start -->
                        </div>
                        <div class="row">
                            <!-- 2nd row Start -->
                            <div class="col-md-12">
                                <div class="card d-flex w-100 mb-4">
                                    <div class="row no-gutters row-bordered row-border-light h-100">
                                        <div class="d-flex col-md-6 col-lg-3 align-items-center">
                                            <div class="card-body">
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-auto">
                                                        <i class="lnr lnr-earth text-primary display-4"></i>
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="mb-0 text-muted">Total <span class="text-primary">Subscription</span></h6>
                                                        <h4 class="mt-3 mb-0">7652<i class="ion ion-md-arrow-round-down ml-3 text-danger"></i></h4>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-muted">48% From Last 24 Hours</p>
                                            </div>
                                        </div>
                                        <div class="d-flex col-md-6 col-lg-3 align-items-center">
                                            <div class="card-body">
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-auto">
                                                        <i class="lnr lnr-cart text-primary display-4"></i>
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="mb-0 text-muted"><span class="text-primary">Order</span> Status</h6>
                                                        <h4 class="mt-3 mb-0">6325<i class="ion ion-md-arrow-round-up ml-3 text-success"></i></h4>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-muted">36% From Last 6 Months</p>
                                            </div>
                                        </div>
                                        <div class="d-flex col-md-6 col-lg-3 align-items-center">
                                            <div class="card-body">
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-auto">
                                                        <i class="lnr lnr-users text-primary display-4"></i>
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="mb-0 text-muted">Unique <span class="text-primary">Visitors</span></h6>
                                                        <h4 class="mt-3 mb-0">652<i class="ion ion-md-arrow-round-down ml-3 text-danger"></i></h4>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-muted">36% From Last 6 Months</p>
                                            </div>
                                        </div>
                                        <div class="d-flex col-md-6 col-lg-3 align-items-center">
                                            <div class="card-body">
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-auto">
                                                        <i class="lnr lnr-magic-wand text-primary display-4"></i>
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="mb-0 text-muted">Monthly <span class="text-primary">Earnings</span></h6>
                                                        <h4 class="mt-3 mb-0">5963<i class="ion ion-md-arrow-round-up ml-3 text-success"></i></h4>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-muted">36% From Last 6 Months</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Staustic card 3 Start -->
                            </div>
                            <!-- 2nd row Start -->
                        </div>
                        <div class="row">
                            <!-- 3rd row Start -->
                            <div class="col-xl-5">
                                <div class="card mb-4">
                                    <div class="card-header with-elements">
                                        <h6 class="card-header-title mb-0">Tasks</h6>
                                        <div class="card-header-elements ml-auto">
                                            <button type="button" class="btn btn-default btn-xs md-btn-flat">Show more</button>
                                        </div>
                                    </div>
                                    <div style="height: 310px" id="tasks-inner">
                                        <div class="card-body">
                                            <p class="text-muted small">Today</p>
                                            <div class="custom-controls-stacked">
                                                <label class="ui-todo-item custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-label">Buy products</span>
                                                    <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">58 mins left</span>
                                                </label>
                                                <label class="ui-todo-item custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-label">Reply to emails</span>
                                                </label>
                                                <label class="ui-todo-item custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-label">Write blog post</span>
                                                    <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">20 hours left</span>
                                                </label>
                                                <label class="ui-todo-item custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked>
                                                    <span class="custom-control-label">Wash my car</span>
                                                </label>
                                            </div>
                                        </div>
                                        <hr class="m-0">
                                        <div class="card-body">
                                            <p class="text-muted small">Tomorrow</p>
                                            <div class="custom-controls-stacked">
                                                <label class="ui-todo-item custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-label">Buy antivirus</span>
                                                </label>
                                                <label class="ui-todo-item custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-label">Jane's Happy Birthday</span>
                                                </label>
                                                <label class="ui-todo-item custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <span class="custom-control-label">Call mom</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Type your task">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7">
                                <div class="card mb-4">
                                    <div class="card-header with-elements pb-0">
                                        <h6 class="card-header-title mb-0">Customer details</h6>
                                        <div class="card-header-elements ml-auto p-0">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#sale-stats">Sale stats</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#latest-sales">Latest sales</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nav-tabs-top">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="sale-stats">
                                                <div style="height: 330px" id="tab-table-1">
                                                    <table class="table table-hover card-table">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <label class="custom-control custom-checkbox mb-0">
                                                                        <input type="checkbox" class="custom-control-input">
                                                                        <span class="custom-control-label"><strong>Due</strong></span>
                                                                    </label>
                                                                </th>
                                                                <th>User</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <label class="custom-control custom-checkbox mb-0">
                                                                        <input type="checkbox" class="custom-control-input">
                                                                        <span class="custom-control-label"><strong>12</strong><br><span>hour</span></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <div class="media mb-0">
                                                                        <img src="assets/img/avatars/3-small.png" class="d-block ui-w-40 rounded-circle" alt="">
                                                                        <div class="media-body align-self-center ml-3">
                                                                            <h6 class="mb-0">John Deo</h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="d-inline-block align-middle">
                                                                        <h6 class="mb-1">[#1183] Workaround for OS X selects printing bug</h6>
                                                                        <p class="text-muted mb-0">Chrome fixed the bug several versions ago, thus rendering this...</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <a href="javascript:" class="card-footer d-block text-center text-dark small font-weight-semibold">SHOW MORE</a>
                                            </div>
                                            <div class="tab-pane fade" id="latest-sales">
                                                <div style="height: 330px" id="tab-table-2">
                                                    <table class="table table-hover card-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Qty.</th>
                                                                <th>Sum.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">PlayStation 4 1TB (Jet Black)</a>
                                                                </td>
                                                                <td class="align-middle">1</td>
                                                                <td class="align-middle">$480.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">Nike Men Black Liteforce III Sneakers</a>
                                                                </td>
                                                                <td class="align-middle">2</td>
                                                                <td class="align-middle">$115.1</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">Wireless headphones</a>
                                                                </td>
                                                                <td class="align-middle">1</td>
                                                                <td class="align-middle">$235.55</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">HERO ATHLETES BAG</a>
                                                                </td>
                                                                <td class="align-middle">1</td>
                                                                <td class="align-middle">$160.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">POÄNG</a>
                                                                </td>
                                                                <td class="align-middle">3</td>
                                                                <td class="align-middle">$477.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">Apple iWatch (black)</a>
                                                                </td>
                                                                <td class="align-middle">1</td>
                                                                <td class="align-middle">$399.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">WALKING 400 BLUE CAT3</a>
                                                                </td>
                                                                <td class="align-middle">2</td>
                                                                <td class="align-middle">$41.1</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">Wireless headphones</a>
                                                                </td>
                                                                <td class="align-middle">1</td>
                                                                <td class="align-middle">$235.55</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">HERO ATHLETES BAG</a>
                                                                </td>
                                                                <td class="align-middle">1</td>
                                                                <td class="align-middle">$160.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-middle">
                                                                    <a href="javascript:" class="text-dark">POÄNG</a>
                                                                </td>
                                                                <td class="align-middle">3</td>
                                                                <td class="align-middle">$477.00</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <a href="javascript:" class="card-footer d-block text-center text-dark small font-weight-semibold">SHOW MORE</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 3rd row Start -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
@include('partials.footer')
</body>

</html>
