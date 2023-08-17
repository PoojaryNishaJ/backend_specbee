(function ($, Drupal) {
  //alert("works");
  $(document).ready(function() {

    var checkbox = $('#no-last-name');
    var lastname = $('.js-form-item');

    if (checkbox.is(':checked')) {
        lastname.hide();
    }
    checkbox .on('change', function() {
      if ($(this).is(':checked')) {
        lastname.hide();
      }
      else {
        lastname.show();
      }
    });
  });
}(jquery, Drupal));
