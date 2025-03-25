            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-4 py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> eClinic Management System</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p class="mb-0">Versi 1.0</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS & Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Custom Script -->
    <script>
        // Enable tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        // Initialize DataTables if not already done in page-specific script
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('table.dataTable') === false) {
                $('table.dataTable').DataTable({
                    "responsive": true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                    }
                });
            }
        });
    </script>
</body>
</html> 