<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tạo đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="modal-body p-4">
                    @verbatim
                    <!-- Text input -->
                    <div class="row mb-4">
                        <div class="col">
                            <button v-for="product in products"
                                    type="button"
                                    class="btn btn-outline-primary"
                                    v-bind:class="{ active: product.name==useProduct.name }"
                                    @click="setUseProduct(product)"
                            >
                                {{product.name}}
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="form6Example1" style="margin-left: 0px;">Tên khách</label>
                                <input type="text" id="form6Example1" class="form-control" v-model="tmpOrder.customer_name">
                                <div class="form-notch">
                                    <div class="form-notch-leading" style="width: 9px;"></div>
                                    <div class="form-notch-middle" style="width: 68.8px;"></div>
                                    <div class="form-notch-trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="form6Example2" style="margin-left: 0px;">Số ĐT</label>
                                <input type="number"
                                       id="form6Example2"
                                       class="form-control"
                                       v-model="tmpOrder.phone"
                                       pattern="(\+84|0){1}(9|8|7|5|3){1}[0-9]{8}"
                                       v-on:keyup="getCustomer()">
                                <div class="form-notch">
                                    <div class="form-notch-leading" style="width: 9px;"></div>
                                    <div class="form-notch-middle" style="width: 68px;"></div>
                                    <div class="form-notch-trailing"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Text input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form6Example4" style="margin-left: 0px;">Địa chỉ</label>
                        <input type="text" id="form6Example4" class="form-control" v-model="tmpOrder.address">
                        <div class="form-notch">
                            <div class="form-notch-leading" style="width: 9px;"></div>
                            <div class="form-notch-middle" style="width: 55.2px;"></div>
                            <div class="form-notch-trailing"></div>
                        </div>
                    </div>

                    <!-- Text input -->
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="form6Example4" style="margin-left: 0px;">COD</label>
                                <input type="text" id="form6Example4" class="form-control" v-model="total">
                                <div class="form-notch">
                                    <div class="form-notch-leading" style="width: 9px;"></div>
                                    <div class="form-notch-middle" style="width: 55.2px;"></div>
                                    <div class="form-notch-trailing"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label" for="form6Example2" style="margin-left: 0px;">Số lượng</label>
                                <input type="number" id="form6Example2" class="form-control" v-model="tmpOrder.qty">
                                <div class="form-notch">
                                    <div class="form-notch-leading" style="width: 9px;"></div>
                                    <div class="form-notch-middle" style="width: 68px;"></div>
                                    <div class="form-notch-trailing"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form6Example3" style="margin-left: 0px;">Sản phẩm</label>
                        <input type="text" id="form6Example3" class="form-control" v-model="useProduct.name">
                        <div class="form-notch">
                            <div class="form-notch-leading" style="width: 9px;"></div>
                            <div class="form-notch-middle" style="width: 97.6px;"></div>
                            <div class="form-notch-trailing"></div>
                        </div>
                    </div>

                    <div class="form-outline mb-4" v-if="Object.keys(useProduct).length > 0">
                        <div class="col col-md-3" v-for="fieldItem in parseCustomFields(useProduct.custom_fields)">
                            <label class="form-label" for="form6Example3" style="margin-left: 0px;">{{fieldItem.label}}</label>
                            <input type="text" id="form6Example3" class="form-control" v-model="fieldItem.value">
                            <div class="form-notch">
                                <div class="form-notch-leading" style="width: 9px;"></div>
                                <div class="form-notch-middle" style="width: 97.6px;"></div>
                                <div class="form-notch-trailing"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Message input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form6Example7" style="margin-left: 0px;">Ghi chú</label>
                        <textarea class="form-control" id="form6Example7" rows="4" v-model="tmpOrder.note"></textarea>
                        <div class="form-notch">
                            <div class="form-notch-leading" style="width: 9px;"></div>
                            <div class="form-notch-middle" style="width: 135.2px;"></div>
                            <div class="form-notch-trailing"></div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="button" class="btn btn-primary btn-block" @click="addOrder()">Tạo đơn</button>
                    @endverbatim
                </div>
            </div>
        </div>
    </div>
</div>
