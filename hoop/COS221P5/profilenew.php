<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>profile gallery with search input - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="card overflow-hidden">
            <div class="card-body p-0">
                <img src="./assets/img/hero-bg.jpg" alt class="img-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-4 order-lg-1 order-2">
                        <div class="d-flex align-items-center justify-content-around m-4">
                            <!-- <div class="text-center">
<i class="fa fa-file fs-6 d-block mb-2"></i>
<h4 class="mb-0 fw-semibold lh-1">938</h4>
<p class="mb-0 fs-4">Posts</p>
</div>
<div class="text-center">
<i class="fa fa-user fs-6 d-block mb-2"></i>
<h4 class="mb-0 fw-semibold lh-1">3,586</h4>
<p class="mb-0 fs-4">Followers</p>
</div>
<div class="text-center">
<i class="fa fa-check fs-6 d-block mb-2"></i>
<h4 class="mb-0 fw-semibold lh-1">2,659</h4>
<p class="mb-0 fs-4">Following</p>
</div> -->


                        </div>
                    </div>
                    <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                        <div class="mt-n5">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle"
                                    style="width: 110px; height: 110px;" ;>
                                    <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden"
                                        style="width: 100px; height: 100px;" ;>
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt
                                            class="w-100 h-100" id="profile">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="fs-5 mb-0 fw-semibold" id="username">andrew</h5>
                                <!-- <p class="mb-0 fs-4">Designer</p> -->
                            </div>
                        </div>
                    </div>



                    <!-- <div class="col-lg-4 order-last">
<ul class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-start my-3 gap-3">


<li class="position-relative">
<a class="text-white d-flex align-items-center justify-content-center bg-primary p-2 fs-4 rounded-circle" href="javascript:void(0)" width="30" height="30">
<i class="fa fa-facebook"></i>
</a>
</li>
<li class="position-relative">
<a class="text-white bg-secondary d-flex align-items-center justify-content-center p-2 fs-4 rounded-circle " href="javascript:void(0)">
<i class="fa fa-twitter"></i>
</a>
</li>
<li class="position-relative">
<a class="text-white bg-secondary d-flex align-items-center justify-content-center p-2 fs-4 rounded-circle " href="javascript:void(0)">
<i class="fa fa-dribbble"></i>
</a>
</li>
<li class="position-relative">
<a class="text-white bg-danger d-flex align-items-center justify-content-center p-2 fs-4 rounded-circle " href="javascript:void(0)">
<i class="fa fa-youtube"></i>
</a>
</li>
<li><button class="btn btn-primary">Add To Story</button></li>

</ul>

</div> -->
                </div>


                <ul class="nav nav-pills user-profile-tab justify-content-end mt-2 bg-light-info rounded-2"
                    id="pills-tab" role="tablist">


                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button"
                            role="tab" aria-controls="pills-profile" aria-selected="true">
                            <i class="fa fa-user me-2 fs-6"></i>
                            <span class="d-none d-md-block">Profile</span>
                        </button>
                    </li>



                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-followers-tab" data-bs-toggle="pill" data-bs-target="#pills-followers"
                            type="button" role="tab" aria-controls="pills-followers" aria-selected="false"
                            tabindex="-1">
                            <i class="fa fa-heart me-2 fs-6"></i>
                            <span class="d-none d-md-block">Reviews</span>
                        </button>
                    </li>

                    <!-- <li class="nav-item" role="presentation">
