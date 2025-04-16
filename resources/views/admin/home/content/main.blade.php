<div class="header-body">
    <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0">Tổng quan</h6>
            <div class="d-none d-md-inline-block ml-md-4">
                @verbatim
                <select v-model="filterMonth" @change="changeMonth" class="form-select form-select-xl custom-select" aria-label="Default select example">
                    <option></option>
                    <option v-for="item in global.monthsInFilter" :value="item">
                        {{item}}
                    </option>
                </select>
                @endverbatim
            </div>
            <div class="d-none d-md-inline-block ml-md-4">
                @verbatim
                <select v-model="filterUser" @change="changeUser" class="form-select form-select-xl custom-select" aria-label="Default select example">
                    <option></option>
                    <option v-for="(value,index) in global.usersInFilter" :value="index">
                        {{value}}
                    </option>
                </select>
                @endverbatim
            </div>
        </div>
    </div>
    <!-- Card stats -->
    @verbatim
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Tổng đơn</h5>
                            <span class="h2 font-weight-bold mb-0">{{totalOrders}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="mr-2" :class="[(totalLastMonthOrders < totalOrders) ? 'text-success' : 'text-danger']">
                            <i class="fa" :class="[(totalLastMonthOrders < totalOrders) ? 'fa-arrow-up' : 'fa-arrow-down']"></i>
                            {{calculateRate(totalLastMonthOrders, totalOrders)}}%
                        </span>
                        <span class="text-nowrap">So với tháng trước</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Doanh thu</h5>
                            <span class="h2 font-weight-bold mb-0">{{formatCurrencyNumber(totalRevenue)}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-chart-pie-35"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="mr-2" :class="[(totalLastMonthRevenue < totalRevenue) ? 'text-success' : 'text-danger']">
                            <i class="fa" :class="[(totalLastMonthRevenue < totalRevenue) ? 'fa-arrow-up' : 'fa-arrow-down']"></i>
                            {{calculateRate(totalLastMonthRevenue, totalRevenue)}}%
                        </span>
                        <span class="text-nowrap">So với tháng trước</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Tiền Ads</h5>
                            <span class="h2 font-weight-bold mb-0">{{formatCurrencyNumber(totalAds)}}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="ni ni-money-coins"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="mr-2" :class="[(totalLastMonthAds < totalAds) ? 'text-success' : 'text-danger']">
                            <i class="fa" :class="[(totalLastMonthAds < totalAds) ? 'fa-arrow-up' : 'fa-arrow-down']"></i>
                            {{calculateRate(totalLastMonthAds, totalAds)}}%
                        </span>
                        <span class="text-nowrap">So với tháng trước</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Lợi nhuận</h5>
                            <span class="h2 font-weight-bold mb-0">{{formatCurrencyNumber(totalProfit)}} ({{totalProfitRate}}%)</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-chart-bar-32"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="mr-2" :class="[(totalLastMonthProfit < totalProfit) ? 'text-success' : 'text-danger']">
                            <i class="fa" :class="[(totalLastMonthProfit < totalProfit) ? 'fa-arrow-up' : 'fa-arrow-down']"></i>
                            {{calculateRate(totalLastMonthProfit, totalProfit)}}%
                        </span>
                        <span class="text-nowrap">So với tháng trước</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endverbatim
</div>
