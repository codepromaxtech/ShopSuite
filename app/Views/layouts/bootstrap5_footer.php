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
    
    
    // Load saved theme on page load
    (function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
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
    
    // Close sidebar when clicking outside on mobile (but don't interfere with dropdowns)
    document.addEventListener('click', function(event) {
        // Skip if clicking on any dropdown
        if (event.target.closest('.dropdown')) {
            return;
        }
        
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        
        if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('show')) {
            if (!sidebar.contains(event.target) && (!toggle || !toggle.contains(event.target))) {
                sidebar.classList.remove('show');
            }
        }
    });
    
    // Confirm logout function
    function confirmLogout(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Logout?',
            text: 'Are you sure you want to logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-box-arrow-right"></i> Yes, Logout',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = event.target.closest('a').href;
            }
        });
        
        return false;
    }
    
    // Initialize user dropdown on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✅ Bootstrap 5 loaded');
        
        const userDropdownElement = document.getElementById('userDropdown');
        if (!userDropdownElement) {
            console.warn('⚠️ User dropdown element not found!');
            return;
        }
        
        console.log('✅ User dropdown found');
        
        let isOpening = false;
        let openTime = 0;
        
        // Prevent dropdown from closing immediately after opening
        userDropdownElement.addEventListener('show.bs.dropdown', function (e) {
            console.log('🔽 Dropdown showing');
            isOpening = true;
        });
        
        userDropdownElement.addEventListener('shown.bs.dropdown', function () {
            console.log('✅ Dropdown shown');
            openTime = Date.now();
            isOpening = false;
        });
        
        userDropdownElement.addEventListener('hide.bs.dropdown', function (e) {
            const timeSinceOpen = Date.now() - openTime;
            console.log('🔼 Dropdown hiding (open for ' + timeSinceOpen + 'ms)');
            
            // Prevent immediate close (less than 300ms)
            if (timeSinceOpen < 300) {
                console.log('⛔ PREVENTED immediate close!');
                e.preventDefault();
                return false;
            }
        });
        
        userDropdownElement.addEventListener('hidden.bs.dropdown', function () {
            console.log('❌ Dropdown hidden');
            openTime = 0;
        });
    });
    </script>
</body>
</html>
