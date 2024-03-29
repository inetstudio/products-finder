import Swal from 'sweetalert2';

window.tinymce.PluginManager.add('products_finder', function(editor) {
  let widgetData = {
    widget: {
      events: {
        widgetSaved: function(model) {
          let alt = model.additional_info.title.replace(/['"]+/g, '');

          editor.execCommand('mceReplaceContent', false,
              '<img class="content-widget" data-type="products_finder" data-id="' +
              model.id + '" alt="Виджет-продуктовая карточка ('+alt+')" />',
          );
        },
      },
    },
  };

  function loadWidget() {
    let component = window.Admin.vue.helpers.getVueComponent('products_finder', 'ProductCardWidget');

    component.$data.model.id = widgetData.model.id;
  }

  editor.addButton('add_products_finder_card_widget', {
    title: 'Карточка Product Finder',
    icon: 'fa fa-search-dollar',
    onclick: function() {
      let content = editor.selection.getContent();

      let isProductCard = /<img class="content-widget".+data-type="products_finder".+>/g.test(
          content);

      if (content === '' || isProductCard) {
        widgetData.model = {
          id: parseInt($(content).attr('data-id')) || 0,
        };

        window.Admin.vue.helpers.initComponent('products_finder', 'ProductCardWidget', widgetData);

        window.waitForElement('#add_products_finder_card_widget_modal', function() {
          loadWidget();

          $('#add_products_finder_card_widget_modal').modal();
        });
      } else {
        Swal.fire({
          title: 'Ошибка',
          text: 'Необходимо выбрать виджет-продуктовая карточка',
          icon: 'error'
        });

        return false;
      }
    }
  });
});
