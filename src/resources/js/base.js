
$(function () {
    console.log('run jquery');
})

$(function () {
    $('.toggle_target_form').click(function () {
        $(this).nextAll('.toggle_target').slideToggle();
    });
});

$(function () {
    $('.toggle_idea_form').click(function () {
        $(this).nextAll('.toggle_idea').slideToggle();
    });
});

$(function () {
    $('button').click(function () {
        console.log('クリックされました！');
    });
});

$(function () {
    $('.toggle_memo_form').click(function () {
        $(this).parent().parent().nextAll('.toggle_memo').slideToggle();
    });
});

$(function () {
    $('.toggle_target_edit_form').click(function () {
        $(this).parent().parent().nextAll('.toggle_target').slideToggle();
    });
});

$(function () {
    $('.toggle_private_category_form').click(function () {
        $(this).nextAll('.toggle_private_category').slideToggle();
    });
});

$(function () {
    $('.toggle_idea_edit_form').click(function () {
        $(this).parent().parent().nextAll('.toggle_idea').slideToggle();
    });
});

$(function () {
    $(".btn_delete").click(function () {
        if (confirm("本当に削除しますか？")) {
            //そのままsubmit（削除）
        } else {
            //cancel
            return false;
        }
    });
});

$(function () {
    $('.toggle_task_form').click(function () {
        $(this).nextAll('.toggle_task').slideToggle();
    });
});

$(function () {
    $('.toggle_done_form').click(function () {
        $(this).parent().parent().nextAll('.toggle_done').slideToggle();
    });
});

$(function () {
    $('.toggle_book_edit_form').click(function () {
        $(this).parent().parent().nextAll('.toggle_book').slideToggle();
    });
});

// $(function() {
//     $('.sort_private_category').change(function () {
//         $('.form_sort_private_category').submit();
//     });
// });

// $(function() {
//     $('.sort_is_done').change(function () {
//         $('.form_sort_is_done').submit();
//     });
// });

$(function () {
    $('.toggle_sort_form').click(function () {
        $(this).nextAll('.sort_form').slideToggle();
    });
});

$(function () {
    $('.edit_memo').click(function () {
        $(this).nextAll('.display_toggle2').slideToggle();
    });
});

$(function(){
    // 送信ボタンが1度クリックされたら、送信ボタンを非活性化する（二重submit対策）
    $('form').submit(function() {
      $("button[type='submit']").prop("disabled", true);
    });
  });