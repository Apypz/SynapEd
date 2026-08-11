<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function enroll(Request $request, Course $course)
    {
        $user = auth()->user();

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('learn', $course->slug)->with('info', 'Anda sudah terdaftar di kursus ini.');
        }

        // Create transaction
        $trxNumber = 'TRX-' . strtoupper(Str::random(6));
        $payment = Payment::create([
            'trx_number' => $trxNumber,
            'user_id' => $user->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'payment_method' => $request->input('payment_method', 'QRIS DANA'),
            'status' => $course->price == 0 ? 'Berhasil' : 'Berhasil', // Instant enrollment or admin verified
            'notes' => 'Pembelian langsung oleh siswa',
        ]);

        // Create Enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 0,
            'status' => 'active',
            'completed_lessons' => [],
        ]);

        return redirect()->route('dashboard')->with('success', 'Berhasil mendaftar kursus ' . $course->title . '!');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Akses khusus Admin');
        }

        $validated = $request->validate([
            'status' => 'required|in:Berhasil,Pending,Gagal',
        ]);

        $payment->status = $validated['status'];
        $payment->save();

        // If approved, ensure enrollment exists for user
        if ($validated['status'] === 'Berhasil') {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $payment->user_id,
                    'course_id' => $payment->course_id,
                ],
                [
                    'progress' => 0,
                    'status' => 'active',
                    'completed_lessons' => [],
                ]
            );
        }

        return redirect()->back()->with('success', 'Status transaksi ' . $payment->trx_number . ' diperbarui ke ' . $validated['status']);
    }
}
