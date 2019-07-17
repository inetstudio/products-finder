require('./plugins/tinymce/plugins/products_finder');
require('../../../../../../widgets/resources/assets/js/mixins/widget');

Vue.component(
    'ProductCardWidget',
    require('./components/partials/ProductCardWidget/ProductCardWidget.vue').default,
);

let products = require('./package/products');
products.init();
