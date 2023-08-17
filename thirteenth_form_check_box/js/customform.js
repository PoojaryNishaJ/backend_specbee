(function ($) {
  Drupal.behaviors.thirteenthFormCheckBox = {
    attach: function (context) {
      // Function to toggle the visibility of the last name textfield.
      function toggleLastNameVisibility() {
        var noLastNameCheckbox = $('#no-last-name');
        var lastNameField = $('#edit-last-name');

        if (noLastNameCheckbox.prop('checked')) {
          lastNameField.hide();
        } else {
          lastNameField.show();
        }
      }

      // Initial state when the page loads.
      toggleLastNameVisibility();

      // Attach an event listener to the checkbox.
      $('#no-last-name').on('change', function () {
        toggleLastNameVisibility();
      });
    }
  };
})(jQuery);
