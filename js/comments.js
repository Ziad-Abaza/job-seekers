document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("commentForm").addEventListener("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "submit_comment.php", true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        document.getElementById("comment").value = '';

                        var commentSection = document.querySelector(".modal-body");
                        var newComment = document.createElement("div");
                        newComment.className = "mb-3";
                        newComment.innerHTML = '<div class="comment d-flex gap-1"><p class="comment-user text-primary"><em>' + response.user_name + ':</em></p><p class="comment-content"><strong>' + response.content + '</strong></p></div>';
                        commentSection.appendChild(newComment);
                    } else {
                        console.error('Error:', response.message);
                    }
                } catch (e) {
                    console.error('Invalid JSON response:', xhr.responseText);
                }
            } else {
                console.error('Error:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Error:', xhr.statusText);
        };

        xhr.send(formData);
    });
});