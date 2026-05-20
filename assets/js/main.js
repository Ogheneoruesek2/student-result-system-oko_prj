


  // Sidebar Toggle
  const wrapper = document.getElementById('wrapper');
  const menuToggle = document.getElementById('menu-toggle');

  // Add a click event listener to the toggle button
  menuToggle.addEventListener('click', function() {
    wrapper.classList.toggle('toggled');
  });

  // Dropdown Toggle
  const dropdownButton = document.getElementById('dropbtn');
  const dropdownMenu = document.getElementById('myDropdown');

  // Add a click event listener to the dropdown button
  dropdownButton.addEventListener('click', function() {
    dropdownMenu.classList.toggle('show');
  });

  // Close the dropdown if the user clicks outside of it
  document.addEventListener('click', function(event) {
    if (!event.target.matches('#dropbtn') && !event.target.closest('#myDropdown')) {
      dropdownMenu.classList.remove('show');
    }
  });


