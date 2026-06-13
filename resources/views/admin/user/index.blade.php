<!DOCTYPE html>
<html lang="en">
<head>
    <title>Testing Manajemen User (BAAK)</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .alert-success { background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Daftar Pengguna Sistem (Sifas)</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status Akun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><strong>{{ $user->role->nama_role }}</strong></td>
                <td>
                    @if($user->is_active)
                        <span style="color: green;">● Aktif</span>
                    @else
                        <span style="color: red;">● Nonaktif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}">
                        <button type="button">Ubah Role</button>
                    </a>

                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        @if($user->is_active)
                            <button type="submit" style="background-color: #ffcccc; color: red;">Matikan Akun</button>
                        @else
                            <button type="submit" style="background-color: #ccffcc; color: green;">Aktifkan</button>
                        @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>