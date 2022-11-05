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
        bms: [],
        bm: {
            user_id: global.userId,
            name: '',
            id: '',
        }
    },
    methods: {
        setItems: function () {
            if (global.bms) {
                this.bms = global.bms;
            }
        },
    },
    mounted () {
        this.setItems();
    }
}
