import {global} from '../../../system/storage';
import * as PageModule from '../module';
import axios from "axios";

/**
 * Export main module application for current page.
 */
export default {
    mixins: [
        PageModule.default,
    ],
    data: {
        bm: {
            user_id: global.userId,
            business_name: '',
            business_id: '',
            cookie: '',
            token: '',
            ignored_ada_ids: ''
        },
        message: {},

    },
    methods: {
        saveBm() {
            axios.post('/saveBm', this.bm).then(response => {
                if (response.status == 200) {
                    return {data: response.data, success: true};
                } else {
                    return {data: response.data, success: false};
                }
            }).then(res => {
                let type = res.success ? 'success' : 'danger';
                this.setMessage(type, res.data.message);
            });

        },
        setMessage(type, content) {
            this.message = {
                messageClass: 'alert alert-' + type,
                messageText: content,
            }

            return;
        },
    },
    mounted () {
        this.bm = global.bm;
    }
}
