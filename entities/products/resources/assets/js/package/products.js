let products = {};

products.init = function () {
  if (!window.Admin.vue.modulesComponents.modules.hasOwnProperty('products_finder')) {
    window.Admin.vue.modulesComponents.modules = Object.assign(
        {}, window.Admin.vue.modulesComponents.modules, {
          products_finder: {
            components: [],
          },
        });
  }
};

module.exports = products;
