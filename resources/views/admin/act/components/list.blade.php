<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Danh sách TK</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="name">Tên TK</th>
                        <th scope="col" class="sort" data-sort="budget">ID TK</th>
                        <th scope="col" class="sort" data-sort="status">Token</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @verbatim
                    <tr v-for="item in acts">
                        <th scope="row">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <span class="name mb-0 text-sm">{{item.act_name}}</span>
                                </div>
                            </div>
                        </th>
                        <td class="budget">
                            {{item.act_id}}
                        </td>
                        <td>
                            Đéo hiện đâu
                        </td>
                        <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" :href="getEditUrl(item.id)">Sửa TK</a>
                                    <a class="dropdown-item" href="#" @click="removeBm(item.id)">Xóa TK</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endverbatim
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
