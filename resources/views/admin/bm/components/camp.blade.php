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
                </div>
            </div>

            <div class="card">
                @verbatim
                <div class="card-header border-0">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="form-control-label col-md-4" for="bm">Chọn BM</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <select v-model="selectedBM" name="bm">
                                            <option v-for="(item, index) in bmData" v-bind:value="item">{{item.business_name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="selectedBM">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="form-control-label col-md-4" for="ada">Chọn Ad account</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <select v-model="selectedAda" name="ada">
                                            <option v-for="ada in selectedBM.ad_account" v-bind:value="ada.accountId">{{ada.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="form-control-label col-md-4" for="ada">Chọn thời gian</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <date-range-picker
                                            v-model="dateRange"
                                            @update="updateValues"
                                            :locale-data="locale"
                                        >
                                            <!--Optional scope for the input displaying the dates -->
                                            <template v-slot:input="picker">
                                                {{ formatDisplayDate(picker.startDate) }} ~ {{ formatDisplayDate(picker.endDate) }}
                                            </template>
                                        </date-range-picker>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <button @click="loadData()" class="btn btn-primary">Lấy data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endverbatim
                <!-- Light table -->
                <div class="table-responsive" v-if="campData.length > 0">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Chiến dịch</th>
                            <th scope="col" class="sort" data-sort="budget">TRạng thái</th>
                            <th scope="col" class="sort" data-sort="status">Chi tiêu</th>
                            <th scope="col" class="sort" data-sort="status">kết quả</th>
                            <th scope="col" class="sort" data-sort="status">clicks</th>
                            <th scope="col" class="sort" data-sort="status">ctr</th>
                            <th scope="col" class="sort" data-sort="status">reach</th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        @verbatim
                            <tr v-for="item in campData" v-bind:class="rowClass(item.status, '')">
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{item.name}}</span>
                                        </div>
                                    </div>
                                </th>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{item.status}}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    {{formatNumber(item.spent)}}
                                </td>
                                <td class="status">
                                    {{item.result}}
                                </td>
                                <td class="budget">
                                    {{item.clicks}}
                                </td>
                                <td class="budget">
                                    {{item.ctr}}
                                </td>
                                <td>
                                    {{item.reach}}
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
