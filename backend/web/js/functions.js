function displaySuccessMessage(message) {
    $('.info-message').text(message);
    setTimeout(function() {
        $('.info-message').text('');
    }, 3000)
}
function displayErrorMessage(message) {
    $('.info-message').addClass('error').text(message);
    setTimeout(function() {
        $('.info-message').text('');
    }, 3000)
}

function initPlugins() {
    $('.chosen').chosen()
    $(".select-time").inputmask({"mask": "99:99"});
    $(".phone-mask").inputmask({"mask": "+7 (999) 999-99-99"});
}

