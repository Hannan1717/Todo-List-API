<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\userResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Validasi bahwa file avatar ada dan merupakan gambar
        $request->validate([
            'avatar' => 'required|image',
        ]);

        // Inisialisasi variabel avatar
        $avatar = null;

        // Jika file avatar ada dalam request, simpan file tersebut
        if ($request->hasFile('avatar')) {
            // Simpan file avatar di disk 'public'
            $avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // Update pengguna dengan path avatar yang baru
        $user = $request->user();
        $user->update([
            'avatar' => $avatar
        ]);

        // Kembalikan data pengguna yang sudah diperbarui menggunakan UserResource
        return new UserResource($user);
    }
}
