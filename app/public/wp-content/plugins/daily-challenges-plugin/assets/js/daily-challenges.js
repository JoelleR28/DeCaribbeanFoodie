// jQuery(document).ready(function ($) {
//     $(".mark-complete-btn").on("click", function () {
//         let challenge_id = $(this).data("challenge-id");
//         let button = $(this);

//         $.ajax({
//             type: "POST",
//             url: my_plugin_ajax.ajaxurl, 
//             data: {
//                 action: "mark_challenge_complete",
//                 challenge_id: challenge_id,
//                 security: my_plugin_ajax.nonce 
//             },
//             success: function (response) {
//                 if (response.success) {
//                     button.text("Completed").prop("disabled", true);
//                     $("#user-points").text(response.data.points);
//                     $("#user-badge").text(response.data.badge);
//                 } else {
//                     alert("Error marking as completed.");
//                 }
//             }
//         });
//     });
// });
