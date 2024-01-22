

// For toltip
jQuery(document).ready(function($) {
    $('[data-entext-wrapper-link]').each(function() {
        var wrapperLinkData = $(this).data('entext-wrapper-link');
        var tooltipText = wrapperLinkData.tooltip_text;

        $(this).attr('title', tooltipText);
    });
});


