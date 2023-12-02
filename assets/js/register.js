$(document).ready(function () {

    // On click signup, hide login and show registration from
    $("#signup").click(function () {
        $("#first").slideUp("slow", function () {
            $("#second").slideDown("slow");
        });
    });

    // On click signup, hide login and show registration from
    $("#signin").click(function () {
        $("#second").slideUp("slow", function () {
            $("#first").slideDown("slow");
        });
    });
});