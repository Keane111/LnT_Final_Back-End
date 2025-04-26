<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/CreateItems.css') }}" rel="stylesheet">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100" style="background-color: #2e2e2e;">
        <div class="card p-4 shadow-lg" style="width: 500px;">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Add New Item</h3>
                <p class="text-muted">Fill in the item details below</p>
            </div>

            <form action="{{ route('add-item.post') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter item name" required>
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="" disabled selected>Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (Rp)</label>
                    <input type="number" name="price" id="price" class="form-control" placeholder="Enter price" required>
                    @error('price')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" required>
                    @error('quantity')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="photo" class="form-label">Item Photo</label>
                    <input type="file" name="photo" id="photo" class="form-control" accept="image/*" required>
                    @error('photo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn w-100 mb-3" style="background-color: #ffc107;">Add Item</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
