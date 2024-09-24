document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("application-form");
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const commentSection = document.getElementById("comment-section");
    const commentInput = document.getElementById("comment");

    // Show/hide comment section based on the selected status
    statusRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "reject") {
                commentSection.style.display = "block";
                commentInput.required = true; // Make comment required
            } else {
                commentSection.style.display = "none";
                commentInput.required = false; // Comment not required
                commentInput.value = ""; // Clear comment input
            }
        });
    });

    // Form submission validation
    form.addEventListener("submit", function (event) {
        const selectedStatus = Array.from(statusRadios).find(r => r.checked);
        
        // Check if a status is selected
        if (!selectedStatus) {
            alert("Please select an application status (Accept or Reject).");
            event.preventDefault(); // Prevent form submission
            return;
        }

        // Validate comment only if the application is rejected
        if (selectedStatus.value === "reject" && commentInput.value.trim() === "") {
            alert("Please provide a comment for rejecting the application.");
            event.preventDefault(); // Prevent form submission
            return;
        }

        // Validate comment length (between 5 and 200 characters)
        const commentRegex = /^[a-zA-Z0-9\s.,!?]{5,200}$/;
        if (commentInput.value && !commentRegex.test(commentInput.value)) {
            alert("Comment must be between 5 and 200 characters long and can include letters, numbers, and common punctuation.");
            event.preventDefault(); // Prevent form submission
        }
    });
});
