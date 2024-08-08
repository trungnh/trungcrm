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
                <h3 class="mb-0">Sửa sản phẩm</h3>
            </div>
            <!-- Light table -->

            <!-- Card footer -->
            <div class="card-body py-4">
                <div class="row">
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tên SP</label>
                            <div class="input-group">
                                <input type="text" v-model="product.name" class="form-control" aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Từ khóa (đồng bộ camp FB)</label>
                            <div class="input-group">
                                <input type="text" v-model="product.keyword" class="form-control" aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Giá nhập (đơn vị)</label>
                            <div class="input-group">
                                <input type="number" v-model="product.unit_price" class="form-control" aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Giá bán</label>
                            <div class="input-group">
                                <input type="number" v-model="product.price" class="form-control" aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Giá Ship</label>
                            <div class="input-group">
                                <input type="number" v-model="product.shipping_price" class="form-control" aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">Tỉ lệ hoàn</label>
                            <div class="input-group">
                                <input type="number" v-model="product.return_rate" class="form-control" aria-describedby="basic-addon3">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="saveProduct()">Lưu sản phẩm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
