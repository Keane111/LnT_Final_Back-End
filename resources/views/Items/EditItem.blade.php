<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Item</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100" style="background-color: #2e2e2e;">
        <div class="card p-4 shadow-lg" style="width: 500px;">
            <h4 class="text-center mb-4">Edit Item</h4>

            <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Item Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price (Rp)</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ $item->price }}" required>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $item->quantity }}" required>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Change Photo (optional)</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                    <small class="text-muted">Current: {{ $item->photo }}</small>
                </div>

                <button type="submit" class="btn w-100 text-dark" style="background-color: #ffc107;">Update Item</button>
            </form>
        </div>
    </div>
</body>
</html>