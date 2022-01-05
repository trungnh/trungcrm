<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="mb-0">Danh sách BM</h3>
                        <img v-show="loading" src="/assets/img/loading.gif" style="height: 40px;">
                    </div>
                    <div class="col-md-2">
                        <button @click="reload()" class="btn btn-primary">Reload</button>
                    </div>
                </div>
            </div>
            <div class="card" v-for="bm in bmData">
                <div class="card-header border-0">
                    @verbatim
                    <h3 class="mb-0">BM: {{bm.business_name}} - {{bm.business_id}}</h3>
                    @endverbatim
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Tên BM</th>
                            <th scope="col" class="sort" data-sort="budget">ACCOUNT</th>
                            <th scope="col" class="sort" data-sort="status">ACT ID</th>
                            <th scope="col" class="sort" data-sort="status">STATUS</th>
                            <th scope="col" class="sort" data-sort="status">ĐÃ TIÊU</th>
                            <th scope="col" class="sort" data-sort="status">NGƯỠNG</th>
                            <th scope="col" class="sort" data-sort="status">CURRENCY</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @verbatim
                            <tr v-for="item in bm.ad_account" v-bind:class="rowClass(item.status, item.payment)">
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{item.business.businessName}}</span>
                                        </div>
                                    </div>
                                </th>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{item.name}}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    {{item.actId}}
                                </td>
                                <td class="status">
                                    {{statusIdToText(item.status)}}
                                </td>
                                <td class="budget">
                                    {{formatNumber(item.payment.currentBilling)}}
                                </td>
                                <td class="budget">
                                    {{formatNumber(item.payment.threshold)}}
                                </td>
                                <td>
                                    {{item.currency}}
                                </td>
                            </tr>
                        @endverbatim
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Card footer -->
        </div>
    </div>
</div>
