<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    public function index()
    {
        // Mengambil semua posting
        $quote = Quote::all();

        // Menyiapkan data untuk ditampilkan di tampilan
        $data = [
            'judul' => "Semua Kutipan",
            'quote' => $quote,
        ];

        // Mengembalikan tampilan dengan data yang disiapkan
        return view('admin.blog.kutipan', $data);
    }

    public function getQuote(Request $request)
    {
        if ($request->ajax()) {
            $quote = Quote::select(['id', 'quote', 'quote_by', 'created_at', 'updated_at']);
            return DataTables::of($quote)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-xs edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-btn"><i class="fas fa-trash-alt"></i> Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function simpanQuote(Request $request)
    {
        // Validasi tambahan untuk memastikan nama kategori unik
        $validator = Validator::make($request->all(), [
            'quote_name' => 'required|string|max:255',
            'quote_by_name' => 'required|string|max:255',
        ], [
            'quote_name.required' => 'Isi kutipan harus diisi',
            'quote_by_name.required' => 'Kolom penulis kutipan harus diisi.',

        ]);

        if ($validator->fails()) {
            // Mengembalikan pesan error validasi dalam format JSON
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        Quote::create([
            'quote' => $request->quote_name,
            'quote_by' => $request->quote_by_name,
        ]);

        // Tambahkan pesan flash untuk ditampilkan menggunakan Toastr
        return response()->json(['message' => 'Kutipan berhasil ditambahkan.'], 200);
    }

    public function fetchQuoteById($id)
    {
        // Ambil data kategori berdasarkan ID
        $quote = Quote::findOrFail($id);

        // Kirim data kategori dalam format JSON
        return response()->json($quote);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'quote' => 'required|string|max:255',
            'quote_by' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // Update data kutipan berdasarkan ID
        $quote = Quote::findOrFail($id);
        $quote->quote = $request->quote;
        $quote->quote_by = $request->quote_by;
        $quote->save();

        // Kirim respons sukses
        return response()->json(['message' => 'Kutipan berhasil diperbarui.']);
    }



    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);

        // Hapus kategori
        $quote->delete();

        // Mengembalikan respons JSON dengan pesan sukses
        return response()->json([
            'type' => 'success',
            'message' => 'Kutipan berhasil dihapus.'
        ]);
    }
}
