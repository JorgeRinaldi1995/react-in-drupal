(function ($, Drupal) {
    Drupal.behaviors.productQuantityForm = {
      attach: function (context, settings) {
        $('#edit-quantity', context).once('productQuantityForm').on('input', function () {
          var quantity = $(this).val();
          var pricePerUnit = parseFloat($('#edit-price-per-unit').val());
          var totalPrice = quantity * pricePerUnit;
          $('#total-price').text(totalPrice.toFixed(2));
        });
      }
    };
  })(jQuery, Drupal);