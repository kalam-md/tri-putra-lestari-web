<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit()
    {
        return view('profil.edit');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('nama_lengkap', 'username', 'email');

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('public/profile/' . $user->photo);
            }
            $photoPath = $request->file('photo')->store('profile', 'public');
            $data['photo'] = basename($photoPath);
        }

        $user->update($data);

        alert()->success('Sukses', 'Profil berhasil diperbarui.');
        return redirect()->route('profile.edit');
    }
}
