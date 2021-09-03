$(window).load(function () {
    var select = $(".search-form select:not(.select2)").selectBoxIt().on('open', function () {
        $(this).data('selectBoxSelectBoxIt').list.perfectScrollbar();
    });

    $('.reset-s-btn').on('click', function () {
        $(select).selectBoxIt('selectOption', 0);
    });
})