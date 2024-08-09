<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $email = $request->input('email');
        $unsubscribeToken = Str::random(32); // Generate a random token

        Subscriber::create([
            'email' => $email,
            'unsubscribe_token' => $unsubscribeToken,
        ]);

        $senderName = get_setting('school_name', 'Default Sender Name');
        $unsubscribeLink = route('unsubscribe', ['token' => $unsubscribeToken]); // Generate unsubscribe link

        Mail::to($email)->send(new SubscriptionConfirmation($email, $senderName, $unsubscribeLink));

        return redirect()->back()->with('success', 'Berhasil! Pesan konfirmasi telah dikirim ke email anda.');
    }

    public function unsubscribe($token)
    {
        $subscriber = Subscriber::where('unsubscribe_token', $token)->first();

        if ($subscriber) {
            $subscriber->delete();
            return redirect('/')->with('success', 'Berhasil! Anda telah berhenti berlangganan.');
        }

        return redirect('/')->with('error', 'Invalid unsubscribe token.');
    }

    public function index()
    {

        $data = [
            'judul' => "Langganan",

        ];
        return view('admin.blog.subs', $data);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Subscriber::select(['id', 'email', 'created_at', 'updated_at']);
            return DataTables::of($data)
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->translatedFormat('d F Y - H:s'); // Format tanggal
                })
                ->make(true);
        }
    }
}
