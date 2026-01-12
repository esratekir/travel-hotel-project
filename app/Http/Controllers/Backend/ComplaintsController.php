<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintsController extends Controller
{
    public function AllComplaints() {
        $all_complaints = Complaint::with(['user','reported_user'])->orderBy('id', 'desc')->get();
        return view('backend.complaints.all_complaints', compact('all_complaints'));
    }

    public function ComplaintProcessed($id) {
        $complaint_id = Complaint::findOrFail($id);
        $complaint_id->status = 1;
        $complaint_id->save();
        return redirect()->back();
    }

    public function ComplaintNotProcessed($id) {
        $complaint_id = Complaint::findOrFail($id);
        $complaint_id->status = 0;
        $complaint_id->save();

        $complaint_id->delete();
        return redirect()->back();
    }

}
