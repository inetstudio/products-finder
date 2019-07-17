<template>
    <div id="add_products_finder_card_widget_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade"
         ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Продуктовая карточка</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <div class="row products_table"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ProductCardWidget',
    data() {
      return {
        model: this.getDefaultModel(),
        options: {
          loading: true,
        },
        events: {}
      };
    },
    methods: {
      getDefaultModel() {
        return _.merge(this.getDefaultWidgetModel(), {
          view: 'admin.module.products-finder.products::front.partials.content.product_card_widget',
          params: {
            id: 0
          }
        });
      },
      initComponent() {
        let component = this;

        component.model = _.merge(component.model, this.widget.model);

        let url = route('back.products-finder.products.datatables.html', {
          service: 'card-widget'
        }).toString();

        let data = {
            id: 'add_products_finder_card_widget_modal_table'
        };

        axios.post(url, data).then(response => {
          $(component.$refs.modal).find('.products_table').html(response.data);

          url = route('back.products-finder.products.datatables.options', {
            service: 'card-widget'
          }).toString();

          axios.get(url).then(response => {
            (
                function(window, $){
                  window.LaravelDataTables = window.LaravelDataTables || {};
                  window.LaravelDataTables[data.id] = $("#"+data.id).DataTable(response.data);
                }
            )(window,jQuery);

            component.options.loading = false;
          });
        });
      },
      save() {
        let component = this;

        if (component.model.params.id === 0) {
          $(component.$refs.modal).modal('hide');

          return;
        }

        component.saveWidget(function() {
          $(component.$refs.modal).modal('hide');
        });
      },
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.model = component.getDefaultModel();
        });

        $(component.$refs.modal).on('click', '.add-product', function (event) {
          event.preventDefault();

          component.model.params.id = parseInt($(this).attr('data-product'));
          component.model.additional_info.title = $(this).attr('data-title');
          component.save();
        });
      });
    },
    mixins: [
      window.Admin.vue.mixins['widget'],
    ],
  };
</script>

<style scoped>
</style>
