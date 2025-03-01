<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerkasController extends Controller
{
    public function showBerkas($jenisBerkas, $filename)
    {
        $user = Auth::user();
        $role = $user->role;
        $rt_rw = $user->rt_rw;

        $filename = basename($filename);

        $column = '';
        $folderPath = '';

        switch ($jenisBerkas) {
            case 'kk':
                $column = 'kk';
                $folderPath = 'documents/kk';
                break;
            case 'ktp':
                $column = 'ktp';
                $folderPath = 'documents/ktp';
                break;
            default:
                return redirect()->route('dashboard')->with('error', 'Jenis berkas tidak valid.');
        }

        $surat = Surat::whereHas('suratable', function ($query) use ($filename, $column, $folderPath) {
            $query->where($column, $folderPath . '/' . $filename)
                ->orWhere($column, 'like', '%/' . $filename);
        })->first();

        if (!$surat) {
            return redirect()->route('dashboard')->with('error', 'Berkas tidak ditemukan.');
        }

        $isOwner = $surat->user_id == $user->id;
        $isAdmin = $role === 'admin';
        $isRt = ($role === 'rt' && $surat->rt_rw == $rt_rw);

        if (!$isOwner && !$isAdmin && !$isRt) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk melihat berkas ini.');
        }

        $path = storage_path("app/private/documents/$jenisBerkas/$filename");

        if (!file_exists($path)) {
            return redirect()->route('dashboard')->with('error', 'Berkas tidak ditemukan.');
        }

        $contentType = mime_content_type($path);
        return response()->file($path, [
            'Content-Type' => $contentType,
        ]);
    }

    public function showKK($filename)
    {
        return $this->showBerkas('kk', $filename);
    }

    public function showKTP($filename)
    {
        return $this->showBerkas('ktp', $filename);
    }
}
