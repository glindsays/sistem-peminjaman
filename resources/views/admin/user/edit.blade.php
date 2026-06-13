<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Role User</title>
</head>
<body>
    <h1>Ubah Role: {{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="role_id">Pilih Role Baru:</label>
        <select name="role_id" id="role_id">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                    {{ ucfirst($role->nama_role) }}
                </option>
            @endforeach
        </select>

        <br><br>
        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('admin.users.index') }}">Batal</a>
    </form>
</body>
</html>