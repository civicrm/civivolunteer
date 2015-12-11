CRM.$(function($) {

  function addProfileRow() {
    var newRowIndex = $("#additionalVolunteers .additional-volunteer-profile").length;
    var container = $(".crm-volunteer-additional-volunteers-template .additional-volunteer-profile").clone(true);
    container.find("input,select").each(function() {

      if($(this).attr("name")) {

        $(this).attr("name", $(this).attr("name").replace("additionalVolunteersTemplate", "additionalVolunteers_" + newRowIndex));

        if($(this).data("name")) {
          //Because of how we are cloning, you have to use both of these.
          //It is strange but it works.
          $(this).data("name", $(this).data("name").replace("additionalVolunteersTemplate", "additionalVolunteers_" + newRowIndex ));
          $(this).attr("data-name", $(this).data("name").replace("additionalVolunteersTemplate", "additionalVolunteers_" + newRowIndex));
        }

        if($(this).data("target")) {
          //Because of how we are cloning, you have to use both of these.
          //It is strange but it works.
          $(this).data("target", $(this).data("target").replace("additionalVolunteersTemplate", "additionalVolunteers_" + newRowIndex));
          $(this).attr("data-target", $(this).data("target").replace("additionalVolunteersTemplate", "additionalVolunteers_" + newRowIndex));
        }
      }
    });

    //Handle Select2s
    container.find(".crm-select2").crmSelect2();


    if(newRowIndex === 0) {
      container.find("input").attr("placeholder", "");
    }

    container.hide();
    $("#additionalVolunteers").append(container);
  }






  /*****[ Change the number of additional volunteers ]*****/

  $("#additionalVolunteerQuantity").change(function(event) {

    if(!$.isNumeric($(this).val()) && $(this).val() !== '') {
      CRM.alert(ts("Please supply a number"));
      return;
    }

    var numberOfExistingRows = $("#additionalVolunteers .additional-volunteer-profile").length;
    var numberRequested = $(this).val();

    //If we need to add rows, do it.
    if (numberOfExistingRows < numberRequested) {
      var numberOfRowsToAdd = numberRequested - numberOfExistingRows;
      var i = 1;
      while (i <= numberOfRowsToAdd) {
        addProfileRow();
        i++;
      }
    }

    //Show and Hide the Profile rows
    $("#additionalVolunteers .additional-volunteer-profile").slice(0, numberRequested).slideDown();
    $("#additionalVolunteers .additional-volunteer-profile").slice(numberRequested).slideUp();
  });



  /*****[ Setup the Template ]*****/
   $(".crm-volunteer-additional-volunteers-template .additional-volunteer-profile input, .crm-volunteer-additional-volunteers-template .additional-volunteer-profile select").each(function() {

     if($(this).is("input")) {
       //Set the placeholder text
       $(this).attr("placeholder", $(this).closest(".crm-section").find(".label").text().replace("*", ""))
         //Clear the value
         .val('');
     } else {
       $(this).find("option").removeAttr('checked').removeAttr('selected');
       if($(this).hasClass("crm-select2")) {
         $(this).select2('destroy');
       }
     }

    //remove conflicting dom ids
    $(this).removeAttr("id");
  });



  /*****[ Handle Return to Form ]****/
  //This will create the forms so we can populate them.
  $("#additionalVolunteerQuantity").change();


});