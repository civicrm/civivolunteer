// http://civicrm.org/licensing
CRM.volunteerApp.module('Define', function(Define, volunteerApp, Backbone, Marionette, $, _) {

  var myViewSettings = {
    tagName: 'tr',
    className: 'crm-vol-define-need',

    onRender: function() {
      this.$el.attr('data-id', this.model.get('id'));
      // TODO: respect user-configured time formats
      this.$("[name='display_start_date']").addClass('dateplugin').datepicker({
        dateFormat: "MM d, yy"
      });
      this.$("[name='display_start_time']").addClass('timeplugin').timeEntry();

      // format the times
      this.$("[name='display_start_time']").timeEntry(
        'setTime',
        this.$("[name='display_start_time']").val()
      );

      var publicVisibilityValue = _.invert(CRM.pseudoConstant.volunteer_need_visibility).Public;

      this.$("[name='visibility_id']").val(publicVisibilityValue);

      this.$("[name='visibility_id']").each(function(){
        if ($(this).data('stored') == publicVisibilityValue) {
          $(this).prop("checked", true);
        }
      });

      this.$("[name='is_active']").each(function(){
        if ($(this).data('stored') == 1) {
          $(this).prop("checked", true);
        }
      });

    }
  };


  Define.layout = Marionette.Layout.extend({
    template: "#crm-vol-define-layout-tpl",
    regions: {
      newNeeds: "#crm-vol-define-needs-region"
    }
  });

  // *** declare a view
  Define.defineNeedsView = Marionette.ItemView.extend(_.extend(myViewSettings, {
    template: '#crm-vol-define-new-need-tpl',
    templateHelpers: {
      pseudoConstant: CRM.pseudoConstant,
      RenderUtil: CRM.volunteerApp.RenderUtil
    }
  }));

  Define.defineNeedsTable = Marionette.CompositeView.extend({
    id: "manage_needs",
    template: "#crm-vol-define-layout-tpl",
    itemView: Define.defineNeedsView,
    itemViewContainer: 'tbody',
    className: 'crm-block crm-form-block crm-event-manage-volunteer-form-block',

    events: {
      'click #addNewNeed': 'addNewNeed',
      'click #crm-vol-define-needs-dialog .sorting' : 'changeSort',
      'change :input': 'updateNeed'
    },

    changeSort: function(sender) {

      Define.sortField = $(sender.currentTarget).attr('id');
      var request = volunteerApp.Entities.getNeeds(true);
      request.done(this.getCollection);
    },

    // no API calls here; this just updates the UI
    addNewNeed: function () {
      var newNeed = new this.collection.model();
      this.collection.add(newNeed);
      this.render();
    },

    updateNeed: function(e) {
      var row = cj(e.currentTarget).closest('tr') ;
      var id = row.data('id');
      var need = {
        id: id,
        project_id: cj('#crm-vol-define-needs-dialog').data('project_id')
      };

      var field_name = e.currentTarget.name;
      var value = e.currentTarget.value;

      switch (field_name) {
        case 'display_start_date':
        case 'display_start_time':
          field_name = 'start_time';
          value = row.find("[name='display_start_date']").val()
            + ' ' + row.find("[name='display_start_time']").val();
          break;
        case 'visibility_id':
          value = e.currentTarget.checked ? e.currentTarget.value
            : _.invert(CRM.pseudoConstant.volunteer_need_visibility).Admin;
          break;
        case 'is_active':
          value = e.currentTarget.checked ? e.currentTarget.value : 0;
          break;
      }
      need[field_name] = value;

      var request = this.collection.createNewNeed(need);
      request.done(function(need_id) {
        if (!row.data('id')) {
          row.data('id', need_id);
        }
      });

      this.collection.createNewNeed(need);
    },

    getCollection :   function(data_array) {
      var needsCollection = new volunteerApp.Entities.Needs(data_array);

        for( index in needsCollection.models) {
          need = needsCollection.models[index];
          if (need.attributes.is_flexible == 1) {
            need.attributes.is_flexible_form_value = 'checked';
          }
        }

        cj('#crm-vol-define-needs-dialog').attr('data-project_id', needsCollection.models[0].attributes.project_id);

        Define.needsTable.collection = needsCollection;

        if (Define.sortField) {
          Define.needsTable.collection.comparator = Define.sortField;
          Define.needsTable.collection.sort();
        }

        Define.needsTable.render();
    },

  });

});
