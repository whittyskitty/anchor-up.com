// jQuery(document).ready(function($) {

//     $.noConflict();

    
//     $('#the-list').sortable({

        

//         update: function(event, ui) {
//             alert("test");

//             // Update order in the database via an AJAX request
//             var postIDs = [];
//             $('#the-list').find('.column-title input[type="checkbox"]:checked').each(function() {
//                 postIDs.push($(this).val());
//             });

//             console.log(postIDs);
//             $.ajax({
//                 url: ajaxurl,
//                 type: 'POST',
//                 data: {
//                     action: 'update_team_member_order',
//                     post_ids: postIDs
//                 }
//             });
//         }
//     });
// });

jQuery(document).ready(function($) {
    $.noConflict();

    $('#the-list').sortable({
        update: function(event, ui) {
            // Your update code here
        }
    });
    
    $('#the-list').on('sortupdate', function(event, ui) {
        var postIDs = [];
        $('#the-list').find('tr').each(function() {
            // postIDs.push($(this).val());
            var row = $(this).closest('tr'); // Find the closest row
            var postID = row.attr('id').replace('post-', ''); // Extract the post ID from the row ID
            postIDs.push(postID);
        });

        console.log(postIDs);
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'update_team_member_order',
                post_ids: postIDs
            }
        });
    });
});