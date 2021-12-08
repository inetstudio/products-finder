import {products} from './package/products';

require('./plugins/tinymce/plugins/products_finder');

require('../../../../../../widgets/entities/widgets/resources/assets/js/mixins/widget');

window.Vue.component(
    'ProductCardWidget',
    () => import('./components/partials/ProductCardWidget/ProductCardWidget.vue'),
);

products.init();
