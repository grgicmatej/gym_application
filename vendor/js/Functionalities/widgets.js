// widgets
function successNotification(message) {
    $(this).fadeIn(400, function notification() {
        toastr.success(message)
    });
}

function infoNotification(message) {
    $(this).fadeIn(400, function notification() {
        toastr.info(message)
    });
}

function errorNotification(message) {
    $(this).fadeIn(400, function notification() {
        toastr.error(message)
    });
}

function warningNotification(message) {
    $(this).fadeIn(400, function notification() {
        toastr.warning(message)
    });
}
// widgets end
