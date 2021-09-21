<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="mb-0">Danh sách đơn hàng</h3>
                    </div>
                    <div class="col-md-8">
                        <button type="button" class="btn btn-block btn-success col-md-3 float-right" data-toggle="modal" data-target="#modal-form">Tạo đơn</button>
                    </div>
                </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="sort" data-sort="name">Khách hàng</th>
                        <th scope="col" class="sort" data-sort="budget">Số ĐT</th>
                        <th scope="col" class="sort" data-sort="status">Địa chỉ</th>
                        <th scope="col" class="sort" data-sort="status">Sản phẩm</th>
                        <th scope="col" class="sort" data-sort="status">Tổng tiền</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @verbatim
                    <tr v-for="(item, index) in orders">
                        <td width="3%">
                            {{index+1}}
                        </td>
                        <th scope="row">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <span class="name mb-0 text-sm">{{item.customer_name}}</span>
                                </div>
                            </div>
                        </th>
                        <td class="budget">
                            {{item.phone}}
                        </td>
                        <td class="budget">
                            {{item.address}}
                        </td>
                        <td class="budget">
                            <ul>
                                <li v-for="oItem in item.order_items">
                                    {{oItem.qty}} x {{oItem.product_name}}<span v-if="oItem.extra_information != ''">: {{oItem.extra_information}}</span>
                                </li>
                            </ul>
                        </td>
                        <td class="budget">
                            {{item.total}}
                        </td>
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endverbatim
                    </tbody>
                </table>
            </div>
            <!-- Card footer -->
            @include('admin.partials.pagination')
        </div>
    </div>
</div>
