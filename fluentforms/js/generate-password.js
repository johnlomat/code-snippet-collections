/**
 * Password generator for Fluent Forms
 * Automatically generates a secure 16-character password and assigns it to a hidden password field
 */
jQuery(document).ready(function ($) {
    var $formElement = $form;
    const $passwordField = $formElement.find('input[name="password"]');
    
    // Function to generate a secure password
    function generatePassword(length = 16) {
        const uppercaseChars = 'ABCDEFGHJKLMNPQRSTUVWXYZ';  // Excluding I and O (can be confused with 1 and 0)
        const lowercaseChars = 'abcdefghijkmnopqrstuvwxyz'; // Excluding l (can be confused with 1)
        const numberChars = '23456789';                     // Excluding 0 and 1 (can be confused with O and l)
        const symbolChars = '!@#$%^&*()_-+=<>?';
        
        const allChars = uppercaseChars + lowercaseChars + numberChars + symbolChars;
        let password = '';
        
        // Ensure at least one character from each category
        password += uppercaseChars.charAt(Math.floor(Math.random() * uppercaseChars.length));
        password += lowercaseChars.charAt(Math.floor(Math.random() * lowercaseChars.length));
        password += numberChars.charAt(Math.floor(Math.random() * numberChars.length));
        password += symbolChars.charAt(Math.floor(Math.random() * symbolChars.length));
        
        // Fill the rest of the password
        for (let i = 4; i < length; i++) {
            password += allChars.charAt(Math.floor(Math.random() * allChars.length));
        }
        
        // Shuffle the password characters
        return password.split('').sort(() => 0.5 - Math.random()).join('');
    }
    
    if ($passwordField.length) {
        // Generate the password and set it to the hidden field
        const newPassword = generatePassword(16);
        $passwordField.val(newPassword);
    }
});