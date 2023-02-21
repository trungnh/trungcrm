<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Danh sách sản phẩm</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="sort" data-sort="name">Tháng</th>
                        <th scope="col" class="sort" data-sort="name">Sản phẩm</th>
                        <th scope="col" class="sort" data-sort="name">Tổng đơn</th>
                        <th scope="col" class="sort" data-sort="name">Tiền ads</th>
                        <th scope="col" class="sort" data-sort="name">Lợi nhuận</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @verbatim
                    <tr v-for="item in reports">
                        <th scope="row">
                            <a :href="getEditLink(item.id)" class="text-green">{{ item.name }}</a>
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
                            <span class="name mb-0 text-sm font-weight-bold text-red">
                                {{formatCurrencyNumber(item.totalProfit)}}
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