<button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6" id="pills-morefriends-tab" data-bs-toggle="pill" data-bs-target="#pills-morefriends" type="button" role="tab" aria-controls="pills-morefriends" aria-selected="false" tabindex="-1">
<i class="fa fa-users me-2 fs-6"></i>
<span class="d-none d-md-block">More friends</span>
</button>
</li> -->

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-morefriends-tab" data-bs-toggle="pill" data-bs-target="#pills-morefriends"
                            type="button" role="tab" aria-controls="pills-morefriends" aria-selected="false"
                            tabindex="-1">
                            <i class="fa fa-users me-2 fs-6"></i>
                            <span class="d-none d-md-block">More friends</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-friends-tab" data-bs-toggle="pill" data-bs-target="#pills-friends" type="button"
                            role="tab" aria-controls="pills-friends" aria-selected="false" tabindex="-1">
                            <i class="fa fa-users me-2 fs-6"></i>
                            <span class="d-none d-md-block">Friends</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-gallery-tab" data-bs-toggle="pill" data-bs-target="#pills-gallery" type="button"
                            role="tab" aria-controls="pills-gallery" aria-selected="false" tabindex="-1">
                            <i class="fa fa-photo me-2 fs-6"></i>
                            <span class="d-none d-md-block">WatchList</span>
                        </button>
                    </li>



                </ul>
            </div>
        </div>
        <!-- start of tab content -->
        <div class="tab-content" id="pills-tabContent">

            <!-- WatchList tab -->
            <div class="tab-pane fade show active" id="pills-gallery" role="tabpanel"
                aria-labelledby="pills-gallery-tab" tabindex="0">

                <div class="d-sm-flex align-items-center justify-content-between mt-3 mb-4">
                    <h3 class="mb-3 mb-sm-0 fw-semibold d-flex align-items-center">Gallery <span
                            class="badge text-bg-secondary fs-2 rounded-4 py-1 px-2 ms-2">12</span></h3>
                    <form class="position-relative">
                        <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                            placeholder="Search Friends">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></i>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Isuava wakceajo fe.jpg</h6>
                                        <span class="text-dark fs-2">Wed, Dec 14, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Isuava wakceajo
                                                    fe.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Ip docmowe vemremrif.jpg</h6>
                                        <span class="text-dark fs-2">Wed, Dec 14, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Ip docmowe
                                                    vemremrif.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Duan cosudos utaku.jpg</h6>
                                        <span class="text-dark fs-2">Wed, Dec 14, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Duan cosudos
                                                    utaku.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Fu netbuv oggu.jpg</h6>
                                        <span class="text-dark fs-2">Wed, Dec 14, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Fu netbuv
                                                    oggu.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Di sekog do.jpg</h6>
                                        <span class="text-dark fs-2">Wed, Dec 14, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Di sekog do.jpg</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Lo jogu camhiisi.jpg</h6>
                                        <span class="text-dark fs-2">Thu, Dec 15, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Lo jogu
                                                    camhiisi.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0 ">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Orewac huosazud robuf.jpg</h6>
                                        <span class="text-dark fs-2">Fri, Dec 16, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Orewac huosazud
                                                    robuf.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Nira biolaizo tuzi.jpg</h6>
                                        <span class="text-dark fs-2">Sat, Dec 17, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Nira biolaizo
                                                    tuzi.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Peri metu ejvu.jpg</h6>
                                        <span class="text-dark fs-2">Sun, Dec 18, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Peri metu
                                                    ejvu.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Vurnohot tajraje isusufuj.jpg</h6>
                                        <span class="text-dark fs-2">Mon, Dec 19, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Vurnohot tajraje
                                                    isusufuj.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Juc oz ma.jpg</h6>
                                        <span class="text-dark fs-2">Tue, Dec 20, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Juc oz ma.jpg</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card hover-img overflow-hidden rounded-2">
                            <div class="card-body p-0">
                                <img src="https://www.bootdey.com/image/580x380/00FFFF/000000" alt
                                    class="img-fluid w-100 object-fit-cover" style="height: 220px;">
                                <div class="p-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-semibold mb-0 fs-4">Povipvez marjelliz zuuva.jpg</h6>
                                        <span class="text-dark fs-2">Wed, Dec 21, 2023</span>
                                    </div>
                                    <div class="dropdown">
                                        <a class="text-muted fw-semibold d-flex align-items-center p-1"
                                            href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu overflow-hidden">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Povipvez marjelliz
                                                    zuuva.jpg</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of WatchList -->
            </div>

            <!-- profile tab -->
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                aria-labelledby="pills-profile-tab" tabindex="0">
                <h3>Profile Information</h3>
                <p>Details about the user's profile...</p>
                <!-- end of profile tabs       -->
            </div>

            <!-- more friends -->
            <div class="tab-pane fade" id="pills-morefriends" role="tabpanel" aria-labelledby="pills-morefriends-tab"
                tabindex="0">
                <div class="friend-list">
                    <div class="row" id="moreFriend">
                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="https://www.bootdey.com/image/400x100/6495ED" alt="profile-cover"
                                    class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                        <p>Student at Harvard</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="https://www.bootdey.com/image/400x100/008B8B" alt="profile-cover"
                                    class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                        <p>Student at Harvard</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="https://www.bootdey.com/image/400x100/9932CC" alt="profile-cover"
                                    class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar5.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                        <p>Student at Harvard</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="https://www.bootdey.com/image/400x100/228B22" alt="profile-cover"
                                    class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar4.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                        <p>Student at Harvard</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="https://www.bootdey.com/image/400x100/20B2AA" alt="profile-cover"
                                    class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                        <p>Student at Harvard</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="https://www.bootdey.com/image/400x100/FF4500" alt="profile-cover"
                                    class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                        <p>Student at Harvard</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of more friends tab -->
            </div>

            <!-- friends tab -->
            <div class="tab-pane fade" id="pills-friends" role="tabpanel" aria-labelledby="pills-friends-tab"
                tabindex="0">
                <div class="friend-list">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">Remove friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive-cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">remove friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar5.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">Remove friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar4.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">Remove friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">Remove friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="friend-card">
                                <img src="./assets/img/cardColour.png" alt="profile-cover" class="img-responsive cover">
                                <div class="card-info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="user"
                                        class="profile-photo-lg">
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">Remove friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- end of friends tab -->
            </div>


            <!-- end of tab content -->
        </div>







        <!-- end  of container -->
    </div>



    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>