<div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="brandForm">
                @csrf
                <input type="hidden" id="brandId" name="id">

                <div class="modal-header">
                    <h5 class="modal-title" id="brandModalLabel">Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" id="code" name="code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>

                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Wait for the window to load to ensure all elements are available
    window.onload = function() {
        var nameInput = document.getElementById('name');
        var slugInput = document.getElementById('slug');
        var codeInput = document.getElementById('code');

        // Check if elements are correctly selected
        console.log(nameInput, slugInput, codeInput);

        // Generate code automatically when the page loads
        if (codeInput) {
            codeInput.value = generateRandomCode();
        }

        if (nameInput) {
            nameInput.addEventListener('input', function() {
                var name = nameInput.value;
                var slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            });
        }

        function generateRandomCode() {
            var letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var digits = '0123456789';
            var letter = letters.charAt(Math.floor(Math.random() * letters.length));
            var number = '';
            for (var i = 0; i < 4; i++) {
                number += digits.charAt(Math.floor(Math.random() * digits.length));
            }
            return 'B0' + letter + number;
        }
    };
</script>
