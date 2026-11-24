<?php

namespace App\Http\Controllers;

use App\Models\Buses;
use App\Models\Categories;
use App\Models\Complaints;
use App\Models\Stops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AduanController extends Controller
{
    public function index()
    {
        return view('Layout.home');
    }



    public function create(Request $request)
    {
        $categories = Categories::all();

        // Dropdown hanya menampilkan Bus dan Halte aktif.
        $buses = Buses::where('is_active', true)->get();
        $stops = Stops::where('is_active', true)->get();

        $selectedBusId = null;
        $selectedStopId = null;

        // Pemeriksaan QR Bus.
        if ($request->filled('bus_id')) {
            $selectedBusId = Buses::whereKey($request->query('bus_id'))
                ->where('is_active', true)
                ->value('id');

            if (!$selectedBusId) {
                return redirect()->route('aduan.inactive', [
                    'type' => 'bus',
                ]);
            }
        }

        // Pemeriksaan QR Halte.
        if ($request->filled('stop_id')) {
            $selectedStopId = Stops::whereKey($request->query('stop_id'))
                ->where('is_active', true)
                ->value('id');

            if (!$selectedStopId) {
                return redirect()->route('aduan.inactive', [
                    'type' => 'halte',
                ]);
            }
        }

        return view('Aduan.create', compact(
            'categories',
            'buses',
            'stops',
            'selectedBusId',
            'selectedStopId'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();

        $validated = $request->validate([
            'nama_pengadu' => $user
                ? 'nullable|string|max:50'
                : 'required|string|max:50',

            'judul' => 'required|string|max:125',
            'categories' => 'required|exists:categories,id',
            'nama_bus' => [
                'nullable',
                Rule::exists('buses', 'id')->where('is_active', true),
            ],

            'stop_id' => [
                'nullable',
                Rule::exists('stops', 'id')->where('is_active', true),
            ],
            'isi_aduan' => 'required|string',

            'dokumentasi' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:2048',
            ],
        ], [
            'nama_pengadu.required' => 'Nama pengadu wajib diisi.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'categories.required' => 'Silakan pilih kategori pengaduan.',
            'categories.exists' => 'Kategori pengaduan tidak valid.',
            'nama_bus.exists' => 'Bus tidak ditemukan atau sudah tidak aktif.',
            'stop_id.exists' => 'Halte tidak ditemukan atau sudah tidak aktif.',
            'isi_aduan.required' => 'Isi pengaduan wajib diisi.',
            'dokumentasi.mimes' => 'Dokumentasi harus berupa JPG, JPEG, PNG, atau PDF.',
            'dokumentasi.max' => 'Ukuran dokumentasi maksimal 2 MB.',
        ]);

        $dokumentasi = null;

        if ($request->hasFile('dokumentasi')) {
            $dokumentasi = $request->file('dokumentasi')
                ->store('dokumentasi', 'public');
        }

        $complaint = Complaints::create([
            'user_id' => $user?->id,
            'categories_id' => $validated['categories'],
            'judul' => $validated['judul'],
            'nama_pengadu' => $user?->name ?? $validated['nama_pengadu'],
            'bus_id' => $validated['nama_bus'] ?? null,
            'stop_id' => $validated['stop_id'] ?? null,
            'isi_aduan' => $validated['isi_aduan'],
            'dokumentasi' => $dokumentasi,
            'status_aduan' => 'diajukan',
        ]);

        return redirect()
            ->route('aduan.success')
            ->with('success', 'Pengaduan berhasil dikirim!')
            ->with('no_aduan', $complaint->no_aduan);
    }

    public function track(Request $request)
    {
        $request->validate([
            'no_aduan' => 'nullable|string|max:50',
        ]);

        $complaint = null;
        $searched = $request->filled('no_aduan');

        if ($searched) {
            $complaint = Complaints::with([
                'categories',
                'bus',
                'stop',
                'replays' => function ($query) {
                    $query->latest();
                },
            ])
                ->where('no_aduan', trim($request->no_aduan))
                ->first();
        }

        return view('Aduan.track', compact(
            'complaint',
            'searched'
        ));
    }

    public function history()
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('web')->user();

        $complaints = $user->complaints()
            ->with(['categories', 'bus', 'stop'])
            ->latest()
            ->paginate(10);

        return view('Aduan.history', compact('complaints'));
    }

    public function detail(int $id)
    {
        $user = Auth::guard('web')->user();

        $complaint = Complaints::with([
            'categories',
            'bus',
            'stop',
            'replays.petugas',
            'statusHistories.user',
        ])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return view('Aduan.detail', compact('complaint'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
