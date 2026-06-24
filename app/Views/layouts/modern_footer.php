            </main>
        </div>
    </div>
    
    <!-- Toast Container (for notifications) -->
    <div class="toast-container"></div>
    
    <!-- Additional Page-Specific JavaScript -->
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?= base_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Inline Scripts -->
    <?php if (isset($inline_scripts)): ?>
        <script>
            <?= $inline_scripts ?>
        </script>
    <?php endif; ?>
</body>
</html>
