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
                <h3 class="mb-0">Tạo sản phẩm</h3>
            </div>
            <!-- Light table -->

            <!-- Card footer -->
            <div class="card-body py-4">
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Tên SP</label>
                    <div class="input-group">
                        <input type="text" v-model="product.name" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Giá</label>
                    <div class="input-group">
                        <input type="number" v-model="product.price" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group" v-if="Object.keys(product.fields).length > 0">
                    <label class="form-control-label" for="basic-url">Các trường</label>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Tên trường</th>
                                <th scope="col" class="sort" data-sort="budget">Giá trị mặc định</th>
                                <th scope="col" class="sort" data-sort="budget">Hành động</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                                <tr v-for="item in product.fields">
                                    <td width="35%">
                                        <div class="input-group">
                                            <input type="text" v-model="item.label" class="form-control" aria-describedby="basic-addon3">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" v-model="item.value" class="form-control" aria-describedby="basic-addon3">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" type="button" @click="removeField(item)">Xóa trường</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" scope="col" class="sort" data-sort="name">
                                        <button class="btn btn-primary" type="button" @click="addField()">Thêm trường</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="addProduct()">Tạo sản phẩm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
