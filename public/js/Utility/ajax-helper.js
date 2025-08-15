/**
 * AJAX Helper Utility
 * Usage:
 * ajaxRequest(url, method, data, successCallback, errorCallback);
 */
window.ajaxRequest = function (url, method, data, successCallback = null, errorCallback = null) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function (response) {
            if (typeof successCallback === 'function') {
                successCallback(response);
            } else {
                console.log('Success:', response);
            }
        },
        error: function (err) {
            if (typeof errorCallback === 'function') {
                errorCallback(err);
            } else {
                console.error('Error:', err);
                alert('An error occurred');
            }
        }
    });
};
