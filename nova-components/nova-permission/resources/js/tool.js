Nova.booting((Vue, router, store) => {
    Vue.component('index-group-checkbox-list-field', require('./components/Index').default);
    Vue.component('detail-group-checkbox-list-field', require('./components/Detail').default);
    Vue.component('form-group-checkbox-list-field', require('./components/Form').default);
});
