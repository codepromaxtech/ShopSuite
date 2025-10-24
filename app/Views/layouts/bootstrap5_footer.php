<?php
/**
 * Modern Bootstrap 5 Footer Layout for ShopSuite
 */
?>
        </div>
        <!-- /.content-area -->
        
        <!-- Footer -->
        <footer class="mt-5 py-4 bg-white border-top">
            <div class="container-fluid px-4">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <small class="text-muted">
                            &copy; <?= date('Y') ?> <strong>ShopSuite</strong> · Version <?= esc(config('App')->application_version) ?>
                        </small>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> <span id="liveclock"></span>
                        </small>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.main-content -->

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    
    <script>
    // Toggle Sidebar for Mobile
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
    
    // Toggle Dark Mode
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        // Update icons
        const themeIcon = document.getElementById('theme-icon');
        const themeIconDropdown = document.getElementById('theme-icon-dropdown');
        const themeText = document.getElementById('theme-text');
        
        if (newTheme === 'dark') {
            if (themeIcon) themeIcon.className = 'bi bi-sun';
            if (themeIconDropdown) themeIconDropdown.className = 'bi bi-sun me-2';
            if (themeText) themeText.textContent = 'Light Mode';
        } else {
            if (themeIcon) themeIcon.className = 'bi bi-moon-stars';
            if (themeIconDropdown) themeIconDropdown.className = 'bi bi-moon-stars me-2';
            if (themeText) themeText.textContent = 'Dark Mode';
        }
    }
    
    // Load saved theme on page load
    (function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        
        const themeIcon = document.getElementById('theme-icon');
        const themeIconDropdown = document.getElementById('theme-icon-dropdown');
        const themeText = document.getElementById('theme-text');
        
        if (savedTheme === 'dark') {
            if (themeIcon) themeIcon.className = 'bi bi-sun';
            if (themeIconDropdown) themeIconDropdown.className = 'bi bi-sun me-2';
            if (themeText) themeText.textContent = 'Light Mode';
        }
    })();
    
    // Live Clock
    function updateClock() {
        const now = new Date();
        const options = { 
            year: 'numeric', 
            month: '2-digit', 
            day: '2-digit',
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true
        };
        const timeString = now.toLocaleString('en-US', options);
        document.getElementById('liveclock').textContent = timeString;
    }
    
    setInterval(updateClock, 1000);
    updateClock();
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        
        if (window.innerWidth <= 768 && sidebar.classList.contains('show')) {
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
    </script>
</body>
</html>
