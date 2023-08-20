// Get the navigation bar element
var navbar = document.querySelector('.navbar');

// Get the initial offset position of the navigation bar
var sticky = navbar.offsetTop;

// Function to add or remove the "sticky" class based on scroll position
function handleScroll() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add('navbar-sticky');
    } else {
        navbar.classList.remove('navbar-sticky');
    }
}

// Listen for scroll events and call the handleScroll function
window.addEventListener('scroll', handleScroll);


// Drop Down JS 

document.addEventListener('DOMContentLoaded', function() {
    // Drop Down JS 

    // Custom dropdown logic
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const text = this.textContent;
            document.getElementById('job_id').value = value;
            document.querySelector('#jobDropdown button').textContent = text;
            dropdownMenu.style.display = 'none';
            // Update the hidden input field with the selected consultant's ID
            document.getElementById('con_id').value = value;
        });
    });

    document.querySelector('.dropdown-toggle').addEventListener('click', function() {
        if (dropdownMenu.style.display === 'none') {
            dropdownMenu.style.display = 'block';
        } else {
            dropdownMenu.style.display = 'none';
        }
    });
});


