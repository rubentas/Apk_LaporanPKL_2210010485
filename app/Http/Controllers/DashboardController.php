<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    $data = [
      'totalDocuments' => Document::count(),
      'pendingDocuments' => Document::where('status', 'pending')->count(),
      'verifiedDocuments' => Document::where('status', 'verified')->count(),
      'rejectedDocuments' => Document::where('status', 'rejected')->count(),
      'recentDocuments' => Document::latest()->limit(5)->get(),
    ];

    return view('dashboard', $data);
  }
}