<div class="row">
    <div class="col">
        <div class="card">
            @verbatim
                <div v-bind:class="[message.messageClass]">
                    {{ message.messageText }}
                </div>
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Sửa Báo cáo <span class="text-green">{{ report.name }}</span></h3>
            </div>
            @endverbatim
            <!-- Light table -->

            <!-- Card footer -->
            <div class="card-body py-4">
                @verbatim
                <div class="float-left">
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Tỉ lệ hoàn</span>
                                </div>
                                <input class="form-control" v-model="report.return_rate" @change="handleRateChange" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Giá nhập</span>
                                </div>
                                <input class="form-control" v-model="report.product_unit_price" @change="handleRateChange" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Phí ship</span>
                                </div>
                                <input class="form-control" v-model="report.shipping_rate" @change="handleRateChange" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Thuế thu nhập</span>
                                </div>
                                <input class="form-control" v-model="report.tax_rate" @change="handleRateChange" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Thuế ads</span>
                                </div>
                                <input class="form-control" v-model="report.ads_tax_rate" @change="handleRateChange" type="text">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="float-left total-block">
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Tiền hàng</span>
                                </div>
                                <span class="form-control font-weight-bold text-lg text-red">{{formatCurrencyNumber(totalUnitPrice)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Tiền Ads</span>
                                </div>
                                <span class="form-control font-weight-bold text-lg text-red">{{formatCurrencyNumber(totalAds)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Doanh thu</span>
                                </div>
                                <span class="form-control font-weight-bold text-lg text-red">{{formatCurrencyNumber(totalRevenue)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Lợi nhuận</span>
                                </div>
                                <span class="form-control font-weight-bold text-red text-lg bg-yellow">{{formatCurrencyNumber(totalProfit)}} ({{formatCurrencyNumber(totalProfitRate)}}%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                @endverbatim
            </div>

            <div class="card-footer py-4">
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="saveReport">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
