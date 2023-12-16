$(document).ready(function () {

    $('#search_text_input').focus(function () {
       if(window.matchMedia("(min-width:800px)").matches) {
           $(this).animate({width: '250px'}, 450);
       }
    });

    $('.button_holder').on('click', function () {
       document.search_form.submit();
    });


    // Button for profile post
    $('#submit_profile_post').click(function () {

        $.ajax({
            type: "POST",
            url: "includes/handlers/ajax_submit_profile_post.php",
            data: $('form.profile_post').serialize(),
            success: function (msg) {
                $('#post_form').modal('hide');
                location.reload();
            },
            error: function () {
                alert('Failure');
            }
        });
    });
});

function getDropdownData(user, type) {

    if ($(".dropdown_data_window").css("height") == "0px") {
        var pageName;

        if (type === 'notification') {
            pageName = "ajax_load_notifications.php";
            $("span").remove("#unread_notification");
        } else if (type === 'message') {
            pageName = "ajax_load_messages.php";
            $("span").remove("#unread_message");
        }

        var ajaxreq = $.ajax({
            url: "includes/handlers/" + pageName,
            type: "POST",
            data: "page=1&userLoggedIn=" + user,
            cache: false,

            success: function (response) {
                $(".dropdown_data_window").html(response);
                $("#dropdown_data_type").val(type);
                $(".dropdown_data_window").addClass('dropdown_data_window--active');
            }
        });

    } else {
        $(".dropdown_data_window").html("");
        $(".dropdown_data_window").removeClass('dropdown_data_window--active');

    }

}

function getUsers(value, user) {
    $.post("includes/handlers/ajax_friend_search.php", {query: value, userLoggedIn: user}, function (data) {
        $(".results").html(data);
    });
}

function handleOnKeyUpUserSearch(inputValue, loggedInUser) {
    getUsers(inputValue, loggedInUser);
}