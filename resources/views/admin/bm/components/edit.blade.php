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
                <h3 class="mb-0">Thêm BM</h3>
            </div>
            <!-- Light table -->

            <!-- Card footer -->
            <div class="card-body py-4">
                <input type="hidden" v-model="bm.user_id" class="form-control" aria-describedby="basic-addon3">
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Tên BM</label>
                    <div class="input-group">
                        <input type="text" v-model="bm.business_name" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">BM ID</label>
                    <div class="input-group">
                        <input type="text" v-model="bm.business_id" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
				<div class="form-group">
                    <label class="form-control-label" for="basic-url">Cookie</label>
                    <div class="input-group">
                        <input type="text" v-model="bm.cookie" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Token</label>
                    <div class="input-group">
                        <input type="text" v-model="bm.token" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Account loại trừ</label><br>
                    <i>Thêm id những ad account không muốn gửi thông báo vào đây (ngăn cách bới dấu ,)</i>
                    <div class="input-group">
                        <input type="text" v-model="bm.ignored_ada_ids" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="saveBm()">Lưu nhể</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
