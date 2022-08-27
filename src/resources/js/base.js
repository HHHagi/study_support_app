
$( function ()
{
    console.log('run jquery');
} )

$(function() {
    $('button').click(function() {
        $(this).next('div').slideToggle();
    });
});

$(function() {
    $('button').click(function() {
        console.log('クリックされました！');
    });
});

