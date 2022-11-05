<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body py-4">
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Account loại trừ</label><br>
                    <i>Thêm id những ad account không muốn gửi thông báo vào đây (ngăn cách bới dấu ,)</i>
                    <div class="input-group">
                        <input type="text" v-model="ignored_ada_ids" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="addAdaIgnoreIds()">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
