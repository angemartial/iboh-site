/**
 * Created by Eliket-Grp on 25/06/2018.
 */

window.onload = function () {
    $(document).on('click', '#sale-btn', function (e) {
        e.preventDefault();
        $('#sale-form').show('fast');
        $('#rent-form').hide('fast');
    });
    $(document).on('click', '#rent-btn', function (e) {
        e.preventDefault();
        $('#rent-form').show('fast');
        $('#sale-form').hide('fast');
    });
};