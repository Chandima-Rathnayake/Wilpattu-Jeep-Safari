document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const submitButton = document.getElementById('submitButton');
    submitButton.style.display = 'none'; // Hide the submit button

    const formData = new FormData(this); // Create FormData object

    // Send form data using fetch API
    fetch('../classes/feedback.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        // Check if the feedback submission was successful
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '../public/feedback_display.html'; // Redirect after success
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                submitButton.style.display = 'inline-block'; // Show the button again on error
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'An unexpected error occurred.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            submitButton.style.display = 'inline-block'; // Show the button again on error
        });
    });
});
