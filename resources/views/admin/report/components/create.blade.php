<div class="row">
    <div class="col">
        <div class="card">
            @verbatim
                <div v-bind:class="[message.messageClass]">
                    {{ message.messageText }}
                </div>
             @endverbatim
            <!-- Card header -->
            <div class="card-header border-0">
                <h3 class="mb-0">Tạo Báo cáo</h3>
            </div>
            <!-- Light table -->

            <!-- Card footer -->
            <div class="card-body py-4">
                <div class="row">
                    <div class="col col-md-2">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Kênh chạy</label>
                            <div class="input-group">
                                @verbatim
                                    <select v-model="report.source" class="form-select form-select-lg custom-select" aria-label="Default select example">
                                        <option v-for="item in global.sources" :value="item">
                                            {{item}}
                                        </option>
                                    </select>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tháng</label>
                            <div class="input-group">
                                @verbatim
                                    <select v-model="report.month" class="form-select form-select-lg custom-select" aria-label="Default select example">
                                        <option v-for="month in global.months" :value="month">
                                            {{month}}
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
                                <select v-model="report.product_id" class="form-select form-select-lg custom-select" aria-label="Default select example">
                                    <option v-for="(item, key) in products" :value="item.id">
                                        {{item.name}}
                                    </option>
                                </select>
                                @endverbatim
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="addReport()">Tạo báo cáo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
