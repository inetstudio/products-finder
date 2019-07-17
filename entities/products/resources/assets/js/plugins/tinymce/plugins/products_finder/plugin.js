window.tinymce.PluginManager.add('products_finder', function(editor) {
  let widgetData = {
    widget: {
      events: {
        widgetSaved: function(model) {
          editor.execCommand('mceReplaceContent', false,
              '<img class="content-widget" data-type="products_finder" data-id="' +
              model.id + '" alt="Виджет-продуктовая карточка ('+model.additional_info.title+')" />',
          );
        },
      },
    },
  };

  function initProductsFinderComponents() {
    if (typeof window.Admin.vue.modulesComponents.$refs['products_finder_ProductCardWidget'] ==
        'undefined') {
      window.Admin.vue.modulesComponents.modules.products_finder.components = _.union(
          window.Admin.vue.modulesComponents.modules.products_finder.components, [
            {
              name: 'ProductCardWidget',
              data: widgetData,
            },
          ]);
    } else {
      let component = window.Admin.vue.modulesComponents.$refs['products_finder_ProductCardWidget'][0];

      component.$data.model.id = widgetData.model.id;
    }
  }

  editor.addButton('add_products_finder_card_widget', {
    title: 'Продуктовая карточка',
    icon: 'fa fa-search-dollar',
    onclick: function() {
      let content = editor.selection.getContent();

      let isProductCard = /<img class="content-widget".+data-type="products_finder".+>/g.test(
          content);

      if (content === '' || isProductCard) {
        widgetData.model = {
          id: parseInt($(content).attr('data-id')) || 0,
        };

        initProductsFinderComponents();

        window.waitForElement('#add_products_finder_card_widget_modal', function() {
          $('#add_products_finder_card_widget_modal').modal();
        });
      } else {
        swal({
          title: 'Ошибка',
          text: 'Необходимо выбрать виджет-продуктовая карточка',
          type: 'error'
        });

        return false;
      }
    }
  });
});
