<template>
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-light navbar-light">
            <a href="index.html" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary">
                    <marquee><i class="fa fa-hashtag me-2"></i>POS</marquee>
                </h3>
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle" src="../../assets/img/images.jpeg" alt=""
                        style="width: 40px; height: 40px;">
                    <div
                        class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                    </div>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0">MRM</h6>
                    <span>Admin</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a href="index.html" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="fa fa-laptop me-2"></i>Elements</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <router-link :to="{ name: 'category' }" class="nav-item nav-link"><i
                                class="fa fa-th me-2"></i>Category</router-link>
                        <router-link :to="{ name: 'subcategory' }" class="nav-item nav-link"><i
                                class="fa fa-th me-2"></i>SubCategory</router-link>
                        <router-link :to="{ name: 'brand' }" class="nav-item nav-link"><i
                                class="fa fa-th me-2"></i>Brand</router-link>
                        <router-link :to="{ name: 'product' }" class="nav-item nav-link"><i
                                class="fa fa-th me-2"></i>Product List</router-link>

                        <!-- <router-link :to="{ name: 'product' }" class="dropdown-item">Product List</router-link> -->
                        <router-link :to="{ name: 'content' }" class="dropdown-item">Buttons</router-link>
                        <a href="typography.html" class="dropdown-item">Typography</a>
                        <a href="element.html" class="dropdown-item">Other Elements</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="fa fa-laptop me-2"></i>Expense</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <router-link :to="{ name: 'expncat' }" class="nav-item nav-link"><i
                                class="fa fa-th me-2"></i>Expense Category</router-link>
                        <router-link :to="{ name: 'expn' }" class="nav-item nav-link"><i
                                class="fa fa-th me-2"></i>Expense</router-link>

                    </div>
                </div>
                <router-link :to="{ name: 'unit' }" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Unit List
                    List</router-link>
                <router-link :to="{ name: 'payment' }" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Payment List</router-link>
                <router-link :to="{ name: 'employee' }" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Employee
                    List</router-link>
                <router-link :to="{ name: 'supplier' }" class="nav-item nav-link"><i
                        class="fa fa-keyboard me-2"></i>Supplier List</router-link>
                <router-link :to="{ name: 'customer' }" class="nav-item nav-link"><i
                        class="fa fa-keyboard me-2"></i>Customer List</router-link>
                <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
                <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
                <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i
                            class="far fa-file-alt me-2"></i>Pages</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="signin.html" class="dropdown-item">Sign In</a>
                        <a href="signup.html" class="dropdown-item">Sign Up</a>
                        <a href="404.html" class="dropdown-item">404 Error</a>
                        <a href="blank.html" class="dropdown-item active">Blank Page</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>