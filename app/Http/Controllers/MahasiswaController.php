<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\MatchingService;

class MahasiswaController extends Controller
{
    protected $matchingService;

    public function __construct(MatchingService $matchingService)
    {
        $this->middleware('auth');
        $this->middleware('role:mahasiswa');
        $this->matchingService = $matchingService;
    }

    /**
     * Dashboard Mahasiswa
     */
    public function dashboard()
    {
        $mahasiswa = Auth::user();
        $proposals = Proposal::where('mahasiswa_id', $mahasiswa->id)
            ->with('dosenPembimbing')
            ->latest()
            ->get();

        return view('mahasiswa.dashboard', compact('proposals'));
    }

    /**
     * Tampilkan form create proposal
     */
    public function createProposal()
    {
        return view('mahasiswa.create-proposal');
    }

    /**
     * Simpan proposal baru
     */
    public function storeProposal(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255|unique:proposals,judul',
            'abstrak' => 'required|string',
            'keywords' => 'required|string',
            'file_proposal' => 'nullable|file|mimes:pdf|max:5120'
        ], [
            'judul.required' => 'Judul proposal wajib diisi',
            'judul.unique' => 'Judul proposal sudah pernah digunakan, pilih judul lain',
            'abstrak.required' => 'Abstrak wajib diisi',
            'keywords.required' => 'Kata kunci wajib diisi',
            'file_proposal.mimes' => 'File harus berformat PDF',
            'file_proposal.max' => 'Ukuran file maksimal 5MB'
        ]);

        $mahasiswa = Auth::user();

        // Upload file jika ada
        $filePath = null;
        if ($request->hasFile('file_proposal')) {
            $file = $request->file('file_proposal');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('proposals', $fileName, 'public');
        }

        // Buat proposal
        $proposal = Proposal::create([
            'mahasiswa_id' => $mahasiswa->id,
            'judul' => $request->judul,
            'abstrak' => $request->abstrak,
            'keywords' => $request->keywords,
            'file_proposal' => $filePath,
            'status' => 'menunggu_penetapan'
        ]);

        // Generate rekomendasi dosen otomatis
        $this->matchingService->generateRecommendations($proposal);

        // Log aktivitas
        ActivityLog::log(
            $mahasiswa->id,
            'Submit Proposal',
            "Mahasiswa {$mahasiswa->name} ({$mahasiswa->nim}) mengajukan proposal: {$proposal->judul}",
            $proposal->id
        );

        return redirect()->route('mahasiswa.proposal.show', $proposal->id)
            ->with('success', 'Proposal berhasil diajukan! Sistem telah menghasilkan rekomendasi dosen pembimbing.');
    }

    /**
     * Tampilkan detail proposal
     */
    public function showProposal($id)
    {
        $proposal = Proposal::with(['recommendations.dosen', 'dosenPembimbing'])
            ->where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        return view('mahasiswa.show-proposal', compact('proposal'));
    }

    /**
     * Riwayat proposal
     */
    public function riwayat()
    {
        $proposals = Proposal::where('mahasiswa_id', Auth::id())
            ->with('dosenPembimbing')
            ->latest()
            ->paginate(10);

        return view('mahasiswa.riwayat', compact('proposals'));
    }
}