<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Proposal;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $stats = [
            'total_proposals' => Proposal::count(),
            'pending' => Proposal::where('status', 'menunggu_penetapan')->count(),
            'assigned' => Proposal::where('status', 'pembimbing_ditentukan')->count(),
            'total_dosen' => Dosen::count(),
        ];

        // Grafik proposal per minggu (4 minggu terakhir)
        $proposalsPerWeek = Proposal::select(
            DB::raw('WEEK(created_at) as week'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subWeeks(4))
        ->groupBy('week')
        ->get();

        // Beban pembimbing per dosen
        $dosenBeban = Dosen::select('id', 'nama', 'bidang_penelitian', 'kuota_bimbingan', 'kuota_terpakai')
            ->orderBy('kuota_terpakai', 'desc')
            ->get();

        return view('admin.dashboard', compact('stats', 'proposalsPerWeek', 'dosenBeban'));
    }

    /**
     * List semua proposals
     */
    public function listProposals()
    {
        $proposals = Proposal::with(['mahasiswa', 'dosenPembimbing'])
            ->latest()
            ->paginate(15);

        return view('admin.proposals', compact('proposals'));
    }

    /**
     * Detail proposal & rekomendasi
     */
    public function showProposal($id)
    {
        $proposal = Proposal::with([
            'mahasiswa',
            'recommendations.dosen',
            'dosenPembimbing'
        ])->findOrFail($id);

        return view('admin.proposal-detail', compact('proposal'));
    }

    /**
     * Assign dosen pembimbing (manual)
     */
    public function assignDosen(Request $request, $proposalId)
    {
        $request->validate([
            'dosen_ids' => 'required|array|min:1|max:2',
            'dosen_ids.*' => 'exists:dosen,id',
            'catatan' => 'nullable|string'
        ]);

        $proposal = Proposal::findOrFail($proposalId);
        $selectedDosen = $request->dosen_ids;

        // Cek kuota semua dosen
        foreach ($selectedDosen as $dosenId) {
            $dosen = Dosen::findOrFail($dosenId);
            if ($dosen->isKuotaPenuh()) {
                return back()->with('error', "Kuota dosen {$dosen->nama} sudah penuh!");
            }
        }

        // Kurangi kuota dosen lama (jika ada)
        if ($proposal->dosen_pembimbing_id) {
            $old1 = Dosen::find($proposal->dosen_pembimbing_id);
            if ($old1) $old1->decrement('kuota_terpakai');
        }

        if ($proposal->dosen_pembimbing_id_2) {
            $old2 = Dosen::find($proposal->dosen_pembimbing_id_2);
            if ($old2) $old2->decrement('kuota_terpakai');
        }

        // Simpan dosen baru
        $proposal->update([
            'dosen_pembimbing_id' => $selectedDosen[0] ?? null,
            'dosen_pembimbing_id_2' => $selectedDosen[1] ?? null,
            'status' => 'pembimbing_ditentukan',
            'assigned_by' => Auth::id(),
            'assigned_at' => now(),
            'catatan_admin' => $request->catatan
        ]);

        // Tambah kuota baru
        foreach ($selectedDosen as $dosenId) {
            Dosen::find($dosenId)->increment('kuota_terpakai');
        }

        // Log aktivitas
        ActivityLog::log(
            Auth::id(),
            'Assign Dosen Pembimbing',
            "Admin " . Auth::user()->name . " menetapkan dosen pembimbing untuk proposal: " . $proposal->judul,
            $proposal->id
        );

        return redirect()->route('admin.proposals')
            ->with('success', 'Dosen pembimbing berhasil ditetapkan!');
    }

    /**
     * Auto-assign dosen (otomatis pilih ranking 1)
     */
    public function autoAssign($proposalId)
    {
        $proposal = Proposal::with('recommendations.dosen')->findOrFail($proposalId);

        // Ambil rekomendasi tertinggi yang kuotanya tidak penuh
        $topRecommendation = $proposal->recommendations()
            ->whereHas('dosen', function($q) {
                $q->whereRaw('kuota_terpakai < kuota_bimbingan');
            })
            ->orderBy('rank')
            ->first();

        if (!$topRecommendation) {
            return back()->with('error', 'Tidak ada dosen dengan kuota tersedia!');
        }

        $dosen = $topRecommendation->dosen;

        // Jika sudah ada dosen sebelumnya
        if ($proposal->dosen_pembimbing_id) {
            $oldDosen = Dosen::find($proposal->dosen_pembimbing_id);
            if ($oldDosen) {
                $oldDosen->decrement('kuota_terpakai');
            }
        }

        // Update proposal
        $proposal->update([
            'dosen_pembimbing_id' => $dosen->id,
            'status' => 'pembimbing_ditentukan',
            'assigned_by' => Auth::id(),
            'assigned_at' => now(),
            'catatan_admin' => 'Auto-assign berdasarkan skor rekomendasi tertinggi'
        ]);

        // Update kuota
        $dosen->increment('kuota_terpakai');

        // Log
        ActivityLog::log(
            Auth::id(),
            'Auto-Assign Dosen',
            "Sistem auto-assign " . $dosen->nama . " untuk proposal: " . $proposal->judul,
            $proposal->id
        );

        return back()->with('success', 'Dosen berhasil di-assign otomatis!');
    }

    /**
     * Activity logs
     */
    public function activityLogs()
    {
        $logs = ActivityLog::with(['user', 'proposal'])
            ->latest()
            ->paginate(20);

        return view('admin.activity-logs', compact('logs'));
    }

    public function destroy($id)
    {
        $proposal = Proposal::findOrFail($id);

        if ($proposal->dosen_pembimbing_id) {
            $dosen1 = Dosen::find($proposal->dosen_pembimbing_id);
            if ($dosen1 && $dosen1->kuota_terpakai > 0) {
                $dosen1->decrement('kuota_terpakai');
            }
        }

        if ($proposal->dosen_pembimbing_id_2) {
            $dosen2 = Dosen::find($proposal->dosen_pembimbing_id_2);
            if ($dosen2 && $dosen2->kuota_terpakai > 0) {
                $dosen2->decrement('kuota_terpakai');
            }
        }

        if ($proposal->file_proposal && Storage::disk('public')->exists($proposal->file_proposal)) {
            Storage::disk('public')->delete($proposal->file_proposal);
        }

        ActivityLog::log(
            auth()->id(),
            'Delete Proposal',
            'Menghapus proposal: ' . $proposal->judul,
            $proposal->id
        );

        // ✅ Hapus proposal
        $proposal->delete();

        return redirect()->route('admin.proposals')
            ->with('success', 'Proposal berhasil dihapus dan kuota dosen telah dikembalikan.');
    }
}