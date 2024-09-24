document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("applicationForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        const formData = new FormData(this); // Collect form data

        fetch('../../controllers/ApplicationController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("response").innerHTML = data; // Display response
            document.getElementById("applicationForm").reset(); // Reset form
        })
        .catch(error => console.error('Error:', error));
    });
});
