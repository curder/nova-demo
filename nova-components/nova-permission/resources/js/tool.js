Nova.booting((Vue, router, store) => {
    Vue.component('index-group-checkbox-list-field', require('./components/Index'));
    Vue.component('detail-group-checkbox-list-field', require('./components/Detail'));
    Vue.component('form-group-checkbox-list-field', require('./components/Form'));
});
