import Vue from "vue";
import moment from "moment";
import 'moment/locale/zh-cn';

Vue.filter('moment', function (value) {
    return moment(value).format('YYYY-MM-DD HH:mm')
})