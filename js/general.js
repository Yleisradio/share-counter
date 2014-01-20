
jQuery(document).ready(function() {
    initializeTimeago();
//    $('.tooltip').tooltip();
});

function initializeTimeago() {
    jQuery("abbr.timeago").timeago();
}

function pad(n) {
    return n < 10 ? '0' + n : n
}

function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
}

function truncate(string, length) {
    if (string.length > length) {
        return string.slice(0, length) + '...';
    }
    else {
        return string;
    }
}