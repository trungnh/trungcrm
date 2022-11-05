<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Danh sách BM</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="name">Tên BM</th>
                        <th scope="col" class="sort" data-sort="budget">BM ID</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    @verbatim
                    <tr v-for="item in bms">
                        <th scope="row">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <span class="name mb-0 text-sm">{{item.name}}</span>
                                </div>
                            </div>
                        </th>
                        <td class="budget">
                            {{item.id}}
                        </td>
                    </tr>
                    @endverbatim
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
