$(document).ready(function () {

    function getUsers(value, user) {
        $.post("includes/handlers/ajax_friend_search.php", {query: value, userLoggedIn:user}, function (data) {
            $(".results").html(data);
        });
    }

    $('#search_text_input').keyup(function() {
        let loggedInUser = $(this).attr('data-logged-in-user');
        let inputValue = $(this).val();
        getUsers(inputValue, loggedInUser);
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