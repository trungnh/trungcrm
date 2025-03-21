<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Bộ lọc</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-2">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tháng</label>
                            <div class="input-group">
                                @verbatim
                                    <select v-model="filterMonth" class="form-select form-select-lg custom-select" aria-label="Default select example" @change="changeMonth">
                                        <option></option>
                                        <option v-for="item in global.monthsInFilter" :value="item">
                                            {{item}}
                                        </option>
                                    </select>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2" v-if="showFilter()">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Người tạo</label>
                            <div class="input-group">
                                @verbatim
                                    <select v-model="filterUser" class="form-select form-select-lg custom-select" aria-label="Default select example" @>
                                        <option></option>
                                        <option v-for="item in global.usersInFilter" :value="item">
                                            {{item}}
                                        </option>
                                    </select>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Sản phẩm</label>
                            <div class="input-group">
                                @verbatim
                                    <select v-model="filterProduct" class="form-select form-select-lg custom-select" aria-label="Default select example">
                                        <option></option>
                                        <option v-for="item in global.productsInFilter" :value="item">
                                            {{item}}
                                        </option>
                                    </select>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Báo cáo theo thời gian</label>
                            <div class="input-group">
                                @verbatim
                                    <input type="checkbox" v-model="rangeReport"/>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" v-if="rangeReport">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Chọn thời gian</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-2">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Bắt đầu</label>
                            <div class="input-group">
                                @verbatim
                                    <select v-model="fromMonth" class="form-select form-select-lg custom-select" aria-label="Default select example">
                                        <option></option>
                                        <option v-for="item in global.monthsInFilter" :value="item">
                                            {{item}}
                                        </option>
                                    </select>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Kết thúc</label>
                            <div class="input-group">
                                @verbatim
                                    <select v-model="toMonth" class="form-select form-select-lg custom-select" aria-label="Default select example">
                                        <option></option>
                                        <option v-for="item in global.monthsInFilter" :value="item">
                                            {{item}}
                                        </option>
                                    </select>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="reportByRange">Xem báo cáo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Danh sách báo cáo</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="sort" data-sort="name">Tháng</th>
                        <th scope="col" class="sort" data-sort="name">Sản phẩm</th>
                        <th scope="col" class="sort" data-sort="name">Tổng đơn</th>
                        <th scope="col" class="sort" data-sort="name">Tiền ads</th>
                        <th scope="col" class="sort" data-sort="name">Lợi nhuận</th>
                        <th scope="col" class="sort" data-sort="name">Doanh thu</th>
                        <th scope="col" class="sort" data-sort="name">ROAS</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @verbatim
                    <tr v-for="item in filteredReports">
                        <th scope="row">
                            <a :href="getEditLink(item.id)" class="text-green">{{getReportName(item.name, item.user.name)}}</a>
                        </th>
                        <th scope="row">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <span class="name mb-0 text-sm">
                                        <a :href="getEditLink(item.id)">{{item.month}}</a>
                                    </span>
                                </div>
                            </div>
                        </th>
                        <td scope="row">
                            <span class="name mb-0 text-sm">
                                <a :href="getEditLink(item.id)">{{item.product.name}}</a>
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-sm">
                                {{item.orders}}
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-sm">
                                {{formatCurrencyNumber(item.totalAds)}}
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-sm font-weight-bold text-green">
                                {{formatCurrencyNumber(item.totalProfit)}}
                            </span>
                            &nbsp;<span class="text-green" :class="{'invisible': hideByRole}"><small>({{formatNumber((item.totalProfit / item.totalRevenue)*100)}}%)</small></span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-sm font-weight-bold text-red">
                                {{formatCurrencyNumber(item.totalRevenue)}}
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-sm font-weight-bold">
                                {{formatNumber(item.roas)}}
                            </span>
                        </td>

                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" :href="getEditLink(item.id)">Sửa</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <th scope="row"></th>
                        <td scope="row">Tổng: </td>
                        <td scope="row">
                            <span class="name mb-0 text-sm font-weight-bold">
                                {{totalOrders}}
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-sm font-weight-bold">
                                {{formatCurrencyNumber(totalAds)}}
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-lg text-red font-weight-bold">
                                {{formatCurrencyNumber(totalProfit)}}
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-lg text-red font-weight-bold">
                                {{formatCurrencyNumber(totalRevenue)}}
                            </span>
                        </td>
                        <td scope="row">
                            <span class="name mb-0 text-lg font-weight-bold">
                                {{formatNumber(totalRevenue / totalAds)}}
                            </span>
                        </td>

                        <td class="text-right"></td>
                    </tr>
                    @endverbatim
                    </tbody>
                </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
                <nav aria-label="...">
                    <ul class="pagination justify-content-end mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">
                                <i class="fas fa-angle-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-angle-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
