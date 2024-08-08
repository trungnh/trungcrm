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
        product: global.product,
        message: {}

    },
    methods: {
        saveProduct() {
            axios.post('/saveProduct/' + this.product.id, this.product).then(response => {
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
        }

    },
    computed: {

    },
    mounted () {
    }
}
