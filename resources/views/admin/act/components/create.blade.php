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
                <h3 class="mb-0">Thêm TK</h3>
            </div>
            <!-- Light table -->

            <!-- Card footer -->
            <div class="card-body py-4">
                <input type="hidden" v-model="act.user_id" class="form-control" aria-describedby="basic-addon3">
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Tên TK</label>
                    <div class="input-group">
                        <input type="text" v-model="act.act_name" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">ID TK</label>
                    <div class="input-group">
                        <input type="text" v-model="act.act_id" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Token</label>
                    <div class="input-group">
                        <input type="text" v-model="act.token" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-control-label" for="basic-url">Cookie</label>
                    <div class="input-group">
                        <input type="text" v-model="act.cookie" class="form-control" aria-describedby="basic-addon3">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-success" type="button" @click="addAct()">Thêm TK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
