jQuery(document).ready(function ($) {
  var $formElement = $form;

  // Target password fields by CSS classes
  // You'll need to identify the appropriate classes to use
  var passwordField = $formElement.find(".primary-password-class"); // Replace with actual class
  var confirmPasswordField = $formElement.find(".confirm-password-class"); // Replace with actual class

  // Alternatively, use a combination of type and custom class
  // var passwordField = $formElement.find('input[type="password"].primary-password');
  // var confirmPasswordField = $formElement.find('input[type="password"].confirm-password');

  // Only proceed if we found both password fields
  if (passwordField.length && confirmPasswordField.length) {
    var validatePasswords = function () {
      var password = passwordField.val();
      var confirmPassword = confirmPasswordField.val();

      var $errorContainer = confirmPasswordField.closest(".ff-el-group").find(".password-match-error");

      if ($errorContainer.length === 0) {
        confirmPasswordField.closest(".ff-el-group").append('<div class="password-match-error" style="color: #f56c6c; margin-top: 5px; display: none;">Passwords do not match</div>');
        $errorContainer = confirmPasswordField.closest(".ff-el-group").find(".password-match-error");
      }

      if (password !== confirmPassword) {
        $errorContainer.show();
        confirmPasswordField.addClass("ff-el-is-error");
        return false;
      } else {
        $errorContainer.hide();
        confirmPasswordField.removeClass("ff-el-is-error");
        return true;
      }
    };

    // Event listeners remain the same
    confirmPasswordField.on("input", function () {
      validatePasswords();
    });

    passwordField.on("input", function () {
      if (confirmPasswordField.val().length > 0) {
        validatePasswords();
      }
    });

    $formElement.on("submit", function (event) {
      if (!validatePasswords()) {
        event.preventDefault();
        return false;
      }
    });
  }
});
