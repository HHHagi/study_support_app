
$( function ()
{
    console.log('run jquery');
} )

$(function() {
    $('.toggle_target_form').click(function() {
        $(this).nextAll('.toggle_target').slideToggle();
    });
});

$(function() {
    $('.toggle_idea_form').click(function() {
        $(this).nextAll('.toggle_idea').slideToggle();
    });
});

$(function() {
    $('button').click(function() {
        console.log('クリックされました！');
    });
});

$(function() {
    $('.toggle_memo_form').click(function() {
        $(this).parent().parent().nextAll('.toggle_memo').slideToggle();
    });
});

$(function() {
    $('.toggle_target_edit_form').click(function() {
        $(this).parent().parent().nextAll('.toggle_target').slideToggle();
    });
});

$(function() {
    $('.toggle_private_category_form').click(function() {
        $(this).nextAll('.toggle_private_category').slideToggle();
    });
});
